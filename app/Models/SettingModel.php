<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'setting';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'nama_web',
        'deskripsi',
        'logo',
        'alamat',
        'telepon',
        'email',
        'facebook',
        'instagram',
        'youtube',
        'tiktok',
        'twitter',
        'maps',
        'link_ppdb',
        'stat_mitra',
        'stat_fasilitas',
        'stat_alumni',
        'is_maintenance',
        'hero_title',
        'hero_desc',
        'hero_image'
    ];

    protected $useTimestamps = false;
}
