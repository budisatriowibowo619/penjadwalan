<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Home;

class HomeController extends Controller
{

    public function index()
    {
        $dt_date_permonth = [];

        $dt_jadwal = Home::all();

        for ($i = 1; $i <= date('t', strtotime('Y-m-d')); $i++){
            $tanggal = date('Y-m-d', strtotime(date('Y-m-'.$i.'')));

            $title = $description = $start_datetime = $start_date = $end_datetime = $end_date = $id_room = null;
            if(!empty($dt_jadwal)){
                foreach($dt_jadwal as $row){
                    $date_start = date("Y-m-d", strtotime($row->start_datetime));
                    $date_end = date("Y-m-d", strtotime($row->end_datetime));
                    if($tanggal >= $date_start && $tanggal <=  $date_end){
                        $title = $row->title;
                        $description = $row->description;
                        $id_room = $row->id_room;
                        $start_date = $date_start;
                        $end_date = $date_end;
                    }
                }
            }

            $dt_date_permonth[] = [
                'tanggal'       => $tanggal,
                'start_date'    => $start_date,
                'end_date'      => $end_date,
                'title'         => $title,
                'description'   => $description,
                'id_room'       => $id_room,
                'hari'          => date('D', strtotime($tanggal)),
                'date'          => date('d', strtotime($tanggal))
            ];
        }

        return view('index', [
            'page'      => 'Home',
            'js_script' => '/js/home.js',
            'jadwal'    => $dt_date_permonth,
            'data'      => Home::gt_ms_room() 
        ]);
    }

}
