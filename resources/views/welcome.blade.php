{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Comic Collection</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background elements */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .floating-shapes {
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape-2 {
            top: 70%;
            right: 10%;
            animation-delay: 2s;
            width: 150px;
            height: 150px;
        }

        .shape-3 {
            top: 30%;
            right: 30%;
            animation-delay: 4s;
            width: 100px;
            height: 100px;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        /* Main container */
        .container {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 40px;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 60px 50px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            max-width: 480px;
            margin: 0 auto;
            transform: translateY(30px);
            opacity: 0;
            animation: slideIn 1s ease-out forwards;
        }

        @keyframes slideIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            border-radius: 20px;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            font-weight: bold;
            box-shadow: 0 15px 35px rgba(255, 107, 107, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 15px 35px rgba(255, 107, 107, 0.3);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 20px 40px rgba(255, 107, 107, 0.4);
            }
        }

        h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            margin-bottom: 40px;
            font-weight: 300;
            line-height: 1.6;
        }

        .login-btn {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .features {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
            gap: 20px;
        }

        .feature {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .feature-icon {
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .welcome-card {
                padding: 40px 30px;
                margin: 20px;
            }

            h1 {
                font-size: 2rem;
            }

            .features {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation">
        <div class="floating-shapes shape-1"></div>
        <div class="floating-shapes shape-2"></div>
        <div class="floating-shapes shape-3"></div>
    </div>

    <div class="container">
        <div class="welcome-card">
            <div class="logo">📚</div>
            <h1>My Comic Collection</h1>
            <p class="subtitle">
                Selamat datang di perpustakaan komik pribadi saya.<br>
                Tempat menyimpan dan mengorganisir koleksi komik favorit.
            </p>

            <a href="/admin" class="login-btn">
                Masuk ke Dashboard
            </a>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">📖</div>
                    <span>Koleksi Lengkap</span>
                </div>
                <div class="feature">
                    <div class="feature-icon">🔒</div>
                    <span>Akses Aman</span>
                </div>
                <div class="feature">
                    <div class="feature-icon">💾</div>
                    <span>Penyimpanan Rapi</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html> --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Comic Collection</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: #000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Manga panels background using uploaded image */
        .manga-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset("storage/manga wallpaper.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

        }


        /* Floating manga elements */
        .manga-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .speech-bubble {
            position: absolute;
            width: 120px;
            height: 80px;
            background: white;
            border: 3px solid #000;
            border-radius: 20px;
            opacity: 0.3;
            animation: floatBubble 8s ease-in-out infinite;
        }

        .speech-bubble::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 30px;
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-top: 15px solid white;
        }

        .speech-bubble::before {
            content: '';
            position: absolute;
            bottom: -18px;
            left: 28px;
            width: 0;
            height: 0;
            border-left: 17px solid transparent;
            border-right: 17px solid transparent;
            border-top: 17px solid #000;
        }

        .bubble-1 {
            top: 15%;
            left: 5%;
            animation-delay: 0s;
        }

        .bubble-2 {
            top: 60%;
            right: 8%;
            animation-delay: 3s;
            width: 100px;
            height: 60px;
        }

        .bubble-3 {
            top: 30%;
            right: 25%;
            animation-delay: 6s;
            width: 80px;
            height: 50px;
        }

        @keyframes floatBubble {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.2;
            }
            50% {
                transform: translateY(-15px) rotate(2deg);
                opacity: 0.4;
            }
        }

        /* Speed lines effect */
        .speed-lines {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at center, transparent 40%, rgba(0,0,0,0.1) 70%);
            z-index: 1;
        }

        /* Main container */
        .container {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 40px;
        }

        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            border: 4px solid #000;
            border-radius: 20px;
            padding: 60px 50px;
            box-shadow:
                8px 8px 0px #000,
                0 0 30px rgba(0, 0, 0, 0.3);
            max-width: 480px;
            margin: 0 auto;
            transform: translateY(30px);
            opacity: 0;
            animation: slideIn 1s ease-out forwards;
            position: relative;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
            border-radius: 22px;
            z-index: -1;
            animation: borderGlow 3s ease-in-out infinite;
        }

        @keyframes borderGlow {
            0%, 100% {
                opacity: 0.8;
                filter: blur(2px);
            }
            50% {
                opacity: 1;
                filter: blur(4px);
            }
        }

        @keyframes slideIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .logo {
            width: 100px;
            height: 100px;
            background: #000;
            border: 4px solid #fff;
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: white;
            font-weight: bold;
            box-shadow: 4px 4px 0px #666;
            animation: bounce 2s ease-in-out infinite;
            position: relative;
        }

        .logo::after {
            content: '💥';
            position: absolute;
            top: -15px;
            right: -15px;
            font-size: 24px;
            animation: rotate 3s linear infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: scale(1) rotate(0deg);
            }
            50% {
                transform: scale(1.1) rotate(5deg);
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        h1 {
            color: #000;
            font-size: 2.8rem;
            font-weight: 900;
            margin-bottom: 15px;
            text-shadow: 4px 4px 0px #ddd;
            font-family: 'Impact', sans-serif;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .subtitle {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 40px;
            font-weight: 500;
            line-height: 1.6;
            border: 2px dashed #666;
            padding: 15px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.7);
        }

        .login-btn {
            display: inline-block;
            padding: 18px 45px;
            background: #000;
            color: white;
            text-decoration: none;
            border-radius: 0;
            font-weight: 900;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 4px 4px 0px #666;
            border: 4px solid #000;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-btn::before {
            content: 'CLICK!';
            position: absolute;
            top: -30px;
            right: -10px;
            background: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 10px;
            border: 2px solid #000;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .login-btn:hover::before {
            opacity: 1;
            top: -25px;
        }

        .login-btn:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px #666;
            background: #333;
        }

        .login-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px #666;
        }

        .features {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
            gap: 20px;
        }

        .feature {
            color: #000;
            font-size: 0.9rem;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 15px;
            border: 3px solid #000;
            border-radius: 15px;
            background: white;
            box-shadow: 3px 3px 0px #666;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: #000;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: bold;
        }

        /* Comic sound effects */
        .sound-effects {
            position: absolute;
            font-family: 'Impact', sans-serif;
            font-weight: 900;
            color: #ff6b6b;
            text-shadow: 2px 2px 0px #000;
            z-index: 5;
        }

        .pow {
            top: 10%;
            left: 10%;
            font-size: 2rem;
            animation: soundPulse 3s ease-in-out infinite;
            animation-delay: 1s;
        }

        .boom {
            bottom: 20%;
            right: 15%;
            font-size: 1.5rem;
            animation: soundPulse 3s ease-in-out infinite;
            animation-delay: 2s;
        }

        @keyframes soundPulse {
            0%, 100% {
                opacity: 0;
                transform: scale(0.8);
            }
            50% {
                opacity: 0.7;
                transform: scale(1.2);
            }
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .welcome-card {
                padding: 40px 30px;
                margin: 20px;
            }

            h1 {
                font-size: 2.2rem;
            }

            .features {
                flex-direction: column;
                gap: 15px;
            }

            .sound-effects {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="manga-background"></div>

    <div class="manga-elements">
        <div class="speech-bubble bubble-1"></div>
        <div class="speech-bubble bubble-2"></div>
        <div class="speech-bubble bubble-3"></div>
    </div>

    <div class="speed-lines"></div>

    <div class="sound-effects pow">POW!</div>
    <div class="sound-effects boom">ZOOM!</div>

    <div class="container">
        <div class="welcome-card">
            <div class="logo">📚</div>
            <h1>Comic Archive</h1>
            <p class="subtitle">
                🎌 Koleksi Manga & Komik Terlengkap 🎌<br>
                Masuk ke dunia petualangan tak terbatas!
            </p>

            <a href="/admin" class="login-btn">
                Enter Dashboard
            </a>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">📖</div>
                    <span>MANGA<br>LIBRARY</span>
                </div>
                <div class="feature">
                    <div class="feature-icon">🔐</div>
                    <span>SECURE<br>ACCESS</span>
                </div>
                <div class="feature">
                    <div class="feature-icon">⚡</div>
                    <span>FAST<br>LOADING</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
