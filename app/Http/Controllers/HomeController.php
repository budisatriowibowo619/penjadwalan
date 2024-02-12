<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Home;

class HomeController extends Controller
{

    public function index()
    {
        $dt_date_permonth = [];

        $dt_jadwal = [
            ['tanggal'   => '2024-02-07', 'text'      => 'Ada jadwal 13'],
            ['tanggal'  => '2024-02-18', 'text' => 'Ada jadwal 18']
        ];

        for ($i = 1; $i <= date('t', strtotime('Y-m-d')); $i++){
            $tanggal = date('Y-m-d', strtotime(date('Y-m-'.$i.'')));

            $text = '';
            foreach($dt_jadwal as $row){
                if($row['tanggal'] == $tanggal){
                    $text = $row['text'];
                }
            }

            $dt_date_permonth[] = [
                'tanggal'   => $tanggal,
                'text'      => $text,
                'hari'      => date('D', strtotime($tanggal)),
                'date'      => date('d', strtotime($tanggal))
            ];
        }

        return view('index', [
            'page'      => 'Home',
            'js_script' => '/js/home.js',
            'jadwal'    => $dt_date_permonth,
            'data'  => [
                'Jasmine ballroom',
                'Roses Ballroom',
                'Lavender Ballroom'
            ],
        ]);
    }

}
