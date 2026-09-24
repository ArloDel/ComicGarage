<?php
/**
 * ComicGarage Animated Demo GIF Generator
 * Generates an aesthetic, animated demo GIF showing the key UI workflows:
 * 1. Vault Public Shelf & Spotlight
 * 2. Instant Search & Multi-Facet Filtering
 * 3. Volume Inspector Modal
 * 4. Ambient Lo-Fi YouTube Cyber-Deck
 * 5. Filament v3 Admin Dashboard & Analytics
 */

// Pure PHP GIF89a Animated GIF Encoder Class
class GifEncoder
{
    private $frames = [];
    private $delays = [];
    private $loop = 0;
    private $width;
    private $height;

    public function __construct(int $width, int $height, int $loop = 0)
    {
        $this->width = $width;
        $this->height = $height;
        $this->loop = $loop;
    }

    public function addFrame($gdImage, int $delayHundredths)
    {
        $this->frames[] = $gdImage;
        $this->delays[] = $delayHundredths;
    }

    public function encode(): string
    {
        $count = count($this->frames);
        if ($count === 0) return '';

        // Extract global palette from first frame or create standard dark palette
        ob_start();
        imagegif($this->frames[0]);
        $firstGif = ob_get_clean();

        // Parse screen descriptor & color table from first GIF
        $gctSize = 1 << ((ord($firstGif[10]) & 0x07) + 1);
        $gctLen = 3 * $gctSize;
        $gct = substr($firstGif, 13, $gctLen);

        // Header + Logical Screen Descriptor
        $out = "GIF89a";
        $out .= pack('vv', $this->width, $this->height);
        $out .= $firstGif[10]; // Packed field
        $out .= $firstGif[11]; // BG color index
        $out .= $firstGif[12]; // Pixel aspect ratio
        $out .= $gct;          // Global Color Table

        // Netscape 2.0 Loop Extension
        if ($this->loop >= 0) {
            $out .= "\x21\xFF\x0B" . "NETSCAPE2.0" . "\x03\x01" . pack('v', $this->loop) . "\x00";
        }

        // Add each frame
        for ($i = 0; $i < $count; $i++) {
            $frame = $this->frames[$i];
            $delay = $this->delays[$i];

            ob_start();
            imagegif($frame);
            $frameData = ob_get_clean();

            // Locate Graphic Control Extension and Image Descriptor
            $frameGctSize = 1 << ((ord($frameData[10]) & 0x07) + 1);
            $frameOffset = 13 + (3 * $frameGctSize);

            // Graphic Control Extension
            $out .= "\x21\xF9\x04\x04" . pack('v', $delay) . "\x00\x00";

            // Find Image Descriptor block (\x2C)
            $pos = strpos($frameData, "\x2C", 13);
            if ($pos !== false) {
                // Include local color table if present or use global
                $hasLocalTable = (ord($frameData[$pos + 9]) & 0x80) !== 0;
                if ($hasLocalTable) {
                    $lctSize = 1 << ((ord($frameData[$pos + 9]) & 0x07) + 1);
                    $imgBlockLen = 10 + (3 * $lctSize);
                } else {
                    // Force using local color table from this frame if different
                    $frameGct = substr($frameData, 13, 3 * $frameGctSize);
                    $desc = substr($frameData, $pos, 10);
                    // Set local color table flag
                    $desc[9] = chr(ord($desc[9]) | 0x80 | (ord($frameData[10]) & 0x07));
                    $out .= $desc . $frameGct;
                    $pos += 10;
                    // Copy image sub-blocks until 0x3B or 0x00
                    $dataBlocks = substr($frameData, $pos);
                    // Remove trailing ';'
                    if (substr($dataBlocks, -1) === "\x3B") {
                        $dataBlocks = substr($dataBlocks, 0, -1);
                    }
                    $out .= $dataBlocks;
                    continue;
                }
                $imgData = substr($frameData, $pos);
                if (substr($imgData, -1) === "\x3B") {
                    $imgData = substr($imgData, 0, -1);
                }
                $out .= $imgData;
            }
        }

        $out .= "\x3B"; // Trailer
        return $out;
    }
}

// Generate high-resolution frames (800 x 480)
$W = 800;
$H = 480;

