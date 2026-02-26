<?= $this->extend('panel/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Log Aktivitas (Audit Trail)</h2>
    <p class="text-sm text-gray-500 mt-1">Rekam jejak seluruh aktivitas sistem. Data log tidak dapat diubah atau dihapus untuk menjaga keamanan audit.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-600 font-semibold border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4">Waktu</th>
                    <th class="px-6 py-4">Pengguna</th>
                    <th class="px-6 py-4">Aktivitas</th>
                    <th class="px-6 py-4">Modul / ID</th>
                    <th class="px-6 py-4">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada aktivitas terekam.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3 text-gray-500">
                                <?= date('d M Y', strtotime($log['created_at'])); ?> <br>
                                <span class="text-xs"><?= date('H:i:s', strtotime($log['created_at'])); ?></span>
                            </td>
                            <td class="px-6 py-3 font-medium text-gray-700">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                        <?= substr($log['nama_user'], 0, 1); ?>
                                    </div>
                                    <?= esc($log['nama_user']); ?>
                                </div>
                            </td>
                            <td class="px-6 py-3">
                                <?php
                                $bg = 'bg-gray-100 text-gray-600';
                                if ($log['action'] == 'CREATE') $bg = 'bg-green-100 text-green-700';
                                if ($log['action'] == 'UPDATE') $bg = 'bg-amber-100 text-amber-700';
                                if ($log['action'] == 'DELETE') $bg = 'bg-red-100 text-red-700';
                                if ($log['action'] == 'LOGIN')  $bg = 'bg-blue-100 text-blue-700';
                                ?>
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold tracking-wider <?= $bg; ?>">
                                    <?= esc($log['action']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <span class="font-semibold text-gray-800"><?= esc($log['module']); ?></span>
                                <?php if ($log['record_id']): ?>
                                    <span class="text-xs text-gray-400 ml-1">#<?= $log['record_id']; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-3 text-xs text-gray-500 font-mono">
                                <?= esc($log['ip_address']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-gray-100">
        <?= $pager->links('logs', 'default_full'); ?> </div>
</div>
<?= $this->endSection(); ?>