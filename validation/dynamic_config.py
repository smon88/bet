import random

# --- Listas de opciones para User-Agent ---
# Una lista más grande y variada es mejor
USER_AGENTS = [
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36",
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36",
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36",
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0",
    "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:132.0) Gecko/20100101 Firefox/132.0",
]

# --- Lista de ubicaciones en Colombia (Latitud, Longitud, Ciudad) ---
COLOMBIAN_LOCATIONS = [
    {"lat": 4.7110, "lon": -74.0721, "city": "Bogotá"},
    {"lat": 6.2442, "lon": -75.5812, "city": "Medellín"},
    {"lat": 10.9639, "lon": -74.7964, "city": "Barranquilla"},
    {"lat": 3.4516, "lon": -76.5319, "city": "Cali"},
    {"lat": 7.1254, "lon": -73.1198, "city": "Bucaramanga"},
    {"lat": 1.2136, "lon": -77.2811, "city": "Pasto"},
    {"lat": 4.1355, "lon": -73.1623, "city": "Villavicencio"},
]

def get_random_config():
    """
    Genera una configuración de navegador completamente aleatoria.
    """
    # 1. Elegir una ubicación aleatoria en Colombia
    location = random.choice(COLOMBIAN_LOCATIONS)
    
    # 2. Generar un viewport aleatorio pero común
    viewport_width = random.choice([1920, 1366, 1440, 1536])
    viewport_height = random.choice([1080, 768, 900, 864])

    # 3. Elegir un User-Agent aleatorio
    user_agent = random.choice(USER_AGENTS)

    return {
        "user_agent": user_agent,
        "viewport": {"width": viewport_width, "height": viewport_height},
        "locale": "es-CO",
        "timezone_id": "America/Bogota", # Mantener el timezone coherente
        "geolocation": {"latitude": location["lat"], "longitude": location["lon"]},
        "extra_http_headers": {
            "Accept-Language": "es-CO,es;q=0.9",
            "Accept-Encoding": "gzip, deflate, br",
            "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8",
            "Cache-Control": "max-age=0",
            "Sec-Ch-Ua": '"Google Chrome";v="131", "Chromium";v="131", "Not_A Brand";v="24"', # Esto puede ser dinámico también, pero es más complejo
            "Sec-Ch-Ua-Mobile": "?0",
            "Sec-Ch-Ua-Platform": '"Windows"', # Debería coincidir con el User-Agent
            "Sec-Fetch-Dest": "document",
            "Sec-Fetch-Mode": "navigate",
            "Sec-Fetch-Site": "none",
            "Sec-Fetch-User": "?1",
            "Upgrade-Insecure-Requests": "1",
        }
    }

def get_random_proxy():
    """
    Función placeholder para obtener un proxy.
    Aquí deberías integrar tu servicio de proxies.
    """
    # Ejemplo con un servicio de proxies ficticio
    # proxy_list = ["http://user1:pass1@proxy1.com:8080", "http://user2:pass2@proxy2.com:8080"]
    # return {"server": random.choice(proxy_list)}
    
    # Por ahora, devuelve None para no usar proxy
    return None