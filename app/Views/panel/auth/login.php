<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | <?= !empty($setting['nama_web']) ? $setting['nama_web'] : 'AdminPanel' ?></title>

    <?php if (!empty($setting['logo'])): ?>
        <link rel="icon" href="<?= base_url('uploads/setting/' . $setting['logo']); ?>">
    <?php endif; ?>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 flex items-center justify-center h-screen">

    <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl py-10 px-6 border border-gray-100">

        <div class="text-center mb-8">
            <?php if (!empty($setting['logo'])): ?>
                <img src="<?= base_url('uploads/setting/' . $setting['logo']); ?>" alt="Logo Website" class="mx-auto h-20 mb-5 object-contain">
            <?php else: ?>
                <div class="mx-auto h-16 w-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mb-5">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                    </svg>
                </div>
            <?php endif; ?>

            <h1 class="text-2xl font-bold text-gray-800 tracking-tight"><?= !empty($setting['nama_web']) ? $setting['nama_web'] : 'AdminPanel' ?></h1>
            <p class="text-sm text-gray-500 mt-2">Masuk untuk mengelola sistem</p>
        </div>

        <?php if ($isBlocked): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-md flex items-start shadow-sm">
                <svg class="h-5 w-5 mr-3 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-sm font-medium leading-tight">Terlalu banyak percobaan! Keamanan aktif. Silakan tunggu 1 menit.</span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-lg text-sm mb-6 text-center shadow-sm font-medium">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('panel/auth/process') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5" for="login_id">Username / Email</label>
                <input type="text" name="login_id" id="login_id" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all <?= $isBlocked ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' ?>"
                    placeholder="Masukkan username atau email"
                    <?= $isBlocked ? 'disabled' : '' ?>>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-1.5">
                    <label class="block text-sm font-semibold text-gray-700" for="password">Password</label>
                </div>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all <?= $isBlocked ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' ?>"
                        placeholder="••••••••"
                        <?= $isBlocked ? 'disabled' : '' ?>>

                    <?php if (!$isBlocked): ?>
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-600 focus:outline-none transition-colors">
                            <svg id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeSlashIcon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit"
                class="w-full font-bold py-3 rounded-lg transition-all duration-200 ease-in-out shadow-md <?= $isBlocked ? 'bg-gray-400 text-white cursor-not-allowed' : 'bg-indigo-600 text-white hover:bg-indigo-700 hover:shadow-lg transform hover:-translate-y-0.5' ?>"
                <?= $isBlocked ? 'disabled' : '' ?>>
                <?= $isBlocked ? 'Terkunci Sementara' : 'Masuk ke Panel' ?>
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeIcon.classList.toggle('hidden');
                    eyeSlashIcon.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>

</html>