from time import sleep
from celery_app import celery
from playwright.sync_api import sync_playwright

@celery.task(bind=True, max_retries=3)
def run_automation(self, data):

    try:
        with sync_playwright() as p:
            browser = p.chromium.launch(
                headless=True,
                args=[
                    "--no-sandbox", 
                    "--disable-dev-shm-usage", 
                    "--start-maximized", 
                    "--disable-blink-features=AutomationControlled", 
                    "--incognito",
                    "--disable-gpu"
                ]
            )

            page = browser.new_page()
            page.goto(data["url"])
            page.wait_for_load_state("networkidle")

            print("Página cargada correctamente")

            page.evaluate("""
                document.querySelectorAll('.cky-overlay, .modal-backdrop')
                    .forEach(el => el.remove());
            """)

            sleep(3)

            # Llenar formulario
            #page.locator('text=Aceptar').nth(0).click()
            page.locator('xpath=/html/body/div[1]/div/div/div/div[2]/button[2]').click()
            sleep(2)
            page.locator('xpath=//input[@id="userName"]').fill(data["name"])
            sleep(2)
            page.locator('xpath=//input[@id="password"]').fill(data["email"])
            sleep(1)

            page.locator('xpath=//button[@id="btnLoginPrimary"]').click()

            page.wait_for_timeout(3000)
            
            # Validar errores
            error_count = page.locator('xpath=//div[@id="toast-container"]/div/div').count()
            if error_count > 0:
                browser.close()
                return {
                    "success": False,
                    "message": "Formulario contiene errores"
                }
            browser.close()
            return {
                "success": True,
                "message": "Formulario enviado correctamente"
            }

    except Exception as e:
        raise self.retry(exc=e, countdown=5)
