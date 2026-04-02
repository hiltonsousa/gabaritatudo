import requests 
import unicodedata
import pyperclip
from time import sleep

BASE_URL = 'https://registro.br/v2/ajax/avail/raw/'

HEADERS = {
    "User-Agent": (
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) "
        "AppleWebKit/537.36 (KHTML, like Gecko) "
        "Chrome/122.0.0.0 Safari/537.36"
    ),
    "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "Accept-Language": "pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7",
    "Connection": "keep-alive"
}

def remove_accents(text):
    normalized = unicodedata.normalize('NFD', text)
    return ''.join(c for c in normalized if unicodedata.category(c) != 'Mn')

def check_domain(d):
    res = requests.get(f"{BASE_URL}{d}", headers=HEADERS)
    res.raise_for_status()
    return res.json().get('status', 1) == 0

if __name__ == "__main__":
    domains = pyperclip.paste().split()
    for d in domains:
        fqdn = f'{d}.com.br'
        print(f'{d}: {check_domain(fqdn)}')
        sleep(5)
