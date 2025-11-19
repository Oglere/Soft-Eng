<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance</title>
    <style>
        /* ===== THEME MATCH ===== */
        body {
            background-color: #fffbea;
            color: #0b1b4a;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* ===== WRAPPER ===== */
        .maintenance-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        /* ===== CARD ===== */
        .maintenance-card {
            background: linear-gradient(135deg, #0b1b4a, #2c3e80);
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            padding: 50px 40px;
            max-width: 550px;
            width: 100%;
            text-align: center;
            color: #fff;
            animation: fadeIn 0.8s ease;
        }

        /* ===== ICON ===== */
        .maintenance-icon {
            font-size: 70px;
            background: rgba(255, 255, 255, 0.15);
            padding: 20px;
            border-radius: 18px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 25px;
        }

        /* ===== TEXT ===== */
        .maintenance-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #fffbea;
        }

        .maintenance-subtitle {
            font-size: 18px;
            font-weight: 400;
            line-height: 1.6;
            color: #fdf3c5;
            margin-bottom: 35px;
        }

        /* ===== BUTTON ===== */
        .refresh-btn {
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(46, 139, 87, 0.4);
        }

        .refresh-btn:hover {
            background: linear-gradient(135deg, #26734d, #339966);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(46, 139, 87, 0.6);
        }

        /* ===== FOOTER ===== */
        .footer-text {
            margin-top: 30px;
            font-size: 14px;
            color: #fff9dc;
            opacity: 0.9;
        }

        /* ===== ANIMATION ===== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 600px) {
            .maintenance-card {
                padding: 35px 25px;
            }

            .maintenance-title {
                font-size: 24px;
            }

            .maintenance-subtitle {
                font-size: 16px;
            }

            .maintenance-icon {
                font-size: 50px;
                padding: 15px;
            }

            .refresh-btn {
                padding: 10px 22px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-wrapper">
        <div class="maintenance-card">
            <div class="maintenance-icon">⚙️</div>
            <h1 class="maintenance-title">We’ll Be Right Back!</h1>
            <p class="maintenance-subtitle">
                Our system is currently under maintenance to improve performance and reliability.<br>
                Thank you for your patience.
            </p>
            <div class="footer-text">© {{ date('Y') }} DARA - Digital Academic Repository and Archive — All Rights Reserved</div>
        </div>
    </div>
</body>
</html>
