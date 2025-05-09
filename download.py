import instaloader
import os
from selenium import webdriver
from selenium.webdriver.firefox.options import Options
import time
import requests

# Set TEMP environment untuk menghindari error di Selenium
os.environ['TEMP'] = 'D:\\Temp'
os.environ['TMP'] = 'D:\\Temp'
os.makedirs('D:\\Temp', exist_ok=True)


def get_instagram_sessionid():
    options = Options()
    options.set_preference("dom.webdriver.enabled", False)
    options.set_preference("useAutomationExtension", False)

    # Gunakan profil Firefox yang sudah ada
    profile_path = "C:\\Users\\User\\AppData\\Roaming\\Mozilla\\Firefox\\Profiles\\6ib91lwe.default-release"
    options.add_argument(f"-profile")
    options.add_argument(profile_path)

    driver = webdriver.Firefox(options=options)
    driver.get("https://www.instagram.com/accounts/login/")
    print("🔑 Silakan login ke Instagram di browser yang muncul...")

    input("✅ Tekan ENTER setelah selesai login...")

    cookies = driver.get_cookies()
    driver.quit()

    for cookie in cookies:
        if cookie['name'] == 'sessionid':
            print("✅ Session ID ditemukan.")
            return cookie['value']

    print("❌ Session ID tidak ditemukan.")
    return None


def download_story_from_url(session_id, story_url):
    headers = {
        "User-Agent": "Mozilla/5.0",
        "Cookie": f"sessionid={session_id};"
    }

    print(f"🔍 Mengecek ketersediaan story: {story_url}")
    response = requests.get(story_url, headers=headers)

    if response.status_code == 404 or "Sorry, this story isn't available." in response.text:
        print("❌ Story sudah tidak tersedia atau dihapus.")
        return

    try:
        L = instaloader.Instaloader()
        L.context._session.cookies.set("sessionid", session_id, domain=".instagram.com")

        # Ekstrak username dari URL (contoh: https://www.instagram.com/stories/dstrr.ar_/3625... )
        parts = story_url.split("/")
        username = parts[4].strip()

        profile = instaloader.Profile.from_username(L.context, username)
        print(f"👤 Profil ditemukan: {profile.username}")

        print("📥 Mencoba mengunduh semua story terbaru...")
        for story in L.get_stories(userids=[profile.userid]):
            for item in story.get_items():
                L.download_storyitem(item, f"D:/insta_stories/stories_{username}")

        print("✅ Story berhasil diunduh.")

    except Exception as e:
        print(f"❌ Gagal mengunduh story: {e}")


# ==== Eksekusi utama ====
story_url = "https://www.instagram.com/stories/dstrr.ar_/3625836650239960398/"
sessionid = get_instagram_sessionid()

if sessionid:
    download_story_from_url(sessionid, story_url)
