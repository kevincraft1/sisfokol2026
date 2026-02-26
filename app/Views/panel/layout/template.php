<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Admin Dashboard'; ?> | AdminPanel</title>

    <?php
    $settingModel = new \App\Models\SettingModel();
    $settingData = $settingModel->first();
    ?>
    <?php if (!empty($settingData['logo'])): ?>
        <link rel="icon" href="<?= base_url('uploads/setting/' . $settingData['logo']); ?>" type="image/png">
    <?php else: ?>
        <link rel="icon" href="<?= base_url('favicon.ico'); ?>" type="image/x-icon">
    <?php endif; ?>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #4b5563;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800" x-data="{ sidebarOpen: true }">

    <?php $userRole = strtolower(session()->get('role') ?? ''); ?>

    <div class="flex h-screen overflow-hidden">

        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-slate-900 text-gray-300 flex flex-col transition-all duration-300 z-20 shadow-xl">
            <div class="h-16 flex items-center justify-center bg-slate-950 px-4 shrink-0">
                <i class="fa-solid fa-layer-group text-indigo-500 text-2xl"></i>
                <span x-show="sidebarOpen" class="ml-3 text-white font-bold text-lg tracking-wide transition-opacity duration-300">AdminPanel</span>
            </div>

            <nav class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3 space-y-2">

                <div>
                    <a href="<?= base_url('panel'); ?>" class="flex items-center px-3 py-2.5 <?= (current_url() == base_url('panel') || current_url() == base_url('panel/dashboard')) ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white'; ?> rounded-lg group transition-colors">
                        <i class="fa-solid fa-chart-pie w-6 text-center <?= (current_url() == base_url('panel') || current_url() == base_url('panel/dashboard')) ? 'text-white' : 'group-hover:text-indigo-400'; ?>"></i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Dashboard</span>
                    </a>
                </div>

                <?php if ($userRole === 'admin' || $userRole === 'guru'): ?>
                    <div x-data="{ open: <?= (strpos(current_url(), 'berita') !== false || strpos(current_url(), 'galeri') !== false) ? 'true' : 'false'; ?> }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition-colors group <?= (strpos(current_url(), 'berita') !== false || strpos(current_url(), 'galeri') !== false) ? 'text-white' : ''; ?>">
                            <div class="flex items-center">
                                <i class="fa-solid fa-newspaper w-6 text-center <?= (strpos(current_url(), 'berita') !== false || strpos(current_url(), 'galeri') !== false) ? 'text-indigo-400' : 'group-hover:text-indigo-400'; ?> transition-colors"></i>
                                <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Update Konten</span>
                            </div>
                            <i x-show="sidebarOpen" class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open && sidebarOpen" x-collapse class="pl-10 pr-3 py-1 space-y-1">
                            <a href="<?= base_url('panel/berita'); ?>" class="block py-2 text-sm <?= strpos(current_url(), 'berita') !== false ? 'text-indigo-400 font-medium' : 'text-gray-400 hover:text-white'; ?> transition-colors">Artikel & Berita</a>
                            <a href="<?= base_url('panel/galeri'); ?>" class="block py-2 text-sm <?= strpos(current_url(), 'galeri') !== false ? 'text-indigo-400 font-medium' : 'text-gray-400 hover:text-white'; ?> transition-colors">Foto Kegiatan (Galeri)</a>
                        </div>
                    </div>

                    <div x-data="{ open: <?= (strpos(current_url(), 'profil') !== false || strpos(current_url(), 'jurusan') !== false || strpos(current_url(), 'hero') !== false || strpos(current_url(), 'mitra') !== false) ? 'true' : 'false'; ?> }">
                        <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition-colors group <?= (strpos(current_url(), 'profil') !== false || strpos(current_url(), 'jurusan') !== false || strpos(current_url(), 'hero') !== false || strpos(current_url(), 'mitra') !== false) ? 'text-white' : ''; ?>">
                            <div class="flex items-center">
                                <i class="fa-solid fa-graduation-cap w-6 text-center <?= (strpos(current_url(), 'profil') !== false || strpos(current_url(), 'jurusan') !== false || strpos(current_url(), 'hero') !== false || strpos(current_url(), 'mitra') !== false) ? 'text-indigo-400' : 'group-hover:text-indigo-400'; ?> transition-colors"></i>
                                <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Data Sekolah</span>
                            </div>
                            <i x-show="sidebarOpen" class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="open && sidebarOpen" x-collapse class="pl-10 pr-3 py-1 space-y-1">
                            <a href="<?= base_url('panel/profil'); ?>" class="block py-2 text-sm <?= strpos(current_url(), 'profil') !== false ? 'text-indigo-400 font-medium' : 'text-gray-400 hover:text-white'; ?> transition-colors">Profil & Visi Misi</a>

                            <?php if ($userRole === 'admin'): ?>
                                <a href="<?= base_url('panel/jurusan'); ?>" class="block py-2 text-sm <?= strpos(current_url(), 'jurusan') !== false ? 'text-indigo-400 font-medium' : 'text-gray-400 hover:text-white'; ?> transition-colors">Program Keahlian</a>
                                <a href="<?= base_url('panel/hero'); ?>" class="block py-2 text-sm <?= strpos(current_url(), 'hero') !== false ? 'text-indigo-400 font-medium' : 'text-gray-400 hover:text-white'; ?> transition-colors">Hero Section Utama</a>
                                <a href="<?= base_url('panel/mitra'); ?>" class="block py-2 text-sm <?= strpos(current_url(), 'mitra') !== false ? 'text-indigo-400 font-medium' : 'text-gray-400 hover:text-white'; ?> transition-colors">Logo Mitra Industri</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div>
                    <a href="<?= base_url('panel/pesan'); ?>" class="flex items-center px-3 py-2.5 <?= strpos(current_url(), 'pesan') !== false ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white'; ?> rounded-lg transition-colors group">
                        <i class="fa-solid fa-envelope-open-text w-6 text-center <?= strpos(current_url(), 'pesan') !== false ? 'text-white' : 'group-hover:text-indigo-400'; ?> transition-colors relative">
                            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-slate-900"></span>
                            </span>
                        </i>
                        <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Inbox Pesan Masuk</span>
                    </a>
                </div>

                <?php if ($userRole === 'admin'): ?>
                    <div>
                        <a href="<?= base_url('panel/setting'); ?>" class="mb-2 flex items-center px-3 py-2.5 <?= strpos(current_url(), 'setting') !== false ? 'bg-indigo-600 text-white' : 'hover:bg-slate-800 hover:text-white'; ?> rounded-lg group transition-colors">
                            <i class="fa-solid fa-sliders w-6 text-center <?= strpos(current_url(), 'setting') !== false ? 'text-white' : 'group-hover:text-indigo-400'; ?>"></i>
                            <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Pengaturan Web</span>
                        </a>

                        <div x-data="{ open: <?= (strpos(current_url(), 'users') !== false || strpos(current_url(), 'roles') !== false || strpos(current_url(), 'log') !== false) ? 'true' : 'false'; ?> }">
                            <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition-colors group <?= (strpos(current_url(), 'users') !== false || strpos(current_url(), 'roles') !== false || strpos(current_url(), 'log') !== false) ? 'text-white' : ''; ?>">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-shield-halved w-6 text-center <?= (strpos(current_url(), 'users') !== false || strpos(current_url(), 'roles') !== false || strpos(current_url(), 'log') !== false) ? 'text-indigo-400' : 'group-hover:text-indigo-400'; ?> transition-colors"></i>
                                    <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Otoritas Akun</span>
                                </div>
                                <i x-show="sidebarOpen" class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="open && sidebarOpen" x-collapse class="pl-10 pr-3 py-1 space-y-1">
                                <a href="<?= base_url('panel/users'); ?>" class="block py-2 text-sm <?= strpos(current_url(), 'users') !== false ? 'text-indigo-400 font-medium' : 'text-gray-400 hover:text-white'; ?> transition-colors">Daftar Pengguna</a>
                                <a href="#" class="block py-2 text-sm <?= strpos(current_url(), 'roles') !== false ? 'text-indigo-400 font-medium' : 'text-gray-400 hover:text-white'; ?> transition-colors">Hak Akses (Roles)</a>
                                <a href="<?= base_url('panel/log'); ?>" class="block py-2 text-sm <?= strpos(current_url(), 'log') !== false ? 'text-indigo-400 font-medium' : 'text-gray-400 hover:text-white'; ?> transition-colors">Log Aktivitas</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </nav>

            <div class="p-4 border-t border-slate-800 shrink-0">
                <a href="<?= base_url('panel/logout'); ?>" class="flex items-center px-3 py-2.5 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-500 transition-colors group">
                    <i class="fa-solid fa-arrow-right-from-bracket w-6 text-center"></i>
                    <span x-show="sidebarOpen" class="ml-3 font-medium text-sm">Logout</span>
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">

            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10 shrink-0">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-indigo-600 focus:outline-none transition-colors">
                        <i class="fa-solid fa-bars-staggered text-xl"></i>
                    </button>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ profileOpen: false }">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center space-x-2 focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name=<?= session()->get('nama_lengkap'); ?>&background=6366f1&color=fff" alt="User" class="w-9 h-9 rounded-full border-2 border-indigo-100">
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-700 leading-tight"><?= session()->get('nama_lengkap'); ?></p>
                                <p class="text-xs text-gray-500 capitalize"><?= session()->get('role'); ?></p>
                            </div>
                            <i class="fa-solid fa-angle-down text-gray-400 text-xs ml-1"></i>
                        </button>

                        <div x-show="profileOpen" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border border-gray-100" x-cloak>
                            <a href="<?= base_url('panel/my-profile'); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors"><i class="fa-solid fa-user-shield mr-2"></i> Profil Saya</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="<?= base_url('panel/logout'); ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"><i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                <?= $this->renderSection('content'); ?>
            </main>

            <footer class="bg-white border-t border-gray-200 py-4 px-6 flex flex-col sm:flex-row items-center justify-between shrink-0 z-10">
                <div class="text-sm text-gray-500">
                    &copy; <?= date('Y'); ?> <span class="font-semibold text-gray-800">AdminPanel</span>. All Rights Reserved.
                </div>
            </footer>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        <?php if (session()->getFlashdata('pesan')): ?>
            Toast.fire({
                icon: 'success',
                title: '<?= session()->getFlashdata('pesan'); ?>'
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            Toast.fire({
                icon: 'error',
                title: '<?= session()->getFlashdata('error'); ?>'
            });
        <?php endif; ?>
    </script>
</body>

</html>