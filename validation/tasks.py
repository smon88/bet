# tasks.py
import asyncio
import random
from playwright.async_api import async_playwright
from celery_app import celery
from dynamic_config import get_random_config, get_random_proxy

# --- Excepción personalizada para errores técnicos ---
class TechnicalError(Exception):
    """Excepción para errores que deberían provocar un reintento de Celery."""
    pass

# --- Función auxiliar de tu código funcional ---
async def random_sleep(page, min_ms=500, max_ms=1500):
    """Espera un tiempo aleatorio para simular comportamiento humano."""
    await page.wait_for_timeout(random.randint(min_ms, max_ms))

# --- Tarea de Celery ---
@celery.task(bind=True, max_retries=3)
def run_automation(self, data):
    """
    Tarea de Celery para automatizar el login en Betplay.
    No reintenta fallos de login, solo errores técnicos.
    """
    loop = asyncio.new_event_loop()
    asyncio.set_event_loop(loop)
    try:
        result = loop.run_until_complete(_run_playwright_logic(data))
        return result
    except TechnicalError as e:
        print(f"⚠️ Error técnico detectado. Reintentando tarea en 60s. Error: {str(e)}")
        raise self.retry(exc=e, countdown=60)
    except Exception as e:
        print(f"❌ Error crítico no recuperable en la tarea de Celery: {str(e)}")
        return {"success": False, "message": f"Error crítico del sistema: {str(e)}"}
    finally:
        loop.close()