function createBaseFrame($w, $h, $title = 'ComicGarage — Japanese Manga Vault') {
    $img = imagecreatetruecolor($w, $h);
    
    // Palette
    $cBg = imagecolorallocate($img, 8, 9, 13);
    $cSurface = imagecolorallocate($img, 15, 17, 23);
    $cSurfaceElevated = imagecolorallocate($img, 22, 25, 34);
    $cBorder = imagecolorallocate($img, 38, 42, 55);
    $cText = imagecolorallocate($img, 248, 250, 252);
    $cTextMuted = imagecolorallocate($img, 148, 163, 184);
    $cCrimson = imagecolorallocate($img, 230, 57, 70);
    $cAmber = imagecolorallocate($img, 245, 158, 11);
    $cEmerald = imagecolorallocate($img, 16, 185, 129);
    $cBlue = imagecolorallocate($img, 59, 130, 246);

    // Fill BG
    imagefilledrectangle($img, 0, 0, $w, $h, $cBg);

    // Subtle grid pattern
    $cGrid = imagecolorallocate($img, 18, 20, 28);
    for ($x = 0; $x < $w; $x += 32) {
        imageline($img, $x, 0, $x, $h, $cGrid);
    }
    for ($y = 0; $y < $h; $y += 32) {
        imageline($img, 0, $y, $w, $y, $cGrid);
    }

    // Top Window / Browser Bar
    imagefilledrectangle($img, 0, 0, $w, 36, $cSurface);
    imageline($img, 0, 36, $w, 36, $cBorder);

    // Window control dots
    $cRedDot = imagecolorallocate($img, 239, 68, 68);
    $cYelDot = imagecolorallocate($img, 245, 158, 11);
    $cGrnDot = imagecolorallocate($img, 34, 197, 94);
    imagefilledellipse($img, 20, 18, 10, 10, $cRedDot);
    imagefilledellipse($img, 36, 18, 10, 10, $cYelDot);
    imagefilledellipse($img, 52, 18, 10, 10, $cGrnDot);

    // URL bar
    imagefilledrectangle($img, 120, 8, $w - 180, 28, $cSurfaceElevated);
    imagerectangle($img, 120, 8, $w - 180, 28, $cBorder);
    imagestring($img, 2, 135, 12, "https://comicgarage.local/vault  —  " . $title, $cTextMuted);

    // Nav Brand & Pill in content area (y = 37 to 76)
    imagefilledrectangle($img, 0, 37, $w, 76, $cSurface);
    imageline($img, 0, 76, $w, 76, $cBorder);

    // Brand icon
    imagefilledrectangle($img, 20, 44, 46, 68, $cCrimson);
    imagestring($img, 4, 25, 48, "CG", $cText);
    imagestring($img, 4, 56, 45, "ComicGarage", $cText);
    imagestring($img, 2, 56, 61, "ARCHIVE 01 // MANGA VAULT", $cCrimson);

    // Live status pill
    imagefilledrectangle($img, 280, 46, 540, 67, $cSurfaceElevated);
    imagerectangle($img, 280, 46, 540, 67, $cBorder);
    imagefilledellipse($img, 292, 56, 6, 6, $cEmerald);
    imagestring($img, 2, 305, 50, "18 TITLES  |  142 VOLS  |  87.5% COMPLETE", $cTextMuted);

    // BGM Button
    imagefilledrectangle($img, 560, 46, 650, 67, $cSurfaceElevated);
    imagerectangle($img, 560, 46, 650, 67, $cBorder);
    imagestring($img, 2, 570, 50, "BGM [ON]", $cEmerald);

    // Admin Vault Button
    imagefilledrectangle($img, 665, 45, $w - 20, 68, $cCrimson);
    imagestring($img, 2, 678, 50, "ADMIN VAULT ->", $cText);

    return [
        'img' => $img,
        'colors' => [
            'bg' => $cBg, 'surface' => $cSurface, 'elevated' => $cSurfaceElevated,
            'border' => $cBorder, 'text' => $cText, 'textMuted' => $cTextMuted,
            'crimson' => $cCrimson, 'amber' => $cAmber, 'emerald' => $cEmerald, 'blue' => $cBlue
        ]
    ];
}

