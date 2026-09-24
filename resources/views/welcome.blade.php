<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ComicGarage — Japanese Manga & Graphic Novel Vault</title>
    
    <!-- Favicon & Metadata -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">
    <link rel="alternate icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.svg') }}">
    <meta name="theme-color" content="#e63946">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-base: #08090d;
            --bg-surface: #0f1117;
            --bg-surface-elevated: #161922;
            --bg-surface-hover: #1e222e;
            --border-subtle: rgba(255, 255, 255, 0.08);
            --border-strong: rgba(255, 255, 255, 0.16);
            --border-active: rgba(255, 255, 255, 0.28);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --accent-crimson: #e63946;
            --accent-crimson-hover: #ff4d5a;
            --accent-crimson-glow: rgba(230, 57, 70, 0.22);
            --accent-amber: #f59e0b;
            --accent-emerald: #10b981;
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-display: 'Space Grotesk', system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-primary);
            font-family: var(--font-sans);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.035) 1px, transparent 0),
                radial-gradient(circle at 85% 15%, rgba(230, 57, 70, 0.04) 0%, transparent 45%),
                radial-gradient(circle at 15% 85%, rgba(245, 158, 11, 0.03) 0%, transparent 45%);
            background-size: 24px 24px, 100% 100%, 100% 100%;
        }

        .manga-grid-overlay {
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 72px 72px;
            z-index: 0;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        /* Top Navigation */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(8, 9, 13, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            height: 72px;
            display: flex;
            align-items: center;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-primary);
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background: var(--bg-surface-elevated);
            border: 1px solid var(--border-strong);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-crimson);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .brand-tag {
            font-family: var(--font-mono);
            font-size: 0.68rem;
            color: var(--text-muted);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .live-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 100px;
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background: var(--accent-crimson);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--accent-crimson);
            animation: pulse-dot 2s infinite ease-in-out;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-vault {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 20px;
            background: var(--accent-crimson);
            color: #ffffff;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 2px 10px var(--accent-crimson-glow);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            white-space: nowrap;
        }

        .btn-vault:hover {
            background: var(--accent-crimson-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px var(--accent-crimson-glow);
        }

        .btn-vault:active {
            transform: translateY(0);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            background: var(--bg-surface);
            color: var(--text-primary);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            border: 1px solid var(--border-subtle);
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-secondary:hover {
            background: var(--bg-surface-elevated);
            border-color: var(--border-strong);
            color: #ffffff;
        }

        /* Hero Section */
        .hero-section {
            padding: 56px 0 64px;
            border-bottom: 1px solid var(--border-subtle);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 48px;
            align-items: center;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--accent-crimson);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 16px;
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: 3.15rem;
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--text-primary);
            margin-bottom: 16px;
        }

        .hero-description {
            font-size: 1.05rem;
            line-height: 1.6;
            color: var(--text-secondary);
            max-width: 540px;
            margin-bottom: 28px;
        }

        .hero-cta-group {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 36px;
        }

        /* Stats Strip */
        .hero-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            padding-top: 24px;
            border-top: 1px solid var(--border-subtle);
        }

        .stat-card {
            background: rgba(16, 18, 24, 0.6);
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            padding: 14px 16px;
            transition: border-color 0.2s ease;
        }

        .stat-card:hover {
            border-color: var(--border-strong);
        }

        .stat-value {
            font-family: var(--font-display);
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.1;
            margin-bottom: 4px;
            display: flex;
            align-items: baseline;
            gap: 2px;
        }

        .stat-unit {
            font-size: 0.85rem;
            color: var(--accent-crimson);
            font-family: var(--font-mono);
            font-weight: 500;
        }

        .stat-label {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Hero Spotlight Showcase */
        .hero-showcase {
            position: relative;
        }

        .showcase-frame {
            background: linear-gradient(145deg, var(--bg-surface-elevated), var(--bg-surface));
            border: 1px solid var(--border-strong);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 24px 48px -12px rgba(0, 0, 0, 0.7);
            position: relative;
            overflow: hidden;
        }

        .showcase-frame::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        .showcase-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-subtle);
        }

        .showcase-tag {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: var(--accent-crimson);
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .showcase-kanji {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .showcase-body {
            display: flex;
            gap: 20px;
        }

        .spotlight-book-cover {
            width: 140px;
            height: 200px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            background: #1c202d;
            border: 1px solid var(--border-strong);
            box-shadow: 
                -4px 4px 12px rgba(0, 0, 0, 0.6),
                inset 2px 0 3px rgba(255, 255, 255, 0.15);
            position: relative;
            cursor: pointer;
        }

        .spotlight-book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .spotlight-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .spotlight-meta-genre {
            display: inline-block;
            font-family: var(--font-mono);
            font-size: 0.68rem;
            color: var(--accent-amber);
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.2);
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .spotlight-comic-title {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .spotlight-comic-author {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 14px;
        }

        .spotlight-progress-box {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 12px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .progress-bar-track {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent-crimson), #ff6b6b);
            border-radius: 10px;
            transition: width 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .progress-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-family: var(--font-mono);
            font-size: 0.68rem;
            font-weight: 600;
        }

        .badge-complete {
            color: var(--accent-emerald);
        }

        .badge-ongoing {
            color: var(--accent-amber);
        }

        /* Collection Shelf Section */
        .shelf-section {
            padding: 64px 0 80px;
        }

        .section-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 24px;
            flex-wrap: wrap;
        }

        .section-title-wrap {
            max-width: 500px;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .section-subtitle {
            font-size: 0.95rem;
            color: var(--text-secondary);
        }

        /* Filter Controls */
        .shelf-controls-bar {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 28px;
            padding: 16px;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
        }

        .filter-row-primary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .search-input-wrap {
            position: relative;
            flex: 1;
            min-width: 280px;
            max-width: 480px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
            width: 16px;
            height: 16px;
        }

        .search-input {
            width: 100%;
            background: var(--bg-base);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 10px 38px 10px 38px;
            color: var(--text-primary);
            font-family: var(--font-sans);
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            border-color: var(--accent-crimson);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.15);
            background: var(--bg-surface-elevated);
        }

        .search-clear-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 2px;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .search-clear-btn:hover {
            color: #ffffff;
        }

        .search-kbd {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-family: var(--font-mono);
            font-size: 0.65rem;
            padding: 2px 6px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-subtle);
            border-radius: 4px;
            color: var(--text-muted);
            pointer-events: none;
        }

        .filter-tabs {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--bg-base);
            padding: 4px;
            border-radius: 8px;
            border: 1px solid var(--border-subtle);
        }

        .filter-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-family: var(--font-sans);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .filter-btn:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        .filter-btn.active {
            background: var(--bg-surface-elevated);
            color: #ffffff;
            border: 1px solid var(--border-strong);
        }

        /* Genre Tags Row */
        .genre-chips-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            padding-top: 10px;
            border-top: 1px solid var(--border-subtle);
        }

        .genre-chip-label {
            font-family: var(--font-mono);
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-right: 4px;
        }

        .genre-chip {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            border-radius: 100px;
            padding: 4px 12px;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.15s ease;
            text-transform: uppercase;
        }

        .genre-chip:hover {
            background: var(--bg-surface-elevated);
            color: #ffffff;
            border-color: var(--border-strong);
        }

        .genre-chip.active {
            background: rgba(230, 57, 70, 0.15);
            border-color: var(--accent-crimson);
            color: #ffffff;
            font-weight: 600;
        }

        .shelf-results-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 20px;
            padding: 0 4px;
        }

        /* Comic Cards Grid */
        .comic-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }

        .comic-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .comic-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-strong);
            background: var(--bg-surface-hover);
            box-shadow: 0 16px 32px -8px rgba(0, 0, 0, 0.6);
        }

        .card-cover-wrap {
            height: 220px;
            background: #151821;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border-subtle);
            cursor: pointer;
        }

        .card-cover-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .comic-card:hover .card-cover-img {
            transform: scale(1.05);
        }

        /* Manga Spine Dust-Jacket Fallback */
        .card-cover-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 16px;
            background: linear-gradient(135deg, #181b26 0%, #0d0f15 100%);
            position: relative;
        }

        .card-cover-placeholder::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 70% 30%, rgba(230, 57, 70, 0.12), transparent 60%);
        }

        .placeholder-tag {
            font-family: var(--font-mono);
            font-size: 0.65rem;
            color: var(--accent-crimson);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            position: relative;
            z-index: 1;
        }

        .placeholder-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            position: relative;
            z-index: 1;
        }

        .placeholder-author {
            font-size: 0.78rem;
            color: var(--text-muted);
            position: relative;
            z-index: 1;
        }

        .card-genre-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(8, 9, 13, 0.82);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border-subtle);
            border-radius: 4px;
            padding: 2px 8px;
            font-family: var(--font-mono);
            font-size: 0.68rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            z-index: 2;
        }

        .card-body {
            padding: 18px;
            display: flex;
            flex-direction: column;
            flex: 1;
            justify-content: space-between;
        }

        .card-title-group {
            margin-bottom: 14px;
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .card-author {
            font-size: 0.82rem;
            color: var(--text-secondary);
        }

        .card-volume-info {
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 14px;
        }

        .vol-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .vol-meter {
            height: 4px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 4px;
            overflow: hidden;
        }

        .vol-meter-fill {
            height: 100%;
            background: var(--accent-crimson);
            border-radius: 4px;
        }

        .vol-pills-row {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-top: 8px;
            max-height: 44px;
            overflow-y: auto;
        }

        .vol-pill {
            font-family: var(--font-mono);
            font-size: 0.62rem;
            padding: 1px 5px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            border: 1px solid transparent;
        }

        .vol-pill.collected {
            background: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.25);
        }

        .vol-pill.missing {
            background: rgba(230, 57, 70, 0.12);
            color: #ff808a;
            border-color: rgba(230, 57, 70, 0.25);
        }

        .card-footer-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 1px solid var(--border-subtle);
        }

        .card-status-text {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            font-weight: 600;
        }

        .card-btn-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-quick-view-btn {
            background: transparent;
            border: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .card-quick-view-btn:hover {
            color: #ffffff;
            border-color: var(--border-strong);
            background: rgba(255, 255, 255, 0.05);
        }

        .card-edit-btn {
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color 0.15s ease;
        }

        .card-edit-btn:hover {
            color: var(--accent-crimson);
        }

        /* Zero Results Filter Box */
        .no-results-box {
            grid-column: 1 / -1;
            text-align: center;
            padding: 64px 24px;
            background: var(--bg-surface);
            border: 1px dashed var(--border-strong);
            border-radius: 12px;
            display: none;
        }

        .empty-shelf-box {
            grid-column: 1 / -1;
            text-align: center;
            padding: 64px 24px;
            background: var(--bg-surface);
            border: 1px dashed var(--border-strong);
            border-radius: 12px;
        }

        .empty-icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
            color: var(--text-muted);
        }

        /* Bento Features Grid */
        .bento-section {
            padding: 64px 0 80px;
            border-top: 1px solid var(--border-subtle);
            border-bottom: 1px solid var(--border-subtle);
            background: rgba(16, 18, 24, 0.3);
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .bento-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 14px;
            padding: 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: border-color 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .bento-card:hover {
            border-color: var(--border-strong);
        }

        .bento-card.col-span-2 {
            grid-column: span 2;
        }

        .bento-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: var(--bg-surface-elevated);
            border: 1px solid var(--border-strong);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-crimson);
            margin-bottom: 20px;
        }

        .bento-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .bento-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Recent Activity / Purchase Log */
        .purchases-section {
            padding: 64px 0 80px;
        }

        .purchase-table-frame {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            overflow: hidden;
        }

        .purchase-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-subtle);
            align-items: center;
            font-size: 0.875rem;
        }

        .purchase-row:last-child {
            border-bottom: none;
        }

        .purchase-row.header {
            background: var(--bg-surface-elevated);
            font-family: var(--font-mono);
            font-size: 0.72rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
        }

        .purchase-title {
            font-weight: 600;
            color: var(--text-primary);
        }

        .purchase-price {
            font-family: var(--font-mono);
            color: #34d399;
            font-weight: 600;
        }

        .purchase-store {
            color: var(--text-secondary);
        }

        .purchase-date {
            font-family: var(--font-mono);
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Manga Volume Inspector Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .modal-card {
            background: var(--bg-surface-elevated);
            border: 1px solid var(--border-strong);
            border-radius: 16px;
            max-width: 640px;
            width: 100%;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 32px 64px -16px rgba(0, 0, 0, 0.9);
            position: relative;
            padding: 28px;
        }

        .modal-close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            color: var(--text-muted);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .modal-close-btn:hover {
            color: #ffffff;
            border-color: var(--border-strong);
            background: var(--bg-surface-hover);
        }

        .modal-header-section {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-subtle);
        }

        .modal-cover-wrap {
            width: 110px;
            height: 155px;
            border-radius: 8px;
            overflow: hidden;
            background: #151821;
            border: 1px solid var(--border-strong);
            flex-shrink: 0;
        }

        .modal-cover-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-meta {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .modal-genre-tag {
            font-family: var(--font-mono);
            font-size: 0.68rem;
            color: var(--accent-amber);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }

        .modal-title {
            font-family: var(--font-display);
            font-size: 1.45rem;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .modal-author {
            font-size: 0.88rem;
            color: var(--text-secondary);
            margin-bottom: 12px;
        }

        .modal-vol-matrix-title {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
        }

        .modal-vol-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 8px;
            margin-bottom: 24px;
            max-height: 220px;
            overflow-y: auto;
            padding: 4px;
        }

        .modal-vol-item {
            padding: 8px 6px;
            border-radius: 6px;
            text-align: center;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            border: 1px solid var(--border-subtle);
            background: var(--bg-surface);
        }

        .modal-vol-item.is-collected {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.25);
            color: #34d399;
        }

        .modal-vol-item.is-missing {
            background: rgba(230, 57, 70, 0.1);
            border-color: rgba(230, 57, 70, 0.25);
            color: #ff808a;
        }

        .modal-vol-name {
            font-size: 0.65rem;
            color: var(--text-muted);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-top: 2px;
        }

        .modal-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 16px;
            border-top: 1px solid var(--border-subtle);
        }

        /* Footer */
        .footer {
            background: #050608;
            border-top: 1px solid var(--border-subtle);
            padding: 48px 0 36px;
        }

        .footer-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 24px;
        }

        .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .footer-title {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .footer-desc {
            font-size: 0.82rem;
            color: var(--text-muted);
        }

        .footer-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .footer-link {
            color: var(--text-secondary);
            font-size: 0.85rem;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .footer-link:hover {
            color: var(--accent-crimson);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .hero-title {
                font-size: 2.75rem;
            }

            .bento-grid {
                grid-template-columns: 1fr;
            }

            .bento-card.col-span-2 {
                grid-column: span 1;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                height: auto;
                padding: 14px 0;
            }

            .nav-inner {
                flex-wrap: wrap;
                gap: 12px;
            }

            .nav-center {
                display: none;
            }

            .hero-title {
                font-size: 2.2rem;
            }

            .hero-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-cta-group {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-vault, .btn-secondary {
                justify-content: center;
            }

            .showcase-body {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .spotlight-book-cover {
                width: 160px;
                height: 230px;
            }

            .purchase-row {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .purchase-row.header {
                display: none;
            }

            .footer-inner {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-row-primary {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input-wrap {
                max-width: 100%;
            }
        }

        /* ===================================================
           BGM Ambient YouTube Music Player Widget Styles
           =================================================== */
        .nav-bgm-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: 100px;
            color: var(--text-secondary);
            font-family: var(--font-mono);
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
        }

        .nav-bgm-btn:hover {
            border-color: var(--border-strong);
            color: var(--text-primary);
            background: var(--bg-surface-elevated);
        }

        .nav-bgm-btn.is-active {
            border-color: rgba(230, 57, 70, 0.45);
            background: rgba(230, 57, 70, 0.1);
            color: #ffffff;
            box-shadow: 0 0 16px rgba(230, 57, 70, 0.18);
        }

        .nav-bgm-equalizer {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            height: 12px;
        }

        .nav-bgm-equalizer .nav-bar {
            width: 2.5px;
            background: var(--text-muted);
            border-radius: 1px;
            transition: height 0.2s ease, background-color 0.2s ease;
        }

        .nav-bgm-equalizer .nav-bar-1 { height: 4px; }
        .nav-bgm-equalizer .nav-bar-2 { height: 8px; }
        .nav-bgm-equalizer .nav-bar-3 { height: 5px; }

        .nav-bgm-btn.is-active .nav-bgm-equalizer .nav-bar {
            background: var(--accent-crimson);
        }

        .nav-bgm-btn.is-active .nav-bgm-equalizer .nav-bar-1 {
            animation: nav-eq-1 0.8s ease-in-out infinite alternate;
        }

        .nav-bgm-btn.is-active .nav-bgm-equalizer .nav-bar-2 {
            animation: nav-eq-2 0.6s ease-in-out infinite alternate;
        }

        .nav-bgm-btn.is-active .nav-bgm-equalizer .nav-bar-3 {
            animation: nav-eq-3 0.7s ease-in-out infinite alternate;
        }

        @keyframes nav-eq-1 { 0% { height: 3px; } 100% { height: 12px; } }
        @keyframes nav-eq-2 { 0% { height: 12px; } 100% { height: 4px; } }
        @keyframes nav-eq-3 { 0% { height: 4px; } 100% { height: 10px; } }

        .nav-bgm-state {
            font-size: 0.68rem;
            font-weight: 700;
            padding: 1px 5px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .nav-bgm-btn.is-active .nav-bgm-state {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        /* Floating BGM Player Container */
        .bgm-player-widget {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 45;
            font-family: var(--font-sans);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Collapsed Pill */
        .bgm-pill-view {
            display: none;
            align-items: center;
            gap: 10px;
            background: rgba(15, 17, 23, 0.94);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-strong);
            border-radius: 100px;
            padding: 8px 14px 8px 12px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.6), 0 0 12px rgba(230, 57, 70, 0.1);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            user-select: none;
        }

        .bgm-pill-view:hover {
            border-color: rgba(230, 57, 70, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.7), 0 0 20px rgba(230, 57, 70, 0.2);
        }

        .bgm-player-widget.is-collapsed .bgm-pill-view {
            display: flex;
        }

        .bgm-player-widget.is-collapsed .bgm-deck-card {
            display: none;
        }

        .pill-eq-bars {
            display: flex;
            align-items: flex-end;
            gap: 2.5px;
            height: 14px;
        }

        .pill-eq-bar {
            width: 3px;
            background: var(--accent-crimson);
            border-radius: 1px;
            height: 4px;
            transition: height 0.15s ease;
        }

        .bgm-player-widget.is-playing .pill-eq-bar:nth-child(1) { animation: eq-wave 0.7s infinite alternate ease-in-out; }
        .bgm-player-widget.is-playing .pill-eq-bar:nth-child(2) { animation: eq-wave 0.5s infinite alternate ease-in-out 0.1s; }
        .bgm-player-widget.is-playing .pill-eq-bar:nth-child(3) { animation: eq-wave 0.8s infinite alternate ease-in-out 0.2s; }
        .bgm-player-widget.is-playing .pill-eq-bar:nth-child(4) { animation: eq-wave 0.6s infinite alternate ease-in-out 0.15s; }

        @keyframes eq-wave {
            0% { height: 3px; }
            100% { height: 14px; }
        }

        .pill-text-group {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .pill-title {
            font-family: var(--font-display);
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-primary);
            white-space: nowrap;
        }

        .pill-subtitle {
            font-family: var(--font-mono);
            font-size: 0.64rem;
            color: var(--text-muted);
            letter-spacing: 0.04em;
        }

        .pill-play-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--accent-crimson);
            border: none;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            margin-left: 4px;
            flex-shrink: 0;
        }

        .pill-play-btn:hover {
            transform: scale(1.08);
            background: var(--accent-crimson-hover);
        }

        /* Expanded Deck Card */
        .bgm-deck-card {
            width: 360px;
            max-width: calc(100vw - 32px);
            background: rgba(15, 17, 23, 0.94);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-strong);
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 20px 48px rgba(0, 0, 0, 0.75), 0 0 24px rgba(0, 0, 0, 0.5);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .bgm-player-widget.is-playing .bgm-deck-card {
            border-color: rgba(230, 57, 70, 0.35);
            box-shadow: 0 24px 56px rgba(0, 0, 0, 0.8), 0 0 24px rgba(230, 57, 70, 0.12);
        }

        /* Top accent line */
        .bgm-deck-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent-crimson), var(--accent-amber), transparent);
            opacity: 0.6;
        }

        .bgm-deck-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-subtle);
        }

        .bgm-header-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: var(--font-mono);
            font-size: 0.7rem;
            color: var(--text-secondary);
            letter-spacing: 0.06em;
            font-weight: 600;
        }

        .bgm-status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--accent-amber);
            box-shadow: 0 0 6px var(--accent-amber);
            transition: all 0.2s ease;
        }

        .bgm-player-widget.is-playing .bgm-status-dot {
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
            animation: pulse-dot 1.8s infinite ease-in-out;
        }

        .bgm-kanji-tag {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-left: 2px;
        }

        .bgm-header-tools {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .bgm-tool-btn {
            background: transparent;
            border: 1px solid transparent;
            border-radius: 6px;
            color: var(--text-muted);
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .bgm-tool-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--border-subtle);
        }

        .bgm-tool-btn.is-active {
            color: var(--accent-crimson);
            background: rgba(230, 57, 70, 0.1);
            border-color: rgba(230, 57, 70, 0.3);
        }

        /* Station Switcher Chips */
        .bgm-station-bar {
            display: flex;
            align-items: center;
            gap: 6px;
            overflow-x: auto;
            padding-bottom: 6px;
            margin-bottom: 10px;
            scrollbar-width: none;
        }
        .bgm-station-bar::-webkit-scrollbar {
            display: none;
        }
        .bgm-station-chip {
            padding: 4px 9px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            color: var(--text-muted);
            font-size: 0.68rem;
            font-family: var(--font-mono);
            font-weight: 500;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .bgm-station-chip:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--border-strong);
        }
        .bgm-station-chip.is-active {
            background: rgba(230, 57, 70, 0.15);
            border-color: rgba(230, 57, 70, 0.4);
            color: #ffffff;
            font-weight: 600;
        }

        /* Video Drawer Container */
        .bgm-video-drawer {
            height: 0;
            opacity: 0;
            margin-bottom: 0;
            overflow: hidden;
            border-radius: 10px;
            border: 1px solid transparent;
            background: #000000;
            transition: height 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease, margin-bottom 0.3s ease, border-color 0.25s ease;
            position: relative;
        }

        .bgm-video-drawer.is-open {
            height: 185px;
            opacity: 1;
            margin-bottom: 12px;
            border-color: var(--border-strong);
        }

        .bgm-iframe-wrapper {
            width: 100%;
            height: 185px;
            position: relative;
        }

        .bgm-iframe-wrapper iframe,
        .bgm-iframe-wrapper div {
            width: 100% !important;
            height: 100% !important;
            border: 0;
            display: block;
        }

        /* Error / Restriction Overlay */
        .bgm-embed-warning {
            display: none;
            position: absolute;
            inset: 0;
            background: rgba(15, 17, 23, 0.94);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 10;
            padding: 16px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 8px;
            border-radius: 8px;
        }
        .bgm-embed-warning.is-visible {
            display: flex;
        }
        .bgm-embed-warning p {
            font-size: 0.72rem;
            color: var(--text-secondary);
            line-height: 1.35;
            max-width: 260px;
        }
        .bgm-embed-warning a, .bgm-embed-warning button {
            font-size: 0.7rem;
            padding: 5px 11px;
            border-radius: 6px;
            font-family: var(--font-mono);
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.15s ease;
        }

        /* Track Info Box */
        .bgm-track-box {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .bgm-disc-art {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: linear-gradient(135deg, #1c202d, #0d0f14);
            border: 1px solid var(--border-strong);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-crimson);
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        }

        .bgm-player-widget.is-playing .bgm-disc-art::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 10px;
            border: 1.5px solid var(--accent-crimson);
            opacity: 0.7;
            animation: disc-pulse 2s infinite ease-in-out;
        }

        @keyframes disc-pulse {
            0%, 100% { transform: scale(1); opacity: 0.7; }
            50% { transform: scale(1.05); opacity: 0.2; }
        }

        .bgm-track-meta {
            flex: 1;
            min-width: 0;
        }

        .bgm-track-title {
            font-family: var(--font-display);
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
            margin-bottom: 3px;
        }

        .bgm-track-artist {
            font-family: var(--font-mono);
            font-size: 0.68rem;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .bgm-time-display {
            font-family: var(--font-mono);
            font-size: 0.68rem;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* Progress Bar */
        .bgm-progress-container {
            margin-bottom: 12px;
            cursor: pointer;
            padding: 4px 0;
        }

        .bgm-progress-track {
            height: 4px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 4px;
            position: relative;
            transition: height 0.15s ease;
        }

        .bgm-progress-container:hover .bgm-progress-track {
            height: 6px;
        }

        .bgm-progress-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--accent-crimson), var(--accent-amber));
            border-radius: 4px;
            position: relative;
            transition: width 0.1s linear;
        }

        .bgm-progress-handle {
            position: absolute;
            right: -5px;
            top: 50%;
            transform: translateY(-50%) scale(0);
            width: 10px;
            height: 10px;
            background: #ffffff;
            border-radius: 50%;
            box-shadow: 0 0 6px var(--accent-crimson);
            transition: transform 0.15s ease;
        }

        .bgm-progress-container:hover .bgm-progress-handle {
            transform: translateY(-50%) scale(1);
        }

        /* Main Deck Controls */
        .bgm-deck-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .bgm-ctrl-btn {
            background: transparent;
            border: 1px solid transparent;
            color: var(--text-secondary);
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .bgm-ctrl-btn:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--border-subtle);
        }

        .bgm-ctrl-btn.is-active {
            color: var(--accent-crimson);
        }

        .bgm-play-main-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-crimson);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 14px var(--accent-crimson-glow);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .bgm-play-main-btn:hover {
            background: var(--accent-crimson-hover);
            transform: scale(1.06);
            box-shadow: 0 6px 20px var(--accent-crimson-glow);
        }

        .bgm-play-main-btn:active {
            transform: scale(0.96);
        }

        .bgm-volume-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .bgm-vol-slider {
            width: 64px;
            height: 4px;
            -webkit-appearance: none;
            appearance: none;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 2px;
            outline: none;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .bgm-vol-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--text-primary);
            cursor: pointer;
            transition: transform 0.1s ease, background 0.1s ease;
        }

        .bgm-vol-slider::-webkit-slider-thumb:hover {
            transform: scale(1.2);
            background: var(--accent-crimson);
        }

        .bgm-vol-slider::-moz-range-thumb {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--text-primary);
            border: none;
            cursor: pointer;
        }

        .bgm-hotkey-hint {
            font-family: var(--font-mono);
            font-size: 0.62rem;
            color: var(--text-muted);
            padding: 1px 4px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-subtle);
            user-select: none;
        }

        @media (max-width: 768px) {
            .bgm-player-widget {
                bottom: 16px;
                right: 16px;
                left: 16px;
            }

            .bgm-deck-card {
                width: 100%;
                max-width: 100%;
            }

            .bgm-vol-slider {
                width: 48px;
            }
        }
    </style>
