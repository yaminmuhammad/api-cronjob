<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Time extends BaseController
{
    public function index()
    {
        $data['current_time'] = date('H:i:s', time()); // Menampilkan jam, menit, dan detik saat ini

        return view('time_view', $data);
    }
}