// Scene 1: Vault Overview & Hero Spotlight
function renderScene1($w, $h) {
    $base = createBaseFrame($w, $h, "Manga Vault & Collection Shelf");
    $img = $base['img'];
    $c = $base['colors'];

    // Hero Left: Headline
    imagestring($img, 5, 24, 95, "Curate, Catalog & Track Every Tankobon.", $c['text']);
    imagestring($img, 3, 24, 120, "A precision collector archive to track physical manga volumes & gaps.", $c['textMuted']);

    // 4 Stat Cards
    $statData = [
        ['18', 'SERIES', 'Total Titles'],
        ['142', 'VOLS', 'Tracked Books'],
        ['87.5%', '', 'Completion Rate'],
        ['4', 'GAPS', 'Ongoing Runs']
    ];
    for ($i = 0; $i < 4; $i++) {
        $x = 24 + ($i * 105);
        $y = 145;
        imagefilledrectangle($img, $x, $y, $x + 95, $y + 54, $c['surface']);
        imagerectangle($img, $x, $y, $x + 95, $y + 54, $c['border']);
        imagestring($img, 4, $x + 8, $y + 8, $statData[$i][0], ($i === 3 ? $c['amber'] : ($i === 2 ? $c['emerald'] : $c['text'])));
        imagestring($img, 2, $x + 8 + (strlen($statData[$i][0]) * 9), $y + 10, $statData[$i][1], $c['crimson']);
        imagestring($img, 2, $x + 8, $y + 32, $statData[$i][2], $c['textMuted']);
    }

    // Hero Right: Spotlight Card (Chainsaw Man)
    $spX = 460;
    $spY = 92;
    imagefilledrectangle($img, $spX, $spY, $w - 24, $spY + 110, $c['elevated']);
    imagerectangle($img, $spX, $spY, $w - 24, $spY + 110, $c['crimson']);

    // Spotlight Cover Mockup
    imagefilledrectangle($img, $spX + 12, $spY + 12, $spX + 80, $spY + 98, $c['surface']);
    imagerectangle($img, $spX + 12, $spY + 12, $spX + 80, $spY + 98, $c['border']);
    imagestring($img, 2, $spX + 18, $spY + 30, "CHAINSAW", $c['crimson']);
    imagestring($img, 2, $spX + 28, $spY + 46, "MAN", $c['text']);
    imagestring($img, 2, $spX + 22, $spY + 65, "VOL. 1-16", $c['textMuted']);

    // Spotlight Info
    imagestring($img, 2, $spX + 92, $spY + 12, "[ FEATURED COLLECTION ]", $c['amber']);
    imagestring($img, 4, $spX + 92, $spY + 28, "Chainsaw Man", $c['text']);
    imagestring($img, 2, $spX + 92, $spY + 46, "by Tatsuki Fujimoto • Shounen", $c['textMuted']);

    // Progress Bar
    imagestring($img, 2, $spX + 92, $spY + 64, "Volume Progress: 14/16 Books (87.5%)", $c['emerald']);
    imagefilledrectangle($img, $spX + 92, $spY + 79, $w - 40, $spY + 86, $c['surface']);
    imagefilledrectangle($img, $spX + 92, $spY + 79, $spX + 92 + (int)(($w - 40 - ($spX + 92)) * 0.875), $spY + 86, $c['emerald']);
    imagestring($img, 2, $spX + 92, $spY + 92, "STATUS: 2 VOLUMES MISSING (GAP RADAR)", $c['amber']);

    // Lower Shelf Section
    imageline($img, 24, 215, $w - 24, 215, $c['border']);
    imagestring($img, 4, 24, 225, "Collection Shelf Catalog (18 Manga Series)", $c['text']);

    // Manga Cards Grid (Row of 3 cards)
    $cards = [
        ['Jujutsu Kaisen', 'Gege Akutami', 'Shounen', '25/26 Vols', 96, false],
        ['Chainsaw Man', 'Tatsuki Fujimoto', 'Shounen', '14/16 Vols', 87, false],
        ['Berserk Deluxe', 'Kentaro Miura', 'Seinen', '14/14 Vols', 100, true]
    ];

    for ($i = 0; $i < 3; $i++) {
        $cx = 24 + ($i * 255);
        $cy = 250;
        $card = $cards[$i];

        imagefilledrectangle($img, $cx, $cy, $cx + 242, $cy + 215, $c['surface']);
        imagerectangle($img, $cx, $cy, $cx + 242, $cy + 215, $c['border']);

        // Cover placeholder
        imagefilledrectangle($img, $cx + 10, $cy + 10, $cx + 75, $cy + 100, $c['elevated']);
        imagerectangle($img, $cx + 10, $cy + 10, $cx + 75, $cy + 100, $c['border']);
        imagestring($img, 2, $cx + 14, $cy + 35, substr($card[0], 0, 8), $c['crimson']);
        imagestring($img, 2, $cx + 14, $cy + 55, "COVER", $c['textMuted']);

        // Info
        imagestring($img, 2, $cx + 85, $cy + 12, "[" . strtoupper($card[2]) . "]", $c['amber']);
        imagestring($img, 4, $cx + 85, $cy + 28, substr($card[0], 0, 14), $c['text']);
        imagestring($img, 2, $cx + 85, $cy + 48, $card[1], $c['textMuted']);
        imagestring($img, 2, $cx + 85, $cy + 68, $card[3], $card[5] ? $c['emerald'] : $c['amber']);

        // Progress bar
        imagefilledrectangle($img, $cx + 10, $cy + 112, $cx + 232, $cy + 118, $c['elevated']);
        imagefilledrectangle($img, $cx + 10, $cy + 112, $cx + 10 + (int)(222 * ($card[4] / 100)), $cy + 118, $card[5] ? $c['emerald'] : $c['crimson']);

        // Volume chips
        $vols = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $vx = $cx + 10;
        $vy = 130;
        for ($v = 0; $v < 8; $v++) {
            $isCol = ($card[5] || ($v !== 4 && $v !== 6));
            imagefilledrectangle($img, $vx + ($v * 27), $cy + $vy, $vx + ($v * 27) + 23, $cy + $vy + 18, $isCol ? $c['elevated'] : $c['crimson']);
            imagerectangle($img, $vx + ($v * 27), $cy + $vy, $vx + ($v * 27) + 23, $cy + $vy + 18, $isCol ? $c['emerald'] : $c['crimson']);
            imagestring($img, 2, $vx + ($v * 27) + 3, $cy + $vy + 3, "v" . ($v + 1), $c['text']);
        }

        // Action button
        imagefilledrectangle($img, $cx + 10, $cy + 175, $cx + 115, $cy + 200, $c['elevated']);
        imagerectangle($img, $cx + 10, $cy + 175, $cx + 115, $cy + 200, $c['crimson']);
        imagestring($img, 2, $cx + 24, $cy + 182, "INSPECT GAP", $c['crimson']);

        imagefilledrectangle($img, $cx + 125, $cy + 175, $cx + 232, $cy + 200, $c['elevated']);
        imagerectangle($img, $cx + 125, $cy + 175, $cx + 232, $cy + 200, $c['border']);
        imagestring($img, 2, $cx + 145, $cy + 182, "EDIT ->", $c['textMuted']);
    }

    return $img;
}

