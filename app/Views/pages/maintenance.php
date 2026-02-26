<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situs Sedang Dalam Perbaikan | <?= $setting['nama_web'] ?? 'Sistem'; ?></title>
    <?php if (!empty($setting['logo'])): ?>
        <link rel="icon" href="<?= base_url('uploads/setting/' . $setting['logo']); ?>" type="image/png">
    <?php else: ?>
        <link rel="icon" href="<?= base_url('favicon.ico'); ?>" type="image/x-icon">
    <?php endif; ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --bg-color: #0f172a;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #38bdf8;
            --accent-hover: #0ea5e9;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        .bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.15) 0%, rgba(15, 23, 42, 0) 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            animation: pulse 6s infinite alternate ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(0.8);
                opacity: 0.5;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 1;
            }
        }

        .container {
            max-width: 600px;
            padding: 40px 20px;
            z-index: 1;
            animation: fadeIn 1.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: -0.02em;
        }

        p {
            font-size: 1.1rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
        }

        .time-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 20px;
            min-width: 80px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .time-box:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
        }

        .time-box span {
            display: block;
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--accent);
        }

        .time-box small {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
            display: block;
        }

        .notify-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 450px;
            margin: 0 auto;
        }

        .notify-form input {
            padding: 16px 20px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            color: white;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .notify-form input:focus {
            border-color: var(--accent);
        }

        .notify-form button {
            padding: 16px 24px;
            border-radius: 8px;
            border: none;
            background: var(--accent);
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.1s ease;
        }

        .notify-form button:hover {
            background: var(--accent-hover);
        }

        .notify-form button:active {
            transform: scale(0.98);
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .social-links a {
            color: var(--text-muted);
            font-size: 1.5rem;
            text-decoration: none;
            transition: color 0.3s ease, transform 0.3s ease;
            display: inline-block;
        }

        .social-links a:hover {
            color: var(--accent);
            transform: translateY(-4px);
        }

        @media (min-width: 480px) {
            .notify-form {
                flex-direction: row;
            }

            .notify-form input {
                flex: 1;
            }

            .notify-form button {
                width: auto;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 2rem;
            }

            .time-box {
                min-width: 65px;
                padding: 15px 10px;
            }

            .time-box span {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="bg-glow"></div>

    <div class="container">

        <div style="margin-bottom: 30px; animation: fadeIn 1s ease-out;">
            <?php if (!empty($setting['logo'])): ?>
                <img src="<?= base_url('uploads/setting/' . $setting['logo']); ?>" alt="Logo <?= $setting['nama_web'] ?? 'Website'; ?>" style="height: 80px; width: auto; object-fit: contain; margin-bottom: 15px;">
            <?php endif; ?>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--accent); margin: 0; letter-spacing: 0.5px;">
                <?= $setting['nama_web'] ?? 'SMK Kreatif Nusantara'; ?>
            </h2>
        </div>

        <h1>Kami Sedang Melakukan Peningkatan</h1>
        <p>Situs web ini sedang dalam proses pemeliharaan untuk memberikan pengalaman yang lebih baik. Kami akan segera kembali!</p>

        <div class="countdown" id="countdown">
            <div class="time-box">
                <span id="days">00</span>
                <small>Hari</small>
            </div>
            <div class="time-box">
                <span id="hours">00</span>
                <small>Jam</small>
            </div>
            <div class="time-box">
                <span id="minutes">00</span>
                <small>Menit</small>
            </div>
            <div class="time-box">
                <span id="seconds">00</span>
                <small>Detik</small>
            </div>
        </div>

        <div class="social-links">
            <?php if (!empty($setting['facebook'])): ?><a href="<?= $setting['facebook']; ?>" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
            <?php if (!empty($setting['instagram'])): ?><a href="<?= $setting['instagram']; ?>" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a><?php endif; ?>
            <?php if (!empty($setting['tiktok'])): ?><a href="<?= $setting['tiktok']; ?>" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a><?php endif; ?>
            <?php if (!empty($setting['youtube'])): ?><a href="<?= $setting['youtube']; ?>" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a><?php endif; ?>
            <?php if (!empty($setting['twitter'])): ?><a href="<?= $setting['twitter']; ?>" target="_blank" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a><?php endif; ?>
        </div>
    </div>

    <script>
        const countDownDate = new Date().getTime() + (3 * 24 * 60 * 60 * 1000); // 3 Hari

        const x = setInterval(function() {
            const now = new Date().getTime();
            const distance = countDownDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = days.toString().padStart(2, '0');
            document.getElementById("hours").innerText = hours.toString().padStart(2, '0');
            document.getElementById("minutes").innerText = minutes.toString().padStart(2, '0');
            document.getElementById("seconds").innerText = seconds.toString().padStart(2, '0');

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "<h2 style='color: var(--accent)'>Situs Sudah Siap!</h2>";
            }
        }, 1000);
    </script>
</body>

</html>