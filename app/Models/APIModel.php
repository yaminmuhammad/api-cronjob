<?php

namespace App\Models;

use CodeIgniter\Model;

class APIModel extends Model
{
    protected $table            = 'jadwal_sholat';
    protected $allowedFields    = ['tanggal', 'imsak', 'subuh', 'terbit', 'dhuha', 'dzuhur', 'ashar', 'maghrib', 'isya', 'date'];

    public function getJadwalSholat($tanggal, $bulan, $tahun)
    {
        $url = 'https://api.myquran.com/v1/sholat/jadwal/1210/' . $tahun . '/' . $bulan . '/' . $tanggal;
        $data = file_get_contents($url);
        $data = json_decode($data, true);

        return $data;
    }
}