// Scene 2: Live Search & Multi-Facet Filtering
function renderScene2($w, $h, $query = 'chainsaw') {
    $base = createBaseFrame($w, $h, "Instant Filtering & Search Engine");
    $img = $base['img'];
    $c = $base['colors'];

    // Big Filter Bar Frame
    imagefilledrectangle($img, 24, 90, $w - 24, 168, $c['surface']);
    imagerectangle($img, 24, 90, $w - 24, 168, $c['crimson']);

    // Search Input Field with typing animation
    imagefilledrectangle($img, 36, 102, 380, 132, $c['elevated']);
    imagerectangle($img, 36, 102, 380, 132, $c['crimson']);
    imagestring($img, 3, 48, 110, "Search: " . $query, $c['text']);
    // Blinking cursor
    imageline($img, 48 + (strlen("Search: " . $query) * 9), 108, 48 + (strlen("Search: " . $query) * 9), 126, $c['crimson']);
    imagestring($img, 2, 350, 111, "[ESC]", $c['textMuted']);

    // Filter status tabs
    $tabs = ['All Titles', 'Missing Gaps', 'Complete Sets'];
    for ($i = 0; $i < 3; $i++) {
        $tx = 400 + ($i * 120);
        $isActive = ($i === 1);
        imagefilledrectangle($img, $tx, 102, $tx + 110, 132, $isActive ? $c['crimson'] : $c['elevated']);
        imagerectangle($img, $tx, 102, $tx + 110, 132, $isActive ? $c['crimson'] : $c['border']);
        imagestring($img, 2, $tx + 12, 111, $tabs[$i], $isActive ? $c['text'] : $c['textMuted']);
    }

    // Genre Chips
    imagestring($img, 2, 36, 144, "GENRE:", $c['textMuted']);
    $genres = ['ALL', 'SHOUNEN', 'SEINEN', 'HORROR', 'AMERICA'];
    for ($i = 0; $i < count($genres); $i++) {
        $gx = 90 + ($i * 90);
        $isActive = ($i === 1);
        imagefilledrectangle($img, $gx, 140, $gx + 80, 160, $isActive ? $c['elevated'] : $c['bg']);
        imagerectangle($img, $gx, 140, $gx + 80, 160, $isActive ? $c['amber'] : $c['border']);
        imagestring($img, 2, $gx + 12, 144, $genres[$i], $isActive ? $c['amber'] : $c['textMuted']);
    }

    // Dynamic Filter Notice
    imagestring($img, 2, 24, 180, "RESULTS: Showing 1 matching manga series with uncollected gaps (Hotkey '/' to focus)", $c['emerald']);

    // Filtered Single Card (Chainsaw Man highlighted)
    $cx = 24;
    $cy = 200;
    imagefilledrectangle($img, $cx, $cy, $w - 24, 460, $c['surface']);
    imagerectangle($img, $cx, $cy, $w - 24, 460, $c['border']);

    // Big Cover & Details
    imagefilledrectangle($img, $cx + 20, $cy + 20, $cx + 160, $cy + 230, $c['elevated']);
    imagerectangle($img, $cx + 20, $cy + 20, $cx + 160, $cy + 230, $c['crimson']);
    imagestring($img, 4, $cx + 35, $cy + 80, "CHAINSAW", $c['crimson']);
    imagestring($img, 4, $cx + 60, $cy + 105, "MAN", $c['text']);
    imagestring($img, 2, $cx + 40, $cy + 130, "TATSUKI FUJIMOTO", $c['textMuted']);

    // Right details
    imagestring($img, 3, $cx + 180, $cy + 20, "[ SHOUNEN / DARK FANTASY ]", $c['amber']);
    imagestring($img, 5, $cx + 180, $cy + 40, "Chainsaw Man (チェンソーマン)", $c['text']);
    imagestring($img, 3, $cx + 180, $cy + 65, "Author: Tatsuki Fujimoto  |  Publisher: Shueisha Jump Comics", $c['textMuted']);
    imagestring($img, 4, $cx + 180, $cy + 90, "Collection Status: 14 of 16 Volumes Collected (87.5%)", $c['emerald']);

    // Volume Grid in Search
    imagestring($img, 2, $cx + 180, $cy + 120, "VOLUME GAP BREAKDOWN:", $c['textMuted']);
    $vx = $cx + 180;
    $vy = $cy + 140;
    for ($v = 1; $v <= 16; $v++) {
        $col = ($v - 1) % 8;
        $row = (int)(($v - 1) / 8);
        $bx = $vx + ($col * 65);
        $by = $vy + ($row * 35);
        $isMissing = ($v === 5 || $v === 12);

        imagefilledrectangle($img, $bx, $by, $bx + 58, $by + 28, $isMissing ? $c['crimson'] : $c['elevated']);
        imagerectangle($img, $bx, $by, $bx + 58, $by + 28, $isMissing ? $c['crimson'] : $c['emerald']);
        imagestring($img, 2, $bx + 8, $by + 4, "Vol." . $v, $c['text']);
        imagestring($img, 1, $bx + 8, $by + 16, $isMissing ? "MISSING" : "OWNED", $isMissing ? $c['text'] : $c['emerald']);
    }

    // Action
    imagefilledrectangle($img, $cx + 180, $cy + 218, $cx + 340, $cy + 246, $c['crimson']);
    imagestring($img, 2, $cx + 195, $cy + 226, "OPEN INSPECTOR MODAL ->", $c['text']);

    return $img;
}

