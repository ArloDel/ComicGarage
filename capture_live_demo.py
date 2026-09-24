import time
import os
from io import BytesIO
from PIL import Image
from playwright.sync_api import sync_playwright

BASE_URL = "http://100.127.90.11"
ADMIN_URL = f"{BASE_URL}/admin"
OUTPUT_GIF_PATHS = [
    os.path.join("docs", "assets", "demo.gif"),
    os.path.join("docs", "assets", "comicgarage-demo.gif"),
    os.path.join("public", "images", "demo.gif")
]

frames = []
durations = []

def capture_frame(page, duration_ms=400, resize_width=1000):
    screenshot_bytes = page.screenshot(type="png", full_page=False)
    img = Image.open(BytesIO(screenshot_bytes)).convert("RGB")
    # Resize proportionally for a sharp, high-performance GIF
    ratio = resize_width / img.width
    new_size = (resize_width, int(img.height * ratio))
    img_resized = img.resize(new_size, Image.Resampling.LANCZOS)
    frames.append(img_resized)
    durations.append(duration_ms)

def run():
    print(f"Connecting to live instance at {BASE_URL}...")
    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True, channel="msedge")
        context = browser.new_context(
            viewport={"width": 1366, "height": 768},
            device_scale_factor=1.25
        )
        page = context.new_page()

        # ==========================================
        # 1. Hero & Vault Public Shelf Overview
        # ==========================================
        print("Capturing 1: Public Vault Shelf...")
        page.goto(BASE_URL, wait_until="networkidle", timeout=15000)
        page.wait_for_timeout(1000)
        capture_frame(page, 900)

        # Subtle smooth scroll down to shelf
        page.evaluate("window.scrollTo({ top: 350, behavior: 'smooth' })")
        page.wait_for_timeout(600)
        capture_frame(page, 700)

        page.evaluate("window.scrollTo({ top: 580, behavior: 'smooth' })")
        page.wait_for_timeout(600)
        capture_frame(page, 800)

        # ==========================================
        # 2. Live Instant Filter & Search Interaction
        # ==========================================
        print("Capturing 2: Search & Filter interaction...")
        search_input = page.query_selector("#comicSearch")
        if search_input:
            search_input.focus()
            page.wait_for_timeout(200)
            search_input.type("a", delay=80)
            capture_frame(page, 300)
            search_input.type("n", delay=80)
            capture_frame(page, 300)
            search_input.type("i", delay=80)
            capture_frame(page, 600)

            # Clear search
            clear_btn = page.query_selector("#searchClearBtn")
            if clear_btn:
                clear_btn.click()
                page.wait_for_timeout(300)
                capture_frame(page, 400)

        # Click Status filter chip: "Missing Gaps"
        incomplete_btn = page.query_selector('.filter-btn[data-status="incomplete"]')
        if incomplete_btn:
            incomplete_btn.click()
            page.wait_for_timeout(400)
            capture_frame(page, 700)

        # Click Status filter chip: "Complete"
        complete_btn = page.query_selector('.filter-btn[data-status="complete"]')
        if complete_btn:
            complete_btn.click()
            page.wait_for_timeout(400)
            capture_frame(page, 700)

        # Reset to All
        all_btn = page.query_selector('.filter-btn[data-status="all"]')
        if all_btn:
            all_btn.click()
            page.wait_for_timeout(300)

        # ==========================================
        # 3. Volume Inspector Modal
        # ==========================================
        print("Capturing 3: Volume Inspector Modal...")
        first_card = page.query_selector(".comic-card")
        if first_card:
            inspect_btn = first_card.query_selector(".btn-card-inspect") or first_card
            inspect_btn.click()
            page.wait_for_timeout(600)
            capture_frame(page, 1000)

            # Scroll inside modal grid if available
            vol_grid = page.query_selector("#modalVolGrid")
            if vol_grid:
                page.evaluate("document.getElementById('modalVolGrid').scrollTop = 120")
                page.wait_for_timeout(400)
                capture_frame(page, 600)

            # Close modal with Escape key
            page.keyboard.press("Escape")
            page.wait_for_timeout(400)
            capture_frame(page, 500)

        # ==========================================
        # 4. Ambient Lo-Fi YouTube Audio Deck
        # ==========================================
        print("Capturing 4: Ambient Audio Deck...")
        # Toggle BGM deck play button
        play_btn = page.query_selector("#bgmMainPlayBtn")
        if play_btn:
            play_btn.click()
            page.wait_for_timeout(500)
            capture_frame(page, 800)

        # Switch station to Ghibli Lofi
        ghibli_chip = page.query_selector('.bgm-station-chip[data-video-id="5qap5aO4i9A"]')
        if ghibli_chip:
            ghibli_chip.click()
            page.wait_for_timeout(500)
            capture_frame(page, 800)

        # ==========================================
        # 5. Filament v3 Admin Command Center
        # ==========================================
        print("Capturing 5: Filament v3 Admin Panel...")
        try:
            page.goto(ADMIN_URL, wait_until="networkidle", timeout=15000)
            page.wait_for_timeout(1000)
            capture_frame(page, 1000)

            # Scroll down to charts & widgets
            page.evaluate("window.scrollTo({ top: 400, behavior: 'smooth' })")
            page.wait_for_timeout(700)
            capture_frame(page, 900)

            page.evaluate("window.scrollTo({ top: 800, behavior: 'smooth' })")
            page.wait_for_timeout(700)
            capture_frame(page, 900)
        except Exception as admin_err:
            print(f"Admin capture notice: {admin_err}")

        browser.close()

    print(f"Total live frames captured: {len(frames)}")
    if not frames:
        print("Error: No frames captured!")
        return

    # Convert frames to an optimized animated GIF with adaptive palette
    print("Compiling frames into high-definition animated GIF...")
    palette_frames = []
    for f in frames:
        # Quantize to adaptive 256 color palette with dithering for rich dark UI tones
        pal = f.convert("P", palette=Image.Palette.ADAPTIVE, colors=256)
        palette_frames.append(pal)

    for out_path in OUTPUT_GIF_PATHS:
        os.makedirs(os.path.dirname(out_path), exist_ok=True)
        palette_frames[0].save(
            out_path,
            save_all=True,
            append_images=palette_frames[1:],
            duration=durations,
            loop=0,
            optimize=True
        )
        file_size = os.path.getsize(out_path)
        print(f"Saved: {out_path} ({file_size:,} bytes)")

if __name__ == "__main__":
    run()