</head>
<body>
    <div class="manga-grid-overlay"></div>

    <!-- Navigation Bar -->
    <header class="navbar">
        <div class="container">
            <div class="nav-inner">
                <a href="/" class="brand-link">
                    <div class="brand-icon">
                        <img src="{{ asset('logo.svg') }}" alt="ComicGarage Logo" style="width: 24px; height: 24px; object-fit: contain; border-radius: 4px;">
                    </div>
                    <div class="brand-text">
                        <span class="brand-title">ComicGarage</span>
                        <span class="brand-tag">私設コミック書庫 // ARCHIVE 01</span>
                    </div>
                </a>

                <div class="nav-center">
                    <div class="live-status-pill">
                        <span class="status-dot"></span>
                        <span>{{ $stats['totalTitles'] ?? 0 }} TITLES</span>
                        <span style="opacity: 0.3">•</span>
                        <span>{{ $stats['collectedVolumes'] ?? 0 }} VOLUMES</span>
                        <span style="opacity: 0.3">•</span>
                        <span style="color: #34d399;">{{ $stats['collectionRate'] ?? 0 }}% COMPLETE</span>
                    </div>
                </div>

                <div class="nav-actions">
                    <button id="navBgmBtn" class="nav-bgm-btn" type="button" title="Toggle Ambient Audio (Hotkey: M)">
                        <div class="nav-bgm-equalizer">
                            <span class="nav-bar nav-bar-1"></span>
                            <span class="nav-bar nav-bar-2"></span>
                            <span class="nav-bar nav-bar-3"></span>
                        </div>
                        <span>BGM</span>
                        <span class="nav-bgm-state" id="navBgmState">OFF</span>
                    </button>
                    <a href="#shelf" class="btn-secondary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                        Catalog
                    </a>
                    <a href="/admin" class="btn-vault">
                        <span>Vault Dashboard</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/>
                            <path d="m12 5 7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-grid">
                    <!-- Left: Narrative & Stats -->
                    <div class="hero-left">
                        <div class="hero-eyebrow">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect width="18" height="18" x="3" y="3" rx="2"/>
                                <path d="M3 9h18"/>
                                <path d="M9 21V9"/>
                            </svg>
                            JAPANESE TANKŌBON & GRAPHIC NOVEL ARCHIVE
                        </div>
                        <h1 class="hero-title">
                            Curate, Catalog & Track Every Tankōbon.
                        </h1>
                        <p class="hero-description">
                            A precision collector system to catalog physical manga series, detect missing volume gaps, and monitor collection milestones.
                        </p>

                        <div class="hero-cta-group">
                            <a href="/admin" class="btn-vault">
                                <span>Enter Vault</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M15 3h6v6"/>
                                    <path d="M10 14 21 3"/>
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                </svg>
                            </a>
                            <a href="#shelf" class="btn-secondary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14"/>
                                    <path d="m19 12-7 7-7-7"/>
                                </svg>
                                Browse Shelf
                            </a>
                        </div>

                        <!-- Stats Row -->
                        <div class="hero-stats">
                            <div class="stat-card">
                                <div class="stat-value">
                                    {{ $stats['totalTitles'] ?? 0 }}
                                    <span class="stat-unit">SERIES</span>
                                </div>
                                <div class="stat-label">Total Titles</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">
                                    {{ $stats['totalVolumes'] ?? 0 }}
                                    <span class="stat-unit">VOLS</span>
                                </div>
                                <div class="stat-label">Tracked Books</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">
                                    {{ $stats['collectionRate'] ?? 0 }}<span class="stat-unit">%</span>
                                </div>
                                <div class="stat-label">Completion</div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-value">
                                    {{ $stats['incompleteSeries'] ?? 0 }}
                                    <span class="stat-unit" style="color: var(--accent-amber);">GAPS</span>
                                </div>
                                <div class="stat-label">Ongoing Runs</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Spotlight Feature Card -->
                    <div class="hero-showcase">
                        @php
                            $spotlight = $comics->first();
                            $spotlightTotal = $spotlight ? $spotlight->comicvol->count() : 0;
                            $spotlightCollected = $spotlight ? $spotlight->comicvol->where('is_collected', true)->count() : 0;
                            $spotlightPct = $spotlightTotal > 0 ? round(($spotlightCollected / $spotlightTotal) * 100) : 0;
                            $spotlightComplete = ($spotlightTotal > 0 && $spotlightCollected === $spotlightTotal);
                        @endphp

                        @if($spotlight)
                            <div class="showcase-frame">
                                <div class="showcase-header">
                                    <span class="showcase-tag">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                        </svg>
                                        Featured Collection
                                    </span>
                                    <span class="showcase-kanji">特別収蔵</span>
                                </div>

                                <div class="showcase-body">
                                    <div class="spotlight-book-cover" onclick="openInspectorModal({{ $spotlight->id }})">
                                        @if($spotlight->image)
                                            <img src="{{ asset('storage/' . $spotlight->image) }}" 
                                                 alt="{{ $spotlight->name }}"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        @endif
                                        <div class="card-cover-placeholder" style="{{ $spotlight->image ? 'display: none;' : '' }}">
                                            <span class="placeholder-tag">{{ $spotlight->genre ?? 'Manga' }}</span>
                                            <div class="placeholder-title">{{ $spotlight->name }}</div>
                                            <span class="placeholder-author">{{ $spotlight->author->name ?? 'Unknown Author' }}</span>
                                        </div>
                                    </div>

                                    <div class="spotlight-info">
                                        <div>
                                            <span class="spotlight-meta-genre">{{ $spotlight->genre ?? 'Manga' }}</span>
                                            <h2 class="spotlight-comic-title">{{ $spotlight->name }}</h2>
                                            <p class="spotlight-comic-author">Story & Art by {{ $spotlight->author->name ?? 'Unknown Author' }}</p>
                                        </div>

                                        <div class="spotlight-progress-box">
                                            <div class="progress-header">
                                                <span>Volume Progress</span>
                                                <span>{{ $spotlightCollected }} / {{ $spotlightTotal }} Books</span>
                                            </div>
                                            <div class="progress-bar-track">
                                                <div class="progress-bar-fill" style="width: {{ $spotlightPct }}%;"></div>
                                            </div>
                                            <div class="progress-status-badge {{ $spotlightComplete ? 'badge-complete' : 'badge-ongoing' }}">
                                                @if($spotlightTotal == 0)
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                                    NO VOLUMES LOGGED
                                                @elseif($spotlightComplete)
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                                    COMPLETE RUN ({{ $spotlightTotal }} VOLS)
                                                @else
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                    {{ $spotlightTotal - $spotlightCollected }} VOLUMES MISSING
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="showcase-frame" style="text-align: center; padding: 48px 24px;">
                                <div class="showcase-tag" style="justify-content: center; margin-bottom: 12px;">Vault Initialized</div>
                                <h3 style="font-family: var(--font-display); font-size: 1.25rem; margin-bottom: 8px;">Your Archive is Ready</h3>
                                <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 20px;">Add your first comic title through the Filament dashboard to begin tracking.</p>
                                <a href="/admin/comics/create" class="btn-vault" style="margin: 0 auto;">Add First Manga Title</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Shelf Catalog Section -->
        <section id="shelf" class="shelf-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-title-wrap">
                        <h2 class="section-title">Collection Shelf</h2>
                        <p class="section-subtitle">Real-time inventory of physical & digital manga series.</p>
                    </div>
                </div>

                <!-- Interactive Shelf Controls -->
                <div class="shelf-controls-bar">
                    <div class="filter-row-primary">
                        <!-- Dynamic Instant Search -->
                        <div class="search-input-wrap">
                            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.3-4.3"/>
                            </svg>
                            <input type="text" id="comicSearch" class="search-input" placeholder="Search title, mangaka, or genre...">
                            <button id="searchClearBtn" class="search-clear-btn" title="Clear search">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                            <span class="search-kbd" id="searchKbdHint">/</span>
                        </div>

                        <!-- Status Filter Tabs -->
                        <div class="filter-tabs">
                            <button class="filter-btn active" data-status="all">All Titles</button>
                            <button class="filter-btn" data-status="incomplete">Missing Gaps</button>
                            <button class="filter-btn" data-status="complete">Complete Sets</button>
                        </div>
                    </div>

                    <!-- Genre Filter Pills -->
                    @if(isset($genres) && $genres->count() > 0)
                        <div class="genre-chips-row">
                            <span class="genre-chip-label">Genre:</span>
                            <button class="genre-chip active" data-genre="all">All</button>
                            @foreach($genres as $genre)
                                <button class="genre-chip" data-genre="{{ strtolower($genre) }}">{{ ucfirst($genre) }}</button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Shelf Results Count -->
                <div class="shelf-results-info">
                    <span id="shelfCounter">Showing {{ $comics->count() }} of {{ $comics->count() }} series</span>
                    <span style="color: var(--text-muted);">ESC TO CLEAR FILTERS</span>
                </div>

                <!-- Grid of Comic Cards -->
                <div class="comic-grid" id="comicContainer">
                    @forelse($comics as $comic)
                        @php
                            $totalVols = $comic->comicvol->count();
                            $collectedVols = $comic->comicvol->where('is_collected', true)->count();
                            $pct = $totalVols > 0 ? round(($collectedVols / $totalVols) * 100) : 0;
                            $isComplete = ($totalVols > 0 && $collectedVols === $totalVols);
                            $missingCount = max(0, $totalVols - $collectedVols);
                        @endphp

                        <div class="comic-card" 
                             id="comic-card-{{ $comic->id }}"
                             data-id="{{ $comic->id }}"
                             data-title="{{ strtolower($comic->name) }}" 
                             data-author="{{ strtolower($comic->author->name ?? '') }}" 
                             data-genre="{{ strtolower($comic->genre ?? '') }}"
                             data-status="{{ $isComplete ? 'complete' : 'incomplete' }}">
                            
                            <div class="card-cover-wrap" onclick="openInspectorModal({{ $comic->id }})">
                                <span class="card-genre-badge">{{ $comic->genre ?? 'Manga' }}</span>
                                @if($comic->image)
                                    <img src="{{ asset('storage/' . $comic->image) }}" 
                                         alt="{{ $comic->name }}" 
                                         class="card-cover-img" 
                                         loading="lazy"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif
                                <div class="card-cover-placeholder" style="{{ $comic->image ? 'display: none;' : '' }}">
                                    <span class="placeholder-tag">{{ $comic->genre ?? 'Tankōbon' }}</span>
                                    <div class="placeholder-title">{{ $comic->name }}</div>
                                    <span class="placeholder-author">{{ $comic->author->name ?? 'Unknown Author' }}</span>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="card-title-group">
                                    <h3 class="card-title">{{ $comic->name }}</h3>
                                    <p class="card-author">{{ $comic->author->name ?? 'Unknown Author' }}</p>
                                </div>

                                <div class="card-volume-info">
                                    <div class="vol-header">
                                        <span>Progress: {{ $collectedVols }}/{{ $totalVols }} Vols</span>
                                        <span>{{ $pct }}%</span>
                                    </div>
                                    <div class="vol-meter">
                                        <div class="vol-meter-fill" style="width: {{ $pct }}%;"></div>
                                    </div>

                                    <!-- Mini volume chips -->
                                    <div class="vol-pills-row">
                                        @foreach($comic->comicvol as $vol)
                                            <span class="vol-pill {{ $vol->is_collected ? 'collected' : 'missing' }}" title="Vol. {{ $vol->volume }}: {{ $vol->is_collected ? 'Collected' : 'Missing Gap' }}">
                                                v{{ $vol->volume }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="card-footer-action">
                                    <span class="card-status-text {{ $isComplete ? 'badge-complete' : 'badge-ongoing' }}">
                                        @if($totalVols == 0)
                                            No Volumes
                                        @elseif($isComplete)
                                            Complete Set
                                        @else
                                            {{ $missingCount }} Gaps Remaining
                                        @endif
                                    </span>
                                    <div class="card-btn-group">
                                        <button type="button" class="card-quick-view-btn" onclick="openInspectorModal({{ $comic->id }})">
                                            Inspect
                                        </button>
                                        <a href="/admin/comics/{{ $comic->id }}/edit" class="card-edit-btn" title="Edit in Filament Vault">
                                            <span>Edit</span>
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <path d="M5 12h14"/>
                                                <path d="m12 5 7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Embedded JSON for Quick Inspector Modal -->
                            <script type="application/json" id="comic-data-{{ $comic->id }}">
                                {
                                    "id": {{ $comic->id }},
                                    "name": @json($comic->name),
                                    "author": @json($comic->author->name ?? 'Unknown Author'),
                                    "genre": @json($comic->genre ?? 'Manga'),
                                    "image": @json($comic->image ? asset('storage/' . $comic->image) : null),
                                    "totalVols": {{ $totalVols }},
                                    "collectedVols": {{ $collectedVols }},
                                    "pct": {{ $pct }},
                                    "isComplete": {{ $isComplete ? 'true' : 'false' }},
                                    "volumes": @json($comic->comicvol->map(function($v) {
                                        return [
                                            'volume' => $v->volume,
                                            'volume_name' => $v->volume_name,
                                            'is_collected' => (bool)$v->is_collected
                                        ];
                                    }))
                                }
                            </script>
                        </div>
                    @empty
                        <div class="empty-shelf-box">
                            <div class="empty-icon">📚</div>
                            <h3 style="font-family: var(--font-display); font-size: 1.25rem; margin-bottom: 8px;">No Titles in Archive Yet</h3>
                            <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 20px;">Start your collection database by logging manga series and tankōbon volumes.</p>
                            <a href="/admin/comics/create" class="btn-vault">Add New Comic Series</a>
                        </div>
                    @endforelse

                    <!-- Zero Matches Dynamic Feedback -->
                    <div id="noResultsBox" class="no-results-box">
                        <div class="empty-icon">🔍</div>
                        <h3 style="font-family: var(--font-display); font-size: 1.25rem; margin-bottom: 8px;">No Matching Series Found</h3>
                        <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 20px;">No titles match your current search query or active filter selection.</p>
                        <button type="button" id="resetFiltersBtn" class="btn-secondary" style="margin: 0 auto;">Reset All Filters</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bento Highlights Section -->
        <section class="bento-section">
            <div class="container">
                <div class="bento-grid">
                    <!-- Tile 1: Spanning Gap Radar -->
                    <div class="bento-card col-span-2">
                        <div>
                            <div class="bento-icon-wrap">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="m21 21-4.3-4.3"/>
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="M11 8v6"/>
                                    <path d="M8 11h6"/>
                                </svg>
                            </div>
                            <h3 class="bento-title">Volume Gap Radar</h3>
                            <p class="bento-desc">
                                Instantly scan uncollected volumes across all ongoing manga series. Take the exact checklist to bookstore visits and never purchase duplicate tankōbon volumes again.
                            </p>
                        </div>
                        <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-family: var(--font-mono); font-size: 0.78rem; color: var(--text-muted);">
                                {{ $stats['incompleteSeries'] ?? 0 }} INCOMPLETE RUNS MONITORED
                            </span>
                            <a href="/admin/comics" style="color: var(--accent-crimson); font-size: 0.85rem; font-weight: 600; text-decoration: none;">View Incomplete Runs →</a>
                        </div>
                    </div>

                    <!-- Tile 2: Spending Analytics -->
                    <div class="bento-card">
                        <div>
                            <div class="bento-icon-wrap">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" x2="12" y1="2" y2="22"/>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                </svg>
                            </div>
                            <h3 class="bento-title">Acquisition Ledger</h3>
                            <p class="bento-desc">
                                Track total vault investment, individual volume receipts, and monthly budget trends.
                            </p>
                        </div>
                        <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-subtle);">
                            <span style="font-family: var(--font-mono); font-size: 0.95rem; color: #34d399; font-weight: 700; display: block;">
                                Rp {{ number_format($stats['totalInvestment'] ?? 0, 0, ',', '.') }}
                            </span>
                            <a href="/admin/comic-purchases" style="color: var(--text-secondary); font-size: 0.78rem; text-decoration: none; margin-top: 4px; display: inline-block;">Open Purchase History →</a>
                        </div>
                    </div>

                    <!-- Tile 3: Multi-Volume Batch Creator -->
                    <div class="bento-card">
                        <div>
                            <div class="bento-icon-wrap">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                                    <path d="M12 6v6"/>
                                    <path d="M9 9h6"/>
                                </svg>
                            </div>
                            <h3 class="bento-title">Batch Ingestion</h3>
                            <p class="bento-desc">
                                Rapid multi-volume generator: spin up 1 to 100 volume checklists in a single click when adding new manga series.
                            </p>
                        </div>
                        <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-subtle);">
                            <a href="/admin/comics/create" style="color: var(--text-secondary); font-size: 0.82rem; font-weight: 600; text-decoration: none;">Create New Series →</a>
                        </div>
                    </div>

                    <!-- Tile 4: Mangaka & Taxonomy Index -->
                    <div class="bento-card col-span-2">
                        <div>
                            <div class="bento-icon-wrap">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                            <h3 class="bento-title">Mangaka & Publisher Taxonomy</h3>
                            <p class="bento-desc">
                                Link series to their original authors and artists. Filter by genre (Shounen, Seinen, Horror, America) and track creator bibliographies across your entire collection.
                            </p>
                        </div>
                        <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-family: var(--font-mono); font-size: 0.78rem; color: var(--text-muted);">
                                {{ $stats['totalTitles'] ?? 0 }} MANGA SERIES CATALOGED
                            </span>
                            <a href="/admin/comics" style="color: var(--accent-crimson); font-size: 0.85rem; font-weight: 600; text-decoration: none;">Manage Vault Catalog →</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recent Purchases Table (if available) -->
        @if($recentPurchases && $recentPurchases->count() > 0)
            <section class="purchases-section">
                <div class="container">
                    <div class="section-header">
                        <div class="section-title-wrap">
                            <h2 class="section-title">Recent Acquisitions</h2>
                            <p class="section-subtitle">Chronological ledger of latest additions to the collection.</p>
                        </div>
                        <a href="/admin/comic-purchases" class="btn-secondary">View Full Ledger →</a>
                    </div>

                    <div class="purchase-table-frame">
                        <div class="purchase-row header">
                            <span>Title & Volume</span>
                            <span>Price</span>
                            <span>Store</span>
                            <span>Acquisition Date</span>
                        </div>
                        @foreach($recentPurchases as $purchase)
                            <div class="purchase-row">
                                <div class="purchase-title">
                                    {{ $purchase->title }} <span style="font-family: var(--font-mono); color: var(--accent-crimson);">Vol. {{ $purchase->volume }}</span>
                                </div>
                                <div class="purchase-price">
                                    Rp {{ number_format($purchase->price, 0, ',', '.') }}
                                </div>
                                <div class="purchase-store">
                                    {{ $purchase->store ?: 'Store / Marketplace' }}
                                </div>
                                <div class="purchase-date">
                                    {{ $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->translatedFormat('d M Y') : '-' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

    <!-- Quick Inspector Modal -->
    <div id="inspectorModal" class="modal-overlay" onclick="handleModalBackdropClick(event)">
        <div class="modal-card">
            <button type="button" class="modal-close-btn" onclick="closeInspectorModal()" title="Close (Esc)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>

            <div class="modal-header-section">
                <div class="modal-cover-wrap" id="modalCoverWrap">
                    <img id="modalCoverImg" src="" alt="Cover" style="display: none;">
                    <div id="modalCoverPlaceholder" class="card-cover-placeholder">
                        <span class="placeholder-tag" id="modalPlaceholderTag">MANGA</span>
                        <div class="placeholder-title" id="modalPlaceholderTitle" style="font-size: 0.95rem;">-</div>
                    </div>
                </div>

                <div class="modal-meta">
                    <span class="modal-genre-tag" id="modalGenreTag">SHONEN</span>
                    <h3 class="modal-title" id="modalTitle">Title</h3>
                    <p class="modal-author" id="modalAuthor">by Author</p>
                    <div class="progress-status-badge" id="modalStatusBadge">STATUS</div>
                </div>
            </div>

            <div class="modal-vol-matrix-title">
                <span>Volume Breakdown</span>
                <span id="modalVolStats">0 / 0 Collected</span>
            </div>

            <div class="modal-vol-grid" id="modalVolGrid">
                <!-- Injected via JavaScript -->
            </div>

            <div class="modal-actions">
                <span style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--text-muted);" id="modalGapSummary">
                    -
                </span>
                <a href="#" id="modalAdminEditLink" class="btn-vault" style="padding: 6px 14px; font-size: 0.8rem;">
                    <span>Open in Vault</span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14"/>
                        <path d="m12 5 7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-inner">
                <div class="footer-brand">
                    <div class="footer-title">ComicGarage</div>
                    <div class="footer-desc">Personal Tankōbon Archive & Tracking System • Powered by Laravel & Filament</div>
                </div>

                <div class="footer-links">
                    <a href="/admin" class="footer-link">Dashboard</a>
                    <a href="/admin/comics" class="footer-link">Comics Catalog</a>
                    <a href="/admin/comic-purchases" class="footer-link">Purchases Ledger</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Ambient YouTube Audio Deck Widget -->
    <aside class="bgm-player-widget" id="bgmPlayerWidget" aria-label="Ambient Music Player">
        <!-- Collapsed Mini Pill View -->
        <div class="bgm-pill-view" id="bgmPillView" title="Click to open Ambient Audio Deck">
            <div class="pill-eq-bars">
                <span class="pill-eq-bar"></span>
                <span class="pill-eq-bar"></span>
                <span class="pill-eq-bar"></span>
                <span class="pill-eq-bar"></span>
            </div>
            <div class="pill-text-group">
                <span class="pill-title">Ambient BGM</span>
                <span class="pill-subtitle" id="bgmPillStatusText">Paused</span>
            </div>
            <button class="pill-play-btn" id="bgmPillPlayBtn" type="button" title="Play / Pause" aria-label="Play or Pause BGM">
                <svg id="pillPlayIcon" width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                <svg id="pillPauseIcon" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="display: none;"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
            </button>
        </div>

        <!-- Expanded Cyber-Deck View -->
        <div class="bgm-deck-card" id="bgmDeckCard">
            <!-- Header -->
            <div class="bgm-deck-header">
                <div class="bgm-header-badge">
                    <span class="bgm-status-dot" id="bgmStatusDot"></span>
                    <span>SOUND VAULT // BGM</span>
                    <span class="bgm-kanji-tag">環境音楽</span>
                </div>
                <div class="bgm-header-tools">
                    <button class="bgm-tool-btn is-active" id="bgmVideoToggleBtn" type="button" title="Toggle Video Screen">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="15" x="2" y="3" rx="2"/><polyline points="8 21 12 17 16 21"/>
                        </svg>
                    </button>
                    <a href="https://www.youtube.com/watch?v=DkPjOnUr4M4&list=RDDkPjOnUr4M4&start_radio=1" target="_blank" rel="noopener noreferrer" class="bgm-tool-btn" title="Open in YouTube">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                        </svg>
                    </a>
                    <button class="bgm-tool-btn" id="bgmMinimizeBtn" type="button" title="Minimize to Pill">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Station Selector Tabs -->
            <div class="bgm-station-bar" id="bgmStationBar">
                <button class="bgm-station-chip is-active" data-video-id="jfKfPfyJRdk" data-title="Lofi Girl • 24/7 Anime Lofi Beats" type="button" title="Live 24/7 Lofi Stream">
                    <span>⚡ Lofi Live</span>
                </button>
                <button class="bgm-station-chip" data-video-id="5qap5aO4i9A" data-title="Studio Ghibli • Chill Anime Lounge" type="button" title="Relaxing Ghibli Beats">
                    <span>🌸 Ghibli Lofi</span>
                </button>
                <button class="bgm-station-chip" data-video-id="TURbeWK2wwg" data-title="4 A.M Manga Reading Session" type="button" title="Late Night Manga Reading">
                    <span>🌙 4 A.M Chill</span>
                </button>
                <button class="bgm-station-chip" data-video-id="DkPjOnUr4M4" data-title="Anime Openings Lofi Mix (LlamaLoops)" type="button" title="User Mix (DkPjOnUr4M4)">
                    <span>📻 User Mix</span>
                </button>
            </div>

            <!-- Optional Video Drawer Screen (Open by default) -->
            <div class="bgm-video-drawer is-open" id="bgmVideoDrawer">
                <div class="bgm-iframe-wrapper" id="bgmIframeTarget">
                    <iframe id="ambient-yt-player" 
                        src="https://www.youtube.com/embed/jfKfPfyJRdk?enablejsapi=1&playsinline=1&rel=0&controls=1&modestbranding=1" 
                        title="YouTube Ambient Audio Player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                        style="width: 100%; height: 100%; border: 0; display: block; border-radius: 8px;">
                    </iframe>
                    <!-- Error / Restriction Overlay -->
                    <div class="bgm-embed-warning" id="bgmEmbedWarning">
                        <div style="font-size: 1.15rem;">⚠️</div>
                        <p id="bgmWarningText">Video ini membatasi pemutaran embed oleh pemilik hak cipta YouTube.</p>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: center;">
                            <a id="bgmOpenYtDirectLink" href="https://www.youtube.com/watch?v=DkPjOnUr4M4&list=RDDkPjOnUr4M4" target="_blank" rel="noopener noreferrer" style="background: var(--accent-crimson); color: #fff; border: 1px solid rgba(255,255,255,0.2);">
                                Buka di YouTube Tab ↗
                            </a>
                            <button id="bgmAutoSwitchBtn" type="button" style="background: var(--bg-surface-elevated); color: var(--text-primary); border: 1px solid var(--border-strong);">
                                Ganti ke Lofi Live ⚡
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Track Info -->
            <div class="bgm-track-box">
                <div class="bgm-disc-art">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <circle cx="12" cy="12" r="3"/>
                        <line x1="12" y1="2" x2="12" y2="4"/>
                        <line x1="12" y1="20" x2="12" y2="22"/>
                        <line x1="20" y1="12" x2="22" y2="12"/>
                        <line x1="2" y1="12" x2="4" y2="12"/>
                    </svg>
                </div>
                <div class="bgm-track-meta">
                    <div class="bgm-track-title" id="bgmTrackTitle">Midnight Lounge • Japanese Chill</div>
                    <div class="bgm-track-artist">
                        <span>YT RADIO FEED</span>
                        <span style="opacity: 0.3">•</span>
                        <span>DkPjOnUr4M4</span>
                    </div>
                    <div class="bgm-time-display">
                        <span id="bgmCurrentTime">00:00</span> / <span id="bgmTotalDuration">--:--</span>
                    </div>
                </div>
            </div>

            <!-- Seekable Progress Bar -->
            <div class="bgm-progress-container" id="bgmProgressContainer" title="Click to seek">
                <div class="bgm-progress-track">
                    <div class="bgm-progress-fill" id="bgmProgressFill">
                        <div class="bgm-progress-handle"></div>
                    </div>
                </div>
            </div>

            <!-- Controls Deck -->
            <div class="bgm-deck-controls">
                <div style="display: flex; align-items: center; gap: 4px;">
                    <button class="bgm-ctrl-btn" id="bgmRestartBtn" type="button" title="Restart Track">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="19 20 9 12 19 4 19 20"/><line x1="5" y1="19" x2="5" y2="5"/>
                        </svg>
                    </button>
                    <button class="bgm-play-main-btn" id="bgmMainPlayBtn" type="button" title="Play Ambient Music (Hotkey: M)" aria-label="Play or Pause">
                        <svg id="mainPlayIcon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20 6 4"/></svg>
                        <svg id="mainPauseIcon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="display: none;"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
                    </button>
                    <button class="bgm-ctrl-btn" id="bgmForwardBtn" type="button" title="Forward 10s">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="5 4 15 12 5 20 5 4"/><line x1="19" y1="5" x2="19" y2="19"/>
                        </svg>
                    </button>
                </div>

                <div class="bgm-volume-group">
                    <button class="bgm-ctrl-btn" id="bgmMuteBtn" type="button" title="Mute / Unmute">
                        <svg id="volHighIcon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/>
                        </svg>
                        <svg id="volMuteIcon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                            <line x1="1" y1="1" x2="23" y2="23"/><path d="M9 9v3a3 3 0 0 0 5.12 2.12M15 9.34V4a3 3 0 0 0-5.94-.6"/>
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/>
                        </svg>
                    </button>
                    <input type="range" class="bgm-vol-slider" id="bgmVolumeSlider" min="0" max="100" value="80" title="Volume">
                    <span class="bgm-hotkey-hint" title="Keyboard Shortcut">M</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Interactive Client-side Filter Logic & Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('comicSearch');
            const searchClearBtn = document.getElementById('searchClearBtn');
            const searchKbdHint = document.getElementById('searchKbdHint');
            const statusBtns = document.querySelectorAll('.filter-btn');
            const genreChips = document.querySelectorAll('.genre-chip');
            const cards = document.querySelectorAll('.comic-card');
            const noResultsBox = document.getElementById('noResultsBox');
            const shelfCounter = document.getElementById('shelfCounter');
            const resetFiltersBtn = document.getElementById('resetFiltersBtn');

            let currentStatus = 'all';
            let currentGenre = 'all';
            let currentSearch = '';

            function applyFilters() {
                let visibleCount = 0;

                cards.forEach(card => {
                    const title = card.getAttribute('data-title') || '';
                    const author = card.getAttribute('data-author') || '';
                    const genre = card.getAttribute('data-genre') || '';
                    const status = card.getAttribute('data-status') || '';

                    const matchesSearch = !currentSearch || 
                                          title.includes(currentSearch) || 
                                          author.includes(currentSearch) || 
                                          genre.includes(currentSearch);

                    let matchesStatus = (currentStatus === 'all') || (status === currentStatus);
                    let matchesGenre = (currentGenre === 'all') || (genre === currentGenre);

                    if (matchesSearch && matchesStatus && matchesGenre) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (shelfCounter) {
                    shelfCounter.textContent = `Showing ${visibleCount} of ${cards.length} series`;
                }

                if (noResultsBox) {
                    if (cards.length > 0 && visibleCount === 0) {
                        noResultsBox.style.display = 'block';
                    } else {
                        noResultsBox.style.display = 'none';
                    }
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    currentSearch = e.target.value.toLowerCase().trim();
                    if (currentSearch.length > 0) {
                        if (searchClearBtn) searchClearBtn.style.display = 'flex';
                        if (searchKbdHint) searchKbdHint.style.display = 'none';
                    } else {
                        if (searchClearBtn) searchClearBtn.style.display = 'none';
                        if (searchKbdHint) searchKbdHint.style.display = 'block';
                    }
                    applyFilters();
                });
            }

            if (searchClearBtn) {
                searchClearBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    currentSearch = '';
                    searchClearBtn.style.display = 'none';
                    if (searchKbdHint) searchKbdHint.style.display = 'block';
                    searchInput.focus();
                    applyFilters();
                });
            }

            statusBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    statusBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentStatus = this.getAttribute('data-status');
                    applyFilters();
                });
            });

            genreChips.forEach(chip => {
                chip.addEventListener('click', function() {
                    genreChips.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    currentGenre = this.getAttribute('data-genre');
                    applyFilters();
                });
            });

            function resetAll() {
                currentStatus = 'all';
                currentGenre = 'all';
                currentSearch = '';
                if (searchInput) searchInput.value = '';
                if (searchClearBtn) searchClearBtn.style.display = 'none';
                if (searchKbdHint) searchKbdHint.style.display = 'block';

                statusBtns.forEach(b => b.classList.remove('active'));
                const defaultStatusBtn = document.querySelector('.filter-btn[data-status="all"]');
                if (defaultStatusBtn) defaultStatusBtn.classList.add('active');

                genreChips.forEach(c => c.classList.remove('active'));
                const defaultGenreChip = document.querySelector('.genre-chip[data-genre="all"]');
                if (defaultGenreChip) defaultGenreChip.classList.add('active');

                applyFilters();
            }

            if (resetFiltersBtn) {
                resetFiltersBtn.addEventListener('click', resetAll);
            }

            // Keyboard shortcut '/' to focus search, 'Esc' to clear/close, 'M' to toggle ambient audio
            document.addEventListener('keydown', function(e) {
                const activeTag = document.activeElement ? document.activeElement.tagName.toLowerCase() : '';
                const isInputActive = (activeTag === 'input' || activeTag === 'textarea' || document.activeElement.isContentEditable);

                if (e.key === '/' && !isInputActive && !e.ctrlKey && !e.altKey && !e.metaKey) {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else if ((e.key === 'm' || e.key === 'M') && !isInputActive && !e.ctrlKey && !e.altKey && !e.metaKey) {
                    e.preventDefault();
                    toggleBgmPlay();
                } else if (e.key === 'Escape') {
                    const modal = document.getElementById('inspectorModal');
                    if (modal && modal.style.display === 'flex') {
                        closeInspectorModal();
                    } else if (currentSearch || currentStatus !== 'all' || currentGenre !== 'all') {
                        resetAll();
                    }
                }
            });
        });

        // Quick Inspector Modal Logic
        function openInspectorModal(comicId) {
            const dataScript = document.getElementById('comic-data-' + comicId);
            if (!dataScript) return;

            let data;
            try {
                data = JSON.parse(dataScript.textContent);
            } catch (err) {
                console.error('Failed to parse comic data', err);
                return;
            }

            const modal = document.getElementById('inspectorModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalAuthor = document.getElementById('modalAuthor');
            const modalGenreTag = document.getElementById('modalGenreTag');
            const modalStatusBadge = document.getElementById('modalStatusBadge');
            const modalVolStats = document.getElementById('modalVolStats');
            const modalVolGrid = document.getElementById('modalVolGrid');
            const modalCoverImg = document.getElementById('modalCoverImg');
            const modalCoverPlaceholder = document.getElementById('modalCoverPlaceholder');
            const modalPlaceholderTitle = document.getElementById('modalPlaceholderTitle');
            const modalPlaceholderTag = document.getElementById('modalPlaceholderTag');
            const modalGapSummary = document.getElementById('modalGapSummary');
            const modalAdminEditLink = document.getElementById('modalAdminEditLink');

            modalTitle.textContent = data.name;
            modalAuthor.textContent = 'Story & Art by ' + (data.author || 'Unknown');
            modalGenreTag.textContent = (data.genre || 'Manga').toUpperCase();
            modalVolStats.textContent = `${data.collectedVols} / ${data.totalVols} Collected (${data.pct}%)`;

            if (data.isComplete) {
                modalStatusBadge.className = 'progress-status-badge badge-complete';
                modalStatusBadge.textContent = '✓ COMPLETE SET';
            } else {
                modalStatusBadge.className = 'progress-status-badge badge-ongoing';
                modalStatusBadge.textContent = `⏳ ${data.totalVols - data.collectedVols} VOLUMES MISSING`;
            }

            if (data.image) {
                modalCoverImg.src = data.image;
                modalCoverImg.style.display = 'block';
                modalCoverPlaceholder.style.display = 'none';
            } else {
                modalCoverImg.style.display = 'none';
                modalCoverPlaceholder.style.display = 'flex';
                modalPlaceholderTitle.textContent = data.name;
                modalPlaceholderTag.textContent = data.genre || 'MANGA';
            }

            // Populate Volume Grid
            modalVolGrid.innerHTML = '';
            const missingVols = [];

            if (data.volumes && data.volumes.length > 0) {
                data.volumes.forEach(v => {
                    if (!v.is_collected) missingVols.push(v.volume);

                    const volDiv = document.createElement('div');
                    volDiv.className = 'modal-vol-item ' + (v.is_collected ? 'is-collected' : 'is-missing');
                    volDiv.innerHTML = `
                        <strong>Vol. ${v.volume}</strong>
                        <div class="modal-vol-name">${v.volume_name ? v.volume_name : (v.is_collected ? 'Owned' : 'Missing')}</div>
                    `;
                    modalVolGrid.appendChild(volDiv);
                });
            } else {
                modalVolGrid.innerHTML = '<div style="grid-column: 1/-1; color: var(--text-muted); font-size: 0.8rem; text-align: center; padding: 16px;">No volumes logged yet</div>';
            }

            if (missingVols.length > 0) {
                modalGapSummary.textContent = 'Missing: Vol. ' + missingVols.join(', ');
            } else if (data.totalVols > 0) {
                modalGapSummary.textContent = 'All ' + data.totalVols + ' volumes collected!';
            } else {
                modalGapSummary.textContent = 'No volumes registered yet.';
            }

            modalAdminEditLink.href = `/admin/comics/${data.id}/edit`;

            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeInspectorModal() {
            const modal = document.getElementById('inspectorModal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        function handleModalBackdropClick(event) {
            if (event.target.id === 'inspectorModal') {
                closeInspectorModal();
            }
        }

        // ==========================================
        // Ambient YouTube Audio Deck Controller
        // ==========================================
        let currentVideoId = 'jfKfPfyJRdk';
        let ytPlayer = null;
        let isYtReady = false;
        let isBgmPlaying = false;
        let isBgmMuted = false;
        let bgmVolume = 80;
        let bgmProgressTimer = null;
        let isVideoDrawerOpen = true;

        // Elements
        const bgmWidget = document.getElementById('bgmPlayerWidget');
        const bgmPillView = document.getElementById('bgmPillView');
        const bgmPillPlayBtn = document.getElementById('bgmPillPlayBtn');
        const bgmPillStatusText = document.getElementById('bgmPillStatusText');
        const bgmMainPlayBtn = document.getElementById('bgmMainPlayBtn');
        const bgmMinimizeBtn = document.getElementById('bgmMinimizeBtn');
        const bgmVideoToggleBtn = document.getElementById('bgmVideoToggleBtn');
        const bgmVideoDrawer = document.getElementById('bgmVideoDrawer');
        const bgmRestartBtn = document.getElementById('bgmRestartBtn');
        const bgmForwardBtn = document.getElementById('bgmForwardBtn');
        const bgmMuteBtn = document.getElementById('bgmMuteBtn');
        const bgmVolumeSlider = document.getElementById('bgmVolumeSlider');
        const bgmProgressContainer = document.getElementById('bgmProgressContainer');
        const bgmProgressFill = document.getElementById('bgmProgressFill');
        const bgmCurrentTimeEl = document.getElementById('bgmCurrentTime');
        const bgmTotalDurationEl = document.getElementById('bgmTotalDuration');
        const bgmTrackTitleEl = document.getElementById('bgmTrackTitle');
        const bgmEmbedWarning = document.getElementById('bgmEmbedWarning');
        const bgmAutoSwitchBtn = document.getElementById('bgmAutoSwitchBtn');
        const bgmOpenYtDirectLink = document.getElementById('bgmOpenYtDirectLink');
        const stationChips = document.querySelectorAll('.bgm-station-chip');
        const navBgmBtn = document.getElementById('navBgmBtn');
        const navBgmState = document.getElementById('navBgmState');
        const pillPlayIcon = document.getElementById('pillPlayIcon');
        const pillPauseIcon = document.getElementById('pillPauseIcon');
        const mainPlayIcon = document.getElementById('mainPlayIcon');
        const mainPauseIcon = document.getElementById('mainPauseIcon');
        const volHighIcon = document.getElementById('volHighIcon');
        const volMuteIcon = document.getElementById('volMuteIcon');

        // Load saved preferences & initial viewport state
        try {
            const savedStation = localStorage.getItem('comicgarage_bgm_station');
            if (savedStation) {
                currentVideoId = savedStation;
            }
            const savedCollapsed = localStorage.getItem('comicgarage_bgm_collapsed');
            if (savedCollapsed === 'true' || (savedCollapsed === null && window.innerWidth <= 768)) {
                if (bgmWidget) bgmWidget.classList.add('is-collapsed');
            }
            const savedVol = localStorage.getItem('comicgarage_bgm_vol');
            if (savedVol !== null) {
                bgmVolume = parseInt(savedVol, 10);
                if (bgmVolumeSlider) bgmVolumeSlider.value = bgmVolume;
                if (bgmVolume === 0) {
                    isBgmMuted = true;
                    if (volHighIcon) volHighIcon.style.display = 'none';
                    if (volMuteIcon) volMuteIcon.style.display = 'block';
                }
            }
        } catch (e) {}

        // Format seconds to mm:ss or hh:mm:ss
        function formatBgmTime(sec) {
            if (isNaN(sec) || sec < 0) return '00:00';
            const totalSec = Math.floor(sec);
            const h = Math.floor(totalSec / 3600);
            const m = Math.floor((totalSec % 3600) / 60);
            const s = totalSec % 60;
            const formattedSeconds = s < 10 ? '0' + s : s;
            if (h > 0) {
                const formattedMinutes = m < 10 ? '0' + m : m;
                return h + ':' + formattedMinutes + ':' + formattedSeconds;
            }
            return (m < 10 ? '0' + m : m) + ':' + formattedSeconds;
        }

        // Direct PostMessage Helper to YouTube Iframe
        function sendPostMessageToYt(func, args) {
            const iframe = document.getElementById('ambient-yt-player');
            if (iframe && iframe.contentWindow) {
                try {
                    iframe.contentWindow.postMessage(JSON.stringify({
                        event: 'command',
                        func: func,
                        args: args || []
                    }), '*');
                } catch (e) {
                    console.warn('PostMessage error to YouTube iframe:', e);
                }
            }
        }

        // Update UI state
        function setPlayingUIState(playing) {
            isBgmPlaying = playing;
            if (playing) {
                if (bgmWidget) bgmWidget.classList.add('is-playing');
                if (navBgmBtn) navBgmBtn.classList.add('is-active');
                if (navBgmState) navBgmState.textContent = 'ON';
                if (bgmPillStatusText) bgmPillStatusText.textContent = 'Playing';
                if (pillPlayIcon) pillPlayIcon.style.display = 'none';
                if (pillPauseIcon) pillPauseIcon.style.display = 'block';
                if (mainPlayIcon) mainPlayIcon.style.display = 'none';
                if (mainPauseIcon) mainPauseIcon.style.display = 'block';

                startProgressTracker();
            } else {
                if (bgmWidget) bgmWidget.classList.remove('is-playing');
                if (navBgmBtn) navBgmBtn.classList.remove('is-active');
                if (navBgmState) navBgmState.textContent = 'OFF';
                if (bgmPillStatusText) bgmPillStatusText.textContent = 'Paused';
                if (pillPlayIcon) pillPlayIcon.style.display = 'block';
                if (pillPauseIcon) pillPauseIcon.style.display = 'none';
                if (mainPlayIcon) mainPlayIcon.style.display = 'block';
                if (mainPauseIcon) mainPauseIcon.style.display = 'none';

                stopProgressTracker();
            }
        }

        function updateProgressUI(cur, dur) {
            if (dur > 0) {
                const pct = Math.min(100, Math.max(0, (cur / dur) * 100));
                if (bgmProgressFill) bgmProgressFill.style.width = pct + '%';
                if (bgmCurrentTimeEl) bgmCurrentTimeEl.textContent = formatBgmTime(cur);
                if (bgmTotalDurationEl) bgmTotalDurationEl.textContent = formatBgmTime(dur);
            }
        }

        function startProgressTracker() {
            stopProgressTracker();
            bgmProgressTimer = setInterval(function() {
                if (ytPlayer && typeof ytPlayer.getCurrentTime === 'function' && typeof ytPlayer.getDuration === 'function') {
                    try {
                        const cur = ytPlayer.getCurrentTime();
                        const dur = ytPlayer.getDuration();
                        updateProgressUI(cur, dur);
                    } catch (e) {}
                }
            }, 500);
        }

        function stopProgressTracker() {
            if (bgmProgressTimer) {
                clearInterval(bgmProgressTimer);
                bgmProgressTimer = null;
            }
        }

        // Switch Active Station / Video Stream
        function switchStation(videoId, title, startPlay) {
            currentVideoId = videoId;
            if (bgmEmbedWarning) bgmEmbedWarning.classList.remove('is-visible');

            // Update Active Chip
            stationChips.forEach(chip => {
                if (chip.getAttribute('data-video-id') === videoId) {
                    chip.classList.add('is-active');
                } else {
                    chip.classList.remove('is-active');
                }
            });

            if (title && bgmTrackTitleEl) {
                bgmTrackTitleEl.textContent = title;
            }

            if (bgmOpenYtDirectLink) {
                bgmOpenYtDirectLink.href = `https://www.youtube.com/watch?v=${videoId}`;
            }

            try {
                localStorage.setItem('comicgarage_bgm_station', videoId);
            } catch (e) {}

            const iframe = document.getElementById('ambient-yt-player');

            if (ytPlayer && typeof ytPlayer.loadVideoById === 'function') {
                try {
                    if (startPlay) {
                        ytPlayer.loadVideoById(videoId);
                        setPlayingUIState(true);
                    } else {
                        ytPlayer.cueVideoById(videoId);
                    }
                } catch (e) {
                    if (iframe) {
                        iframe.src = `https://www.youtube.com/embed/${videoId}?enablejsapi=1&playsinline=1&rel=0&controls=1&modestbranding=1${startPlay ? '&autoplay=1' : ''}`;
                    }
                    if (startPlay) setPlayingUIState(true);
                }
            } else if (iframe) {
                iframe.src = `https://www.youtube.com/embed/${videoId}?enablejsapi=1&playsinline=1&rel=0&controls=1&modestbranding=1${startPlay ? '&autoplay=1' : ''}`;
                if (startPlay) setPlayingUIState(true);
            }
        }

        // Toggle playback with Dual-Layer Fallback
        function toggleBgmPlay() {
            if (isBgmPlaying) {
                // Pause
                if (ytPlayer && typeof ytPlayer.pauseVideo === 'function') {
                    try { ytPlayer.pauseVideo(); } catch (e) { sendPostMessageToYt('pauseVideo'); }
                } else {
                    sendPostMessageToYt('pauseVideo');
                }
                setPlayingUIState(false);
            } else {
                // Play
                if (bgmPillStatusText) bgmPillStatusText.textContent = 'Playing...';
                if (navBgmState) navBgmState.textContent = '...';

                if (ytPlayer && typeof ytPlayer.playVideo === 'function') {
                    try {
                        if (isBgmMuted && typeof ytPlayer.unMute === 'function') {
                            ytPlayer.unMute();
                            isBgmMuted = false;
                        }
                        if (typeof ytPlayer.setVolume === 'function') {
                            ytPlayer.setVolume(bgmVolume || 80);
                        }
                        ytPlayer.playVideo();
                    } catch (e) {
                        sendPostMessageToYt('unMute');
                        sendPostMessageToYt('setVolume', [bgmVolume || 80]);
                        sendPostMessageToYt('playVideo');
                    }
                } else {
                    sendPostMessageToYt('unMute');
                    sendPostMessageToYt('setVolume', [bgmVolume || 80]);
                    sendPostMessageToYt('playVideo');
                }
                setPlayingUIState(true);
            }
        }

        // Initialize YT Player Instance
        function initYouTubePlayer() {
            if (ytPlayer || !window.YT || !window.YT.Player) return;

            try {
                ytPlayer = new YT.Player('ambient-yt-player', {
                    events: {
                        'onReady': function(event) {
                            isYtReady = true;
                            try {
                                event.target.setVolume(bgmVolume);
                                if (isBgmMuted) {
                                    event.target.mute();
                                }
                                const data = event.target.getVideoData();
                                if (data && data.title && bgmTrackTitleEl) {
                                    bgmTrackTitleEl.textContent = data.title;
                                }
                            } catch (e) {}
                        },
                        'onStateChange': function(event) {
                            if (event.data === 1) { // PLAYING
                                setPlayingUIState(true);
                                if (bgmEmbedWarning) bgmEmbedWarning.classList.remove('is-visible');
                                try {
                                    const data = event.target.getVideoData();
                                    if (data && data.title && bgmTrackTitleEl) {
                                        bgmTrackTitleEl.textContent = data.title;
                                    }
                                } catch (e) {}
                            } else if (event.data === 2) { // PAUSED
                                setPlayingUIState(false);
                            } else if (event.data === 0) { // ENDED (Loop track)
                                try {
                                    event.target.seekTo(0);
                                    event.target.playVideo();
                                } catch (e) {
                                    sendPostMessageToYt('seekTo', [0, true]);
                                    sendPostMessageToYt('playVideo');
                                }
                            } else if (event.data === 3) { // BUFFERING
                                if (bgmPillStatusText) bgmPillStatusText.textContent = 'Buffering...';
                            }
                        },
                        'onError': function(err) {
                            console.warn('YouTube Player error code:', err.data || err);
                            // Error 101 or 150 = The video cannot be played in embedded players due to copyright/owner restrictions
                            if (err.data === 150 || err.data === 101 || err.data === 100 || err.data === 2) {
                                if (bgmEmbedWarning) bgmEmbedWarning.classList.add('is-visible');
                                if (bgmPillStatusText) bgmPillStatusText.textContent = 'Embed Blocked';
                            } else {
                                if (bgmPillStatusText) bgmPillStatusText.textContent = 'Tap to Play';
                            }
                        }
                    }
                });
            } catch (initErr) {
                console.warn('YT.Player wrapper fallback active:', initErr);
            }
        }

        // Listen to raw PostMessage notifications from YouTube iframe
        window.addEventListener('message', function(event) {
            if (event.origin && !event.origin.includes('youtube')) return;
            try {
                let data = event.data;
                if (typeof data === 'string') {
                    data = JSON.parse(data);
                }
                if (data && data.event === 'onStateChange') {
                    if (data.info === 1) {
                        setPlayingUIState(true);
                        if (bgmEmbedWarning) bgmEmbedWarning.classList.remove('is-visible');
                    } else if (data.info === 2) {
                        setPlayingUIState(false);
                    }
                } else if (data && data.event === 'infoDelivery' && data.info) {
                    if (typeof data.info.playerState !== 'undefined') {
                        if (data.info.playerState === 1) {
                            setPlayingUIState(true);
                            if (bgmEmbedWarning) bgmEmbedWarning.classList.remove('is-visible');
                        } else if (data.info.playerState === 2) {
                            setPlayingUIState(false);
                        }
                    }
                    if (typeof data.info.currentTime !== 'undefined' && typeof data.info.duration !== 'undefined') {
                        updateProgressUI(data.info.currentTime, data.info.duration);
                    }
                    if (data.info.videoData && data.info.videoData.title && bgmTrackTitleEl) {
                        bgmTrackTitleEl.textContent = data.info.videoData.title;
                    }
                }
            } catch (err) {}
        });

        // Set global YouTube API callback before loading script
        window.onYouTubeIframeAPIReady = function() {
            initYouTubePlayer();
        };

        // Load YouTube IFrame API Script asynchronously with Polling
        (function loadYouTubeApiScript() {
            if (window.YT && window.YT.Player) {
                initYouTubePlayer();
                return;
            }
            if (!document.querySelector('script[src*="youtube.com/iframe_api"]')) {
                const tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                tag.async = true;
                const firstScriptTag = document.getElementsByTagName('script')[0];
                if (firstScriptTag && firstScriptTag.parentNode) {
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                } else {
                    document.head.appendChild(tag);
                }
            }

            // Guaranteed Polling Interval (up to 15s)
            let attempts = 0;
            const checkInterval = setInterval(function() {
                attempts++;
                if (window.YT && window.YT.Player) {
                    initYouTubePlayer();
                    clearInterval(checkInterval);
                } else if (attempts > 75) {
                    clearInterval(checkInterval);
                }
            }, 200);
        })();

        // Station Chip Clicks
        stationChips.forEach(chip => {
            chip.addEventListener('click', function() {
                const videoId = this.getAttribute('data-video-id');
                const title = this.getAttribute('data-title');
                if (videoId) {
                    switchStation(videoId, title, true);
                }
            });
        });

        // Auto Switch Button (Fallback from restricted embed)
        if (bgmAutoSwitchBtn) {
            bgmAutoSwitchBtn.addEventListener('click', function() {
                switchStation('jfKfPfyJRdk', 'Lofi Girl • 24/7 Anime Lofi Beats', true);
            });
        }

        // Control button bindings
        if (bgmMainPlayBtn) {
            bgmMainPlayBtn.addEventListener('click', toggleBgmPlay);
        }

        if (bgmPillPlayBtn) {
            bgmPillPlayBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleBgmPlay();
            });
        }

        if (navBgmBtn) {
            navBgmBtn.addEventListener('click', function() {
                toggleBgmPlay();
            });
        }

        // Expand pill when clicked
        if (bgmPillView) {
            bgmPillView.addEventListener('click', function() {
                if (bgmWidget) {
                    bgmWidget.classList.remove('is-collapsed');
                    try { localStorage.setItem('comicgarage_bgm_collapsed', 'false'); } catch (e) {}
                }
            });
        }

        // Minimize deck to pill
        if (bgmMinimizeBtn) {
            bgmMinimizeBtn.addEventListener('click', function() {
                if (bgmWidget) {
                    bgmWidget.classList.add('is-collapsed');
                    try { localStorage.setItem('comicgarage_bgm_collapsed', 'true'); } catch (e) {}
                }
            });
        }

        // Video drawer toggle
        if (bgmVideoToggleBtn && bgmVideoDrawer) {
            bgmVideoToggleBtn.addEventListener('click', function() {
                isVideoDrawerOpen = !isVideoDrawerOpen;
                if (isVideoDrawerOpen) {
                    bgmVideoDrawer.classList.add('is-open');
                    bgmVideoToggleBtn.classList.add('is-active');
                } else {
                    bgmVideoDrawer.classList.remove('is-open');
                    bgmVideoToggleBtn.classList.remove('is-active');
                }
            });
        }

        // Restart track
        if (bgmRestartBtn) {
            bgmRestartBtn.addEventListener('click', function() {
                if (ytPlayer && typeof ytPlayer.seekTo === 'function') {
                    try {
                        ytPlayer.seekTo(0, true);
                        if (!isBgmPlaying && typeof ytPlayer.playVideo === 'function') {
                            ytPlayer.playVideo();
                            setPlayingUIState(true);
                        }
                    } catch (e) {
                        sendPostMessageToYt('seekTo', [0, true]);
                        sendPostMessageToYt('playVideo');
                        setPlayingUIState(true);
                    }
                } else {
                    sendPostMessageToYt('seekTo', [0, true]);
                    sendPostMessageToYt('playVideo');
                    setPlayingUIState(true);
                }
            });
        }

        // Forward 10s
        if (bgmForwardBtn) {
            bgmForwardBtn.addEventListener('click', function() {
                if (ytPlayer && typeof ytPlayer.getCurrentTime === 'function' && typeof ytPlayer.seekTo === 'function') {
                    try {
                        const cur = ytPlayer.getCurrentTime();
                        ytPlayer.seekTo(cur + 10, true);
                    } catch (e) {
                        sendPostMessageToYt('seekTo', [10, true]);
                    }
                } else {
                    sendPostMessageToYt('seekTo', [10, true]);
                }
            });
        }

        // Mute / Unmute
        if (bgmMuteBtn) {
            bgmMuteBtn.addEventListener('click', function() {
                isBgmMuted = !isBgmMuted;
                if (isBgmMuted) {
                    if (ytPlayer && typeof ytPlayer.mute === 'function') {
                        try { ytPlayer.mute(); } catch (e) { sendPostMessageToYt('mute'); }
                    } else {
                        sendPostMessageToYt('mute');
                    }
                    if (volHighIcon) volHighIcon.style.display = 'none';
                    if (volMuteIcon) volMuteIcon.style.display = 'block';
                } else {
                    if (ytPlayer && typeof ytPlayer.unMute === 'function') {
                        try { ytPlayer.unMute(); } catch (e) { sendPostMessageToYt('unMute'); }
                    } else {
                        sendPostMessageToYt('unMute');
                    }
                    if (volHighIcon) volHighIcon.style.display = 'block';
                    if (volMuteIcon) volMuteIcon.style.display = 'none';
                    if (bgmVolume === 0) {
                        bgmVolume = 50;
                        if (bgmVolumeSlider) bgmVolumeSlider.value = 50;
                        if (ytPlayer && typeof ytPlayer.setVolume === 'function') {
                            try { ytPlayer.setVolume(50); } catch (e) { sendPostMessageToYt('setVolume', [50]); }
                        } else {
                            sendPostMessageToYt('setVolume', [50]);
                        }
                        try { localStorage.setItem('comicgarage_bgm_vol', 50); } catch (err) {}
                    }
                }
            });
        }

        // Volume Slider
        if (bgmVolumeSlider) {
            bgmVolumeSlider.addEventListener('input', function(e) {
                bgmVolume = parseInt(e.target.value, 10);
                if (ytPlayer && typeof ytPlayer.setVolume === 'function') {
                    try { ytPlayer.setVolume(bgmVolume); } catch (err) { sendPostMessageToYt('setVolume', [bgmVolume]); }
                } else {
                    sendPostMessageToYt('setVolume', [bgmVolume]);
                }

                if (bgmVolume > 0 && isBgmMuted) {
                    isBgmMuted = false;
                    if (ytPlayer && typeof ytPlayer.unMute === 'function') {
                        try { ytPlayer.unMute(); } catch (err) { sendPostMessageToYt('unMute'); }
                    } else {
                        sendPostMessageToYt('unMute');
                    }
                    if (volHighIcon) volHighIcon.style.display = 'block';
                    if (volMuteIcon) volMuteIcon.style.display = 'none';
                } else if (bgmVolume === 0 && !isBgmMuted) {
                    isBgmMuted = true;
                    if (ytPlayer && typeof ytPlayer.mute === 'function') {
                        try { ytPlayer.mute(); } catch (err) { sendPostMessageToYt('mute'); }
                    } else {
                        sendPostMessageToYt('mute');
                    }
                    if (volHighIcon) volHighIcon.style.display = 'none';
                    if (volMuteIcon) volMuteIcon.style.display = 'block';
                }
                try { localStorage.setItem('comicgarage_bgm_vol', bgmVolume); } catch (err) {}
            });
        }

        // Seek Bar Click
        if (bgmProgressContainer) {
            bgmProgressContainer.addEventListener('click', function(e) {
                const rect = bgmProgressContainer.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const ratio = Math.max(0, Math.min(1, clickX / rect.width));

                if (ytPlayer && typeof ytPlayer.getDuration === 'function' && typeof ytPlayer.seekTo === 'function') {
                    try {
                        const dur = ytPlayer.getDuration();
                        if (dur > 0) {
                            ytPlayer.seekTo(dur * ratio, true);
                        }
                    } catch (err) {
                        sendPostMessageToYt('seekTo', [ratio * 100, true]);
                    }
                } else {
                    sendPostMessageToYt('seekTo', [ratio * 100, true]);
                }
            });
        }
    </script>
</body>
</html>