// Scene 3: In-Page Volume Inspector Modal
function renderScene3($w, $h) {
    $base = createBaseFrame($w, $h, "In-Page Volume Inspector Modal");
    $img = $base['img'];
    $c = $base['colors'];

    // Dim background
    imagefilledrectangle($img, 0, 77, $w, $h, imagecolorallocatealpha($img, 0, 0, 0, 80));

    // Modal Card (Center)
    $mx = 120;
    $my = 95;
    $mw = 560;
    $mh = 360;
    imagefilledrectangle($img, $mx, $my, $mx + $mw, $my + $mh, $c['elevated']);
    imagerectangle($img, $mx, $my, $mx + $mw, $my + $mh, $c['crimson']);

    // Modal Header
    imagefilledrectangle($img, $mx, $my, $mx + $mw, $my + 40, $c['surface']);
    imageline($img, $mx, $my + 40, $mx + $mw, $my + 40, $c['border']);
    imagestring($img, 4, $mx + 16, $my + 12, "TANKOBON VOLUME INSPECTOR // 書庫詳細", $c['text']);
    imagestring($img, 3, $mx + $mw - 30, $my + 12, "[X]", $c['crimson']);

    // Comic Metadata Inside Modal
    imagefilledrectangle($img, $mx + 16, $my + 54, $mx + 100, $my + 165, $c['surface']);
    imagerectangle($img, $mx + 16, $my + 54, $mx + 100, $my + 165, $c['border']);
    imagestring($img, 2, $mx + 22, $my + 90, "CHAINSAW", $c['crimson']);
    imagestring($img, 2, $mx + 36, $my + 110, "MAN", $c['text']);

    imagestring($img, 2, $mx + 115, $my + 54, "GENRE: SHOUNEN / SUPERNATURAL", $c['amber']);
    imagestring($img, 5, $mx + 115, $my + 70, "Chainsaw Man", $c['text']);
    imagestring($img, 3, $mx + 115, $my + 95, "Story & Art by Tatsuki Fujimoto", $c['textMuted']);
    imagestring($img, 3, $mx + 115, $my + 120, "Tracking: 14 / 16 Volumes Collected (87.5%)", $c['emerald']);
    imagestring($img, 2, $mx + 115, $my + 142, "GAP ALERT: Volume 5 and Volume 12 are missing from your vault.", $c['amber']);

    // Volume Grid Matrix
    imageline($img, $mx + 16, $my + 180, $mx + $mw - 16, $my + 180, $c['border']);
    imagestring($img, 2, $mx + 16, $my + 190, "COMPLETE VOLUME CHECKLIST (16 VOLUMES LOGGED):", $c['textMuted']);

    $vx = $mx + 16;
    $vy = $my + 210;
    for ($v = 1; $v <= 16; $v++) {
        $col = ($v - 1) % 8;
        $row = (int)(($v - 1) / 8);
        $bx = $vx + ($col * 65);
        $by = $vy + ($row * 40);
        $isMissing = ($v === 5 || $v === 12);

        imagefilledrectangle($img, $bx, $by, $bx + 58, $by + 32, $isMissing ? $c['crimson'] : $c['surface']);
        imagerectangle($img, $bx, $by, $bx + 58, $by + 32, $isMissing ? $c['crimson'] : $c['emerald']);
        imagestring($img, 2, $bx + 8, $by + 4, "v" . $v, $c['text']);
        imagestring($img, 1, $bx + 8, $by + 18, $isMissing ? "MISSING" : "COLLECTED", $isMissing ? $c['text'] : $c['emerald']);
    }

    // Modal Footer
    imageline($img, $mx + 16, $my + $mh - 50, $mx + $mw - 16, $my + $mh - 50, $c['border']);
    imagestring($img, 2, $mx + 16, $my + $mh - 34, "Press ESC to return to shelf catalog", $c['textMuted']);

    imagefilledrectangle($img, $mx + $mw - 190, $my + $mh - 42, $mx + $mw - 16, $my + $mh - 12, $c['crimson']);
    imagestring($img, 2, $mx + $mw - 175, $my + $mh - 32, "EDIT IN FILAMENT VAULT ->", $c['text']);

    return $img;
}