# --- Lógica principal de Playwright (basada en tu código funcional) ---
async def _run_playwright_logic(data):
    browser = None
    try:
        # 1. Generar configuración dinámica
        config = get_random_config()
        proxy_config = get_random_proxy()
        print(f"Usando configuración dinámica para la URL: {data['url']}")

        async with async_playwright() as p:
            browser = await p.chromium.launch(
                headless=True,
                proxy=proxy_config,
                args=[
                    "--no-sandbox",
                    "--disable-dev-shm-usage",
                    "--disable-blink-features=AutomationControlled",
                    "--disable-web-security",
                    "--disable-features=VizDisplayCompositor",
                    "--exclude-switches=enable-automation",
                ],
            )
            # 2. Crear contexto con la configuración dinámica
            context = await browser.new_context(**config)
            
            # 3. Script de ofuscación (el de tu código funcional)
            await context.add_init_script("""
                Object.defineProperty(navigator, 'webdriver', { get: () => undefined });
                Object.defineProperty(navigator, 'plugins', { get: () => [ { name: 'Chrome PDF Plugin', description: 'Portable Document Format', filename: 'internal-pdf-viewer' }, { name: 'Chrome PDF Viewer', description: 'Portable Document Format', filename: 'mhjfbmdgcfjbbpaeojofohoefgiehjai' }, { name: 'Native Client', description: 'Native Client', filename: 'internal-nacl-plugin' } ], });
                Object.defineProperty(navigator, 'languages', { get: () => ['es-CO', 'es', 'en'] });
                const getParameter = WebGLRenderingContext.prototype.getParameter; WebGLRenderingContext.prototype.getParameter = function(parameter) { if (parameter === 37445) return 'Intel Inc.'; if (parameter === 37446) return 'Intel Iris OpenGL Engine'; if (parameter === 37447) return 'Intel Inc.'; return getParameter(parameter); };
                const toDataURL = HTMLCanvasElement.prototype.toDataURL; HTMLCanvasElement.prototype.toDataURL = function(...args) { const context = this.getContext('2d'); if (context) { const imageData = context.getImageData(0, 0, this.width, this.height); for (let i = 0; i < imageData.data.length; i += 4) { imageData.data[i] += Math.random() * 0.1 - 0.05; imageData.data[i + 1] += Math.random() * 0.1 - 0.05; imageData.data[i + 2] += Math.random() * 0.1 - 0.05; } context.putImageData(imageData, 0, 0); } return toDataURL.apply(this, args); };
                Object.defineProperty(navigator, 'permissions', { get: () => ({ query: () => Promise.resolve({ state: 'granted' }), }), });
                Object.defineProperty(navigator, 'connection', { get: () => ({ effectiveType: '4g', rtt: 100, downlink: 10, }), });
            """)
            
            page = await context.new_page()
            await page.goto(data["url"], wait_until="domcontentloaded")
            print("Navegando a la página...")
            await page.wait_for_selector('body', state="visible", timeout=15000)
            await random_sleep(page, 1000, 2500)
            print("Página cargada correctamente.")

            # Manejo de cookies
            try:
                cookie_button_selector = 'button:has-text("Rechazar todo"), button:has-text("Rechazar"), button:has-text("Accept all"), button[data-cky-tag="detail-accept-button"]'
                await page.wait_for_selector(cookie_button_selector, state="visible", timeout=8000)
                await page.locator(cookie_button_selector).first.click(timeout=5000)
                print("Modal de cookies manejado.")
                await random_sleep(page, 500, 1500)
            except Exception:
                print("No se encontró el modal de cookies o ya estaba cerrado.")
                await page.evaluate("document.querySelectorAll('.cky-overlay, .modal-backdrop, .modal').forEach(el => el.remove());")

            # Llenar formulario
            print("Rellenando formulario...")
            await page.wait_for_selector('#userName', state="visible", timeout=10000)
            await page.locator('#userName').click()
            await random_sleep(page, 200, 500)
            await page.locator('#userName').fill(data["name"])
            await random_sleep(page, 500, 1200)
            await page.locator('#password').click()
            await random_sleep(page, 200, 500)
            await page.locator('#password').fill(data["email"])
            await random_sleep(page, 500, 1200)

            # ENVÍO DEL FORMULARIO Y VERIFICACIÓN (tu lógica mejorada)
            print("Enviando formulario...")
            await page.locator('#btnLoginPrimary').click()
            print("Verificando resultado del login...")

            async def check_for_success():
                # Ajusta esto si la URL de éxito es diferente
                return "dashboard" in page.url or "/home" in page.url

            async def check_for_error():
                error_selector = 'div[role="alert"], .toast-error, #toast-container div, .error-message'
                return await page.locator(error_selector).count() > 0

            try:
                done, pending = await asyncio.wait(
                    {
                        asyncio.create_task(check_for_success()),
                        asyncio.create_task(check_for_error())
                    },
                    timeout=10000,
                    return_when=asyncio.FIRST_COMPLETED
                )

                if not done:
                    print("⚠️ Tiempo de espera agotado. No se recibió respuesta del servidor.")
                    print("URL actual:", page.url)
                    return {"success": False, "message": "El servidor no respondió a tiempo."}
                else:
                    completed_task = done.pop()
                    if completed_task.get_coro().__name__ == check_for_success.__name__:
                        print("✅ Login exitoso. Redirigido a:", page.url)
                        return {"success": True, "message": "Login exitoso"}
                    elif completed_task.get_coro().__name__ == check_for_error.__name__:
                        error_selector = 'div[role="alert"], .toast-error, #toast-container div, .error-message'
                        error_message = "No se pudo extraer el mensaje de error."
                        try:
                            error_element = page.locator(error_selector).first
                            if await error_element.count() > 0:
                                error_message = await error_element.inner_text()
                        except Exception:
                            pass
                        print(f"❌ Se detectó error en el formulario: {error_message}")
                        # --- CAMBIO CLAVE: Fallo de login, NO se reintenta ---
                        return {"success": False, "message": f"Fallo de autenticación: {error_message}"}

            except Exception as e:
                print(f"⚠️ Ocurrió un error inesperado durante la verificación: {str(e)}")
                print("URL actual:", page.url)
                # Consideramos esto un error técnico para que pueda reintentarse
                raise TechnicalError(f"Error inesperado en verificación: {str(e)}")

    # --- CAPTURA DE ERRORES TÉCNICOS ---
    except (asyncio.TimeoutError, Exception) as e:
        error_type = type(e).__name__
        print(f"❌ Error técnico capturado ({error_type}): {str(e)}")
        # Relanzamos como TechnicalError para que Celery lo reintente
        raise TechnicalError(f"Error de conexión o timeout: {str(e)}")
    finally:
        if browser and browser.is_connected():
            print("Cerrando el navegador.")
            await browser.close()