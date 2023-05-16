<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Client;
use App\Controllers\BaseController;
use App\Models\APIModel;
use App\Models\Status;
use App\Models\StatusModel;
use CodeIgniter\HTTP\RequestInterface;

class ApiController extends BaseController
{


    public function index()
    {
        //
    }

    public function save()
    {
        $url = 'https://api.myquran.com/v1/sholat/jadwal/1210/2023/05/8';
        $data = file_get_contents($url);
        $data = json_decode($data, true);

        // $model = new APIModel();
        // $model->saveData($data);
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    // public function save()
    // {
    //     $tanggal = date('d');
    //     $bulan = date('m');
    //     $tahun = date('Y');

    //     $url = 'https://api.myquran.com/v1/sholat/jadwal/1210/' . $tahun . '/' . $bulan . '/' . $tanggal;
    //     $data = file_get_contents($url);
    //     $data = json_decode($data, true);

    //     $db = db_connect();
    //     $builder = $db->table('nama_tabel');

    //     $jadwal = $data['data']['jadwal'];

    //     // ubah format waktu dari string menjadi time
    //     $imsak = date('H:i:s', strtotime($jadwal['imsak']));
    //     $subuh = date('H:i:s', strtotime($jadwal['subuh']));
    //     $terbit = date('H:i:s', strtotime($jadwal['terbit']));
    //     $dhuha = date('H:i:s', strtotime($jadwal['dhuha']));
    //     $dzuhur = date('H:i:s', strtotime($jadwal['dzuhur']));
    //     $ashar = date('H:i:s', strtotime($jadwal['ashar']));
    //     $maghrib = date('H:i:s', strtotime($jadwal['maghrib']));
    //     $isya = date('H:i:s', strtotime($jadwal['isya']));

    //     // simpan ke database
    //     $jadwalModel = new APIModel();
    //     $jadwalModel->insert([
    //         'tanggal' => $jadwal['tanggal'],
    //         'imsak' => $imsak,
    //         'subuh' => $subuh,
    //         'terbit' => $terbit,
    //         'dhuha' => $dhuha,
    //         'dzuhur' => $dzuhur,
    //         'ashar' => $ashar,
    //         'maghrib' => $maghrib,
    //         'isya' => $isya,
    //         'date' => $jadwal['date']
    //     ]);
    // }
    public function check()
    {
        $jadwalModel = new APIModel();
        $statusMesin = new Status();


        $tanggal = date('d');
        $bulan = date('m');
        $tahun = date('Y');

        $url = 'https://api.myquran.com/v1/sholat/jadwal/1210/' . $tahun . '/' . $bulan . '/' . $tanggal;
        $data = file_get_contents($url);
        $data = json_decode($data, true);

        $db = db_connect();
        $builder = $db->table('jadwal_sholat');

        $jadwal = $data['data']['jadwal'];
        // dd(date('H:i:s', strtotime($jadwal['imsak'] . '+ 60 minutes')));
        // ubah format waktu dari string menjadi time
        $imsak = date('H:i:s', strtotime($jadwal['imsak']));
        $subuh = date('H:i:s', strtotime($jadwal['subuh']));
        $terbit = date('H:i:s', strtotime($jadwal['terbit']));
        $dhuha = date('H:i:s', strtotime($jadwal['dhuha']));
        $dzuhur = date('H:i:s', strtotime($jadwal['dzuhur']));
        $ashar = date('H:i:s', strtotime($jadwal['ashar']));
        $maghrib = date('H:i:s', strtotime($jadwal['maghrib']));
        $isya = date('H:i:s', strtotime($jadwal['isya']));

        $cekJadwal = $jadwalModel->where('tanggal', $jadwal['tanggal'])->first();
        if (!$cekJadwal) {
            //  simpan ke database
            $jadwalModel->insert([
                'tanggal' => $jadwal['tanggal'],
                'imsak' => $imsak,
                'subuh' => $subuh,
                'terbit' => $terbit,
                'dhuha' => $dhuha,
                'dzuhur' => $dzuhur,
                'ashar' => $ashar,
                'maghrib' => $maghrib,
                'isya' => $isya,
                'date' => $jadwal['date']
            ]);
        }
        $id = 1;

        $status = $statusMesin->find($id);
        if (!$status) {
            $statusMesin->insert([
                'status_mesin' => 'ON'
            ]);
        } else {
            $waktuSekarang = date('H:i:s');
            $waktuDzuhur = date('H:i:s', strtotime($jadwal['dzuhur']));
            $waktuDzuhur60 = date('H:i:s', strtotime($jadwal['dzuhur'] . '+ 60 minutes'));
            $waktuAshar = date('H:i:s', strtotime($jadwal['ashar']));
            $waktuAshar15 = date('H:i:s', strtotime($jadwal['ashar'] . '+ 15 minutes'));
            $waktuMaghrib = date('H:i:s', strtotime($jadwal['maghrib']));
            $waktuMaghrib30 = date('H:i:s', strtotime($jadwal['maghrib'] . '+ 30 minutes'));
            $waktuIsya = date('H:i:s', strtotime($jadwal['isya']));
            $waktuIsya15 = date('H:i:s', strtotime($jadwal['isya'] . '+ 15 minutes'));
            $waktuSubuh = date('H:i:s', strtotime($jadwal['subuh']));
            $waktuSubuh30 = date('H:i:s', strtotime($jadwal['subuh'] . '+ 30 minutes'));

            if ($waktuSekarang >= $waktuDzuhur && $waktuSekarang <= $waktuDzuhur60) {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } elseif ($waktuSekarang >= $waktuAshar && $waktuSekarang <= $waktuAshar15) {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } elseif ($waktuSekarang >= $waktuMaghrib && $waktuSekarang <= $waktuMaghrib30) {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } elseif ($waktuSekarang >= $waktuIsya && $waktuSekarang <= $waktuIsya15) {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } elseif ($waktuSekarang >= $waktuSubuh && $waktuSekarang <= $waktuSubuh30) {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } elseif ($waktuSekarang >= '07:25:00' && $waktuSekarang <= '07:24:00') {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } elseif ($waktuSekarang >= '16:25:00' && $waktuSekarang <= '16:40:00') {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } elseif ($waktuSekarang >= '22:00:00' && $waktuSekarang <= '22:10:00') {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } elseif ($waktuSekarang >= '00:25:00' && $waktuSekarang <= '00:40:00') {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } elseif ($waktuSekarang >= '10:00:00' && $waktuSekarang <= '10:10:00') {
                $statusMesin->update($id, [
                    'status_mesin' => 'OFF'
                ]);
            } else {
                $statusMesin->update($id, [
                    'status_mesin' => 'ON'
                ]);
            }
        }
        return $this->response->setJSON([
            'status_mesin' => $status['status_mesin']
        ]);

        // return view('time_view',);
    }


    // public function checkfix()
    // {
    //     $jadwalModel = new APIModel();
    //     $statusMesin = new Status();


    //     $tanggal = date('d');
    //     $bulan = date('m');
    //     $tahun = date('Y');
    //     $data['current_time'] = date('H:i:s', time()); // Menampilkan jam, menit, dan detik saat ini
    //     $url = 'https://api.myquran.com/v1/sholat/jadwal/1210/' . $tahun . '/' . $bulan . '/' . $tanggal;
    //     $data = file_get_contents($url);
    //     $data = json_decode($data, true);

    //     // dd($data['data']['jadwal']);
    //     // get waktu sekarang


    //     $db = db_connect();
    //     $builder = $db->table('jadwal_sholat');

    //     $jadwal = $data['data']['jadwal'];
    //     // dd(date('H:i:s', strtotime($jadwal['imsak'] . '+ 60 minutes')));
    //     // ubah format waktu dari string menjadi time
    //     $imsak = date('H:i:s', strtotime($jadwal['imsak']));
    //     $subuh = date('H:i:s', strtotime($jadwal['subuh']));
    //     $terbit = date('H:i:s', strtotime($jadwal['terbit']));
    //     $dhuha = date('H:i:s', strtotime($jadwal['dhuha']));
    //     $dzuhur = date('H:i:s', strtotime($jadwal['dzuhur']));
    //     $ashar = date('H:i:s', strtotime($jadwal['ashar']));
    //     $maghrib = date('H:i:s', strtotime($jadwal['maghrib']));
    //     $isya = date('H:i:s', strtotime($jadwal['isya']));

    //     $cekJadwal = $jadwalModel->where('tanggal', $jadwal['tanggal'])->first();
    //     if (!$cekJadwal) {
    //         //  simpan ke database
    //         $jadwalModel->insert([
    //             'tanggal' => $jadwal['tanggal'],
    //             'imsak' => $imsak,
    //             'subuh' => $subuh,
    //             'terbit' => $terbit,
    //             'dhuha' => $dhuha,
    //             'dzuhur' => $dzuhur,
    //             'ashar' => $ashar,
    //             'maghrib' => $maghrib,
    //             'isya' => $isya,
    //             'date' => $jadwal['date']
    //         ]);
    //     } else {
    //         // $jadwalModel->where('tanggal', $jadwal['tanggal'])->update([
    //         //     'imsak' => $imsak,
    //         //     'subuh' => $subuh,
    //         //     'terbit' => $terbit,
    //         //     'dhuha' => $dhuha,
    //         //     'dzuhur' => $dzuhur,
    //         //     'ashar' => $ashar,
    //         //     'maghrib' => $isya,
    //         //     'isya' => $isya,
    //         //     'date' => $jadwal['date']
    //         // ]);
    //     }
    //     $id = 1;

    //     $status = $statusMesin->find($id);
    //     if (!$status) {
    //         $statusMesin->insert([
    //             'status_mesin' => 'ON'
    //         ]);
    //     } else {
    //         $waktuSekarang = date('H:i:s');
    //         $waktuDzuhur = date('H:i:s', strtotime($jadwal['dzuhur']));
    //         $waktuDzuhur60 = date('H:i:s', strtotime($jadwal['dzuhur'] . '+ 60 minutes'));
    //         $waktuAshar = date('H:i:s', strtotime($jadwal['ashar']));
    //         $waktuAshar15 = date('H:i:s', strtotime($jadwal['ashar'] . '+ 15 minutes'));
    //         $waktuMaghrib = date('H:i:s', strtotime($jadwal['maghrib']));
    //         $waktuMaghrib30 = date('H:i:s', strtotime($jadwal['maghrib'] . '+ 30 minutes'));
    //         $waktuIsya = date('H:i:s', strtotime($jadwal['isya']));
    //         $waktuIsya15 = date('H:i:s', strtotime($jadwal['isya'] . '+ 15 minutes'));
    //         $waktuSubuh = date('H:i:s', strtotime($jadwal['subuh']));
    //         $waktuSubuh30 = date('H:i:s', strtotime($jadwal['subuh'] . '+ 30 minutes'));

    //         if ($waktuSekarang >= $waktuDzuhur && $waktuSekarang <= $waktuDzuhur60) {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } elseif ($waktuSekarang >= $waktuAshar && $waktuSekarang <= $waktuAshar15) {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } elseif ($waktuSekarang >= $waktuMaghrib && $waktuSekarang <= $waktuMaghrib30) {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } elseif ($waktuSekarang >= $waktuIsya && $waktuSekarang <= $waktuIsya15) {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } elseif ($waktuSekarang >= $waktuSubuh && $waktuSekarang <= $waktuSubuh30) {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } elseif ($waktuSekarang >= '07:25:00' && $waktuSekarang <= '07:24:00') {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } elseif ($waktuSekarang >= '16:25:00' && $waktuSekarang <= '16:40:00') {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } elseif ($waktuSekarang >= '22:00:00' && $waktuSekarang <= '22:10:00') {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } elseif ($waktuSekarang >= '00:25:00' && $waktuSekarang <= '00:40:00') {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } elseif ($waktuSekarang >= '10:00:00' && $waktuSekarang <= '10:10:00') {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'OFF'
    //             ]);
    //         } else {
    //             $statusMesin->update($id, [
    //                 'status_mesin' => 'ON'
    //             ]);
    //         }
    //     }


    //     // $data = [
    //     //     'status_mesin' => 'ON'
    //     // ];

    //     // $statusMesin->save($data);
    //     // $statusMesin->save($waktuSekarang, 'ON');
    //     // cek waktu subuh + 30 menit
    //     // $waktuSubuh = date('H:i:s', strtotime($jadwal['subuh']));
    //     // $waktuSubuh30 = date('H:i:s', strtotime($jadwal['subuh'] . ' + 30 minutes'));
    //     // if ($waktuSekarang >= $waktuSubuh && $waktuSekarang < $waktuSubuh30) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     // // cek waktu dzuhur + 60 menit
    //     // $waktuDzuhur = date('H:i:s', strtotime($jadwal['dzuhur']));
    //     // $waktuDzuhur60 = date('H:i:s', strtotime($jadwal['dzuhur'] . ' + 60 minutes'));
    //     // if ($waktuSekarang >= $waktuDzuhur && $waktuSekarang < $waktuDzuhur60) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     // // cek waktu ashar + 15 menit
    //     // $waktuAshar = date('H:i:s', strtotime($jadwal['ashar']));
    //     // $waktuAshar15 = date('H:i:s', strtotime($jadwal['ashar'] . ' + 15 minutes'));
    //     // if ($waktuSekarang >= $waktuAshar && $waktuSekarang < $waktuAshar15) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     // // cek waktu maghrib + 30 menit
    //     // $waktuMaghrib = date('H:i:s', strtotime($jadwal['maghrib']));
    //     // $waktuMaghrib30 = date('H:i:s', strtotime($jadwal['maghrib'] . ' + 30 minutes'));
    //     // if ($waktuSekarang >= $waktuMaghrib && $waktuSekarang < $waktuMaghrib30) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     // // cek waktu isya + 15 menit
    //     // $waktuIsya = date('H:i:s', strtotime($jadwal['isya']));
    //     // $waktuIsya15 = date('H:i:s', strtotime($jadwal['isya'] . ' + 15 minutes'));
    //     // if ($waktuSekarang >= $waktuIsya && $waktuSekarang < $waktuIsya15) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     // // cek waktu 10.00 - 10.10
    //     // $waktu10_00 = date('H:i:s', strtotime('10:00:00'));
    //     // $waktu10_10 = date('H:i:s', strtotime('10:10:00'));
    //     // if ($waktuSekarang >= $waktu10_00 && $waktuSekarang < $waktu10_10) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     // // cek waktu 07.25-07-40
    //     // $waktu07_25 = date('H:i:s', strtotime('07:25:00'));
    //     // $waktu07_40 = date('H:i:s', strtotime('07:40:00'));
    //     // if ($waktuSekarang >= $waktu07_25 && $waktuSekarang < $waktu07_40) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     // // cek waktu 16.25 - 16.40
    //     // $waktu16_25 = date('H:i:s', strtotime('16:25:00'));
    //     // $waktu16_40 = date('H:i:s', strtotime('16:40:00'));
    //     // if ($waktuSekarang >= $waktu16_25 && $waktuSekarang < $waktu16_40) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     // // cek waktu 22.00 - 22.10
    //     // $waktu22_00 = date('H:i:s', strtotime('22:00:00'));
    //     // $waktu22_10 = date('H:i:s', strtotime('22:10:00'));
    //     // if ($waktuSekarang >= $waktu22_00 && $waktuSekarang < $waktu22_10) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     // // cek waktu 00.25 - 00.40
    //     // $waktu00_25 = date('H:i:s', strtotime('00:25:00'));
    //     // $waktu00_40 = date('H:i:s', strtotime('00:40:00'));
    //     // if ($waktuSekarang >= $waktu00_25 && $waktuSekarang < $waktu00_40) {
    //     //     $statusMesin->save($waktuSekarang, 'OFF'); // assuming 'OFF' is the correct status to be updated
    //     // }

    //     return view('time_view', $data);
    // }


}