// Scene 4: Ambient Lo-Fi YouTube Audio Cyber-Deck
function renderScene4($w, $h, $eqPhase = 0) {
    $base = createBaseFrame($w, $h, "Ambient Lo-Fi YouTube Audio Deck");
    $img = $base['img'];
    $c = $base['colors'];

    // Dim background slightly to focus on audio deck
    imagefilledrectangle($img, 0, 77, $w, $h, imagecolorallocatealpha($img, 0, 0, 0, 40));

    // Floating Cyber Deck Card (Bottom Right Expanded)
    $dx = 420;
    $dy = 130;
    $dw = 356;
    $dh = 330;

    imagefilledrectangle($img, $dx, $dy, $dx + $dw, $dy + $dh, $c['elevated']);
    imagerectangle($img, $dx, $dy, $dx + $dw, $dy + $dh, $c['crimson']);

    // Accent line top
    imagefilledrectangle($img, $dx, $dy, $dx + $dw, $dy + 3, $c['crimson']);

    // Deck Header
    imagestring($img, 2, $dx + 14, $dy + 12, "SOUND VAULT // BGM  -  Live Radio Feed", $c['text']);
    imagefilledellipse($img, $dx + $dw - 24, $dy + 18, 8, 8, $c['emerald']);

    // Station Switcher Chips
    $stations = ['⚡ Lofi Live', '🌸 Ghibli', '🌙 4 A.M', '📻 Mix'];
    for ($s = 0; $s < 4; $s++) {
        $sx = $dx + 12 + ($s * 82);
        $sy = $dy + 34;
        $isAct = ($s === 0);
        imagefilledrectangle($img, $sx, $sy, $sx + 76, $sy + 24, $isAct ? $c['crimson'] : $c['surface']);
        imagerectangle($img, $sx, $sy, $sx + 76, $sy + 24, $isAct ? $c['crimson'] : $c['border']);
        imagestring($img, 1, $sx + 6, $sy + 7, $stations[$s], $isAct ? $c['text'] : $c['textMuted']);
    }

    // Video Drawer Screen Mockup
    imagefilledrectangle($img, $dx + 12, $dy + 68, $dx + $dw - 12, $dy + 180, imagecolorallocate($img, 0, 0, 0));
    imagerectangle($img, $dx + 12, $dy + 68, $dx + $dw - 12, $dy + 180, $c['border']);
    imagestring($img, 3, $dx + 80, $dy + 105, "LOFI GIRL • 24/7 LIVE STREAM", $c['crimson']);
    imagestring($img, 2, $dx + 90, $dy + 125, "Anime Beats to Study / Read Manga", $c['textMuted']);

    // Animated Equalizer Visualizer
    $eqHeights = [
        [4, 12, 8, 16, 10, 18, 6, 14, 20, 8, 12, 16],
        [16, 8, 18, 6, 14, 10, 20, 12, 6, 16, 8, 10],
        [10, 18, 6, 20, 8, 14, 12, 6, 16, 10, 18, 8]
    ];
    $bars = $eqHeights[$eqPhase % 3];
    for ($b = 0; $b < count($bars); $b++) {
        $bx = $dx + 30 + ($b * 24);
        $bh = $bars[$b];
        imagefilledrectangle($img, $bx, $dy + 172 - $bh, $bx + 14, $dy + 172, $c['crimson']);
    }

    // Track Info Box
    imagefilledrectangle($img, $dx + 12, $dy + 192, $dx + 48, $dy + 228, $c['surface']);
    imagerectangle($img, $dx + 12, $dy + 192, $dx + 48, $dy + 228, $c['crimson']);
    imagestring($img, 3, $dx + 22, $dy + 202, "♫", $c['crimson']);

    imagestring($img, 3, $dx + 58, $dy + 194, "Lofi Girl • 24/7 Anime Lofi Beats", $c['text']);
    imagestring($img, 2, $dx + 58, $dy + 212, "YouTube Radio Feed • ID: jfKfPfyJRdk", $c['textMuted']);

    // Seekable Progress Bar
    imagefilledrectangle($img, $dx + 12, $dy + 242, $dx + $dw - 12, $dy + 248, $c['surface']);
    imagefilledrectangle($img, $dx + 12, $dy + 242, $dx + 180, $dy + 248, $c['crimson']);
    imagefilledellipse($img, $dx + 180, $dy + 245, 10, 10, $c['text']);

    // Controls Deck
    imagefilledellipse($img, $dx + 35, $dy + 280, 26, 26, $c['surface']);
    imagestring($img, 2, $dx + 28, $dy + 274, "|<", $c['textMuted']);

    // Main Play/Pause Button
    imagefilledellipse($img, $dx + 75, $dy + 280, 36, 36, $c['crimson']);
    imagestring($img, 4, $dx + 70, $dy + 273, "||", $c['text']);

    imagefilledellipse($img, $dx + 115, $dy + 280, 26, 26, $c['surface']);
    imagestring($img, 2, $dx + 110, $dy + 274, ">|", $c['textMuted']);

    // Volume Slider & Mute
    imagestring($img, 2, $dx + 155, $dy + 274, "VOL", $c['textMuted']);
    imagefilledrectangle($img, $dx + 185, $dy + 278, $dx + 270, $dy + 282, $c['surface']);
    imagefilledrectangle($img, $dx + 185, $dy + 278, $dx + 250, $dy + 282, $c['emerald']);
    imagefilledellipse($img, $dx + 250, $dy + 280, 8, 8, $c['text']);

    // Hotkey badge
    imagefilledrectangle($img, $dx + 290, $dy + 268, $dx + 342, $dy + 292, $c['surface']);
    imagerectangle($img, $dx + 290, $dy + 268, $dx + 342, $dy + 292, $c['border']);
    imagestring($img, 2, $dx + 298, $dy + 274, "KEY [M]", $c['amber']);

    // Left info card explaining ambient deck
    imagefilledrectangle($img, 24, 130, 390, 440, $c['surface']);
    imagerectangle($img, 24, 130, 390, 440, $c['border']);
    imagestring($img, 4, 40, 150, "AMBIENT LO-FI AUDIO DECK", $c['text']);
    imagestring($img, 2, 40, 180, "• 4 Curated 24/7 Lo-Fi & Ghibli YouTube Streams", $c['emerald']);
    imagestring($img, 2, 40, 205, "• Real-Time Audio Equalizer Animation", $c['text']);
    imagestring($img, 2, 40, 230, "• Video Drawer Screen (Toggle On / Off)", $c['text']);
    imagestring($img, 2, 40, 255, "• Global Keyboard Shortcut [M] to Toggle", $c['amber']);
    imagestring($img, 2, 40, 280, "• Embed Error Fallback with Direct YouTube Link", $c['crimson']);
    imagestring($img, 2, 40, 310, "Designed for late-night tankobon reading sessions.", $c['textMuted']);

    return $img;
}

// Scene 5: Filament v3 Admin Command Center
function renderScene5($w, $h) {
    $img = imagecreatetruecolor($w, $h);
    $cBg = imagecolorallocate($img, 15, 23, 42); // Filament dark theme
    $cSurface = imagecolorallocate($img, 30, 41, 59);
    $cElevated = imagecolorallocate($img, 51, 65, 85);
    $cBorder = imagecolorallocate($img, 71, 85, 105);
    $cText = imagecolorallocate($img, 248, 250, 252);
    $cTextMuted = imagecolorallocate($img, 148, 163, 184);
    $cPrimary = imagecolorallocate($img, 245, 158, 11); // Filament Amber
    $cSuccess = imagecolorallocate($img, 34, 197, 94);
    $cInfo = imagecolorallocate($img, 59, 130, 246);
    $cWarning = imagecolorallocate($img, 239, 68, 68);

    imagefilledrectangle($img, 0, 0, $w, $h, $cBg);

    // Filament Topbar
    imagefilledrectangle($img, 0, 0, $w, 40, $cSurface);
    imageline($img, 0, 40, $w, 40, $cBorder);
    imagestring($img, 4, 20, 12, "ComicGarage Filament v3 Admin Panel", $cPrimary);
    imagestring($img, 2, $w - 180, 14, "Admin • arlo@comicgarage", $cTextMuted);

    // Left Sidebar Navigation
    imagefilledrectangle($img, 0, 41, 160, $h, $cSurface);
    imageline($img, 160, 41, 160, $h, $cBorder);

    $menu = ['📊 Dashboard', '📚 Comics Catalog', '🛒 Purchases Ledger', '✍️ Authors Index', '🌐 Public Vault ↗'];
    for ($m = 0; $m < count($menu); $m++) {
        $my = 55 + ($m * 36);
        $isAct = ($m === 0);
        if ($isAct) {
            imagefilledrectangle($img, 8, $my - 4, 152, $my + 24, $cElevated);
        }
        imagestring($img, 2, 16, $my + 2, $menu[$m], $isAct ? $cPrimary : $cTextMuted);
    }

    // Main Area: Filament Widgets Grid
    // 3 Stat Overview Cards
    $stats = [
        ['Total Judul', '18 Judul', 'Lihat semua komik', $cInfo],
        ['Total Volume', '142 Buku', '124 terkumpul (87.5%)', $cSuccess],
        ['Total Investasi', 'Rp 4.250.000', '28 transaksi tercatat', $cPrimary]
    ];

    for ($s = 0; $s < 3; $s++) {
        $sx = 175 + ($s * 200);
        $sy = 52;
        imagefilledrectangle($img, $sx, $sy, $sx + 190, $sy + 85, $cSurface);
        imagerectangle($img, $sx, $sy, $sx + 190, $sy + 85, $cBorder);

        imagestring($img, 2, $sx + 12, $sy + 10, $stats[$s][0], $cTextMuted);
        imagestring($img, 4, $sx + 12, $sy + 28, $stats[$s][1], $stats[$s][3]);
        imagestring($img, 2, $sx + 12, $sy + 55, $stats[$s][2], $cTextMuted);

        // Sparkline mini chart
        $spark = [10, 15, 25, 20, 35, 45, 60];
        for ($p = 0; $p < 6; $p++) {
            imageline($img, $sx + 110 + ($p * 11), $sy + 70 - (int)($spark[$p] * 0.4), $sx + 110 + (($p + 1) * 11), $sy + 70 - (int)($spark[$p + 1] * 0.4), $stats[$s][3]);
        }
    }

    // Growth Chart Widget (Line Chart)
    $gx = 175;
    $gy = 150;
    $gw = 380;
    $gh = 170;
    imagefilledrectangle($img, $gx, $gy, $gx + $gw, $gy + $gh, $cSurface);
    imagerectangle($img, $gx, $gy, $gx + $gw, $gy + $gh, $cBorder);

    imagestring($img, 3, $gx + 12, $gy + 10, "📈 Tren Penambahan Volume & Pembelian", $cText);
    imagestring($img, 2, $gx + $gw - 90, $gy + 10, "[ 6 Bulan ]", $cPrimary);

    // Chart gridlines
    for ($l = 0; $l < 4; $l++) {
        $ly = $gy + 45 + ($l * 28);
        imageline($img, $gx + 30, $ly, $gx + $gw - 15, $ly, $cElevated);
    }

    // Chart Lines (Blue = Volumes, Green = Purchases)
    $volData = [12, 18, 25, 30, 42, 55];
    $buyData = [8, 14, 18, 22, 28, 38];
    for ($p = 0; $p < 5; $p++) {
        $x1 = $gx + 45 + ($p * 60);
        $x2 = $gx + 45 + (($p + 1) * 60);
        $y1_v = $gy + 140 - (int)($volData[$p] * 1.5);
        $y2_v = $gy + 140 - (int)($volData[$p + 1] * 1.5);
        imageline($img, $x1, $y1_v, $x2, $y2_v, $cInfo);
        imagefilledellipse($img, $x1, $y1_v, 5, 5, $cInfo);

        $y1_b = $gy + 140 - (int)($buyData[$p] * 1.5);
        $y2_b = $gy + 140 - (int)($buyData[$p + 1] * 1.5);
        imageline($img, $x1, $y1_b, $x2, $y2_b, $cSuccess);
        imagefilledellipse($img, $x1, $y1_b, 5, 5, $cSuccess);
    }
    imagefilledellipse($img, $gx + 45 + (5 * 60), $gy + 140 - (int)($volData[5] * 1.5), 5, 5, $cInfo);
    imagefilledellipse($img, $gx + 45 + (5 * 60), $gy + 140 - (int)($buyData[5] * 1.5), 5, 5, $cSuccess);

    // Legend
    imagestring($img, 2, $gx + 45, $gy + 152, "● Volumes Added (Blue)   ● Purchases (Green)", $cTextMuted);

    // Genre Doughnut Chart Widget
    $dx = 570;
    $dy = 150;
    $dw = 205;
    $dh = 170;
    imagefilledrectangle($img, $dx, $dy, $dx + $dw, $dy + $dh, $cSurface);
    imagerectangle($img, $dx, $dy, $dx + $dw, $dy + $dh, $cBorder);
    imagestring($img, 3, $dx + 10, $dy + 10, "📊 Distribusi Genre", $cText);

    // Doughnut Mockup
    imagefilledellipse($img, $dx + 102, $dy + 85, 75, 75, $cSuccess); // Shounen
    imagefilledarc($img, $dx + 102, $dy + 85, 75, 75, 0, 110, $cPrimary, IMG_ARC_PIE); // Seinen
    imagefilledarc($img, $dx + 102, $dy + 85, 75, 75, 110, 180, $cWarning, IMG_ARC_PIE); // Horror
    imagefilledarc($img, $dx + 102, $dy + 85, 75, 75, 180, 250, $cInfo, IMG_ARC_PIE); // America
    imagefilledellipse($img, $dx + 102, $dy + 85, 38, 38, $cSurface); // Hole

    imagestring($img, 1, $dx + 15, $dy + 135, "■ Shounen (45%)  ■ Seinen (30%)", $cTextMuted);
    imagestring($img, 1, $dx + 15, $dy + 150, "■ Horror (15%)   ■ America (10%)", $cTextMuted);

    // Incomplete Series Radar Table Widget (Bottom)
    $tx = 175;
    $ty = 330;
    $tw = 600;
    $th = 135;
    imagefilledrectangle($img, $tx, $ty, $tx + $tw, $ty + $th, $cSurface);
    imagerectangle($img, $tx, $ty, $tx + $tw, $ty + $th, $cBorder);
    imagestring($img, 3, $tx + 12, $ty + 8, "⚠️ Radar Seri Belum Lengkap (Missing Gap Tracker)", $cText);

    // Table rows
    $rows = [
        ['Chainsaw Man', 'Tatsuki Fujimoto', 'Shounen', '14/16 Vols', 'Missing: Vol 5, 12'],
        ['Jujutsu Kaisen', 'Gege Akutami', 'Shounen', '25/26 Vols', 'Missing: Vol 26'],
        ['Hunter x Hunter', 'Yoshihiro Togashi', 'Shounen', '32/37 Vols', 'Missing: Vol 33-37']
    ];

    for ($r = 0; $r < 3; $r++) {
        $ry = $ty + 34 + ($r * 32);
        imagefilledrectangle($img, $tx + 10, $ry, $tx + $tw - 10, $ry + 26, ($r % 2 === 0 ? $cElevated : $cSurface));
        imagestring($img, 2, $tx + 18, $ry + 6, $rows[$r][0], $cText);
        imagestring($img, 2, $tx + 150, $ry + 6, $rows[$r][1], $cTextMuted);
        imagestring($img, 2, $tx + 280, $ry + 6, $rows[$r][3], $cInfo);
        imagestring($img, 2, $tx + 370, $ry + 6, $rows[$r][4], $cWarning);
        imagestring($img, 2, $tx + 540, $ry + 6, "[EDIT]", $cPrimary);
    }

    return $img;
}

// Build all frames
$encoder = new GifEncoder($W, $H, 0);

echo "Rendering Scene 1: Public Vault Shelf...\n";
$f1 = renderScene1($W, $H);
$encoder->addFrame($f1, 200); // 2.0 sec

echo "Rendering Scene 2: Live Instant Search & Filters...\n";
$f2_a = renderScene2($W, $H, 'c');
$encoder->addFrame($f2_a, 40);
$f2_b = renderScene2($W, $H, 'chain');
$encoder->addFrame($f2_b, 40);
$f2_c = renderScene2($W, $H, 'chainsaw');
$encoder->addFrame($f2_c, 180); // 1.8 sec

echo "Rendering Scene 3: Volume Inspector Modal...\n";
$f3 = renderScene3($W, $H);
$encoder->addFrame($f3, 220); // 2.2 sec

echo "Rendering Scene 4: Ambient Lo-Fi YouTube Cyber-Deck...\n";
$f4_1 = renderScene4($W, $H, 0);
$encoder->addFrame($f4_1, 60);
$f4_2 = renderScene4($W, $H, 1);
$encoder->addFrame($f4_2, 60);
$f4_3 = renderScene4($W, $H, 2);
$encoder->addFrame($f4_3, 100);

echo "Rendering Scene 5: Filament v3 Admin Command Center...\n";
$f5 = renderScene5($W, $H);
$encoder->addFrame($f5, 250); // 2.5 sec

$gifData = $encoder->encode();

// Save to docs/assets/ and public/images/
$targetDir1 = __DIR__ . '/docs/assets';
$targetDir2 = __DIR__ . '/public/images';

if (!is_dir($targetDir1)) mkdir($targetDir1, 0777, true);
if (!is_dir($targetDir2)) mkdir($targetDir2, 0777, true);

file_put_contents($targetDir1 . '/comicgarage-demo.gif', $gifData);
file_put_contents($targetDir1 . '/demo.gif', $gifData);
file_put_contents($targetDir2 . '/demo.gif', $gifData);

echo "Successfully generated demo GIF (" . strlen($gifData) . " bytes) at:\n";
echo "- docs/assets/comicgarage-demo.gif\n";
echo "- docs/assets/demo.gif\n";
echo "- public/images/demo.gif\n";
