<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Home;

use DateTime;
use DateTimeZone;
use DateInterval;
use DatePeriod;

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

        $arr_tanggal = [];

        for ($i = 1; $i <= date('t', strtotime('Y-m-d')); $i++) {
            $arr_tanggal[] = [
                'tanggal'   => date('Y-m-'.$i),
                'day'       => date('d', strtotime(date('Y-m-'.$i.''))),
                'hari'      => date('D', strtotime(date('Y-m-'.$i.'')))
            ];
        }

        return view('index', [
            'page'      => 'Home',
            'js_script' => '/js/home.js',
            'jadwal'    => $dt_date_permonth,
            'data'      => Home::gt_ms_room() ,
            'kalender'  => $arr_tanggal
        ]);
    }

    public function detail(Request $request)
    {
        $dt_tanggal = [];

        for ($i = 1; $i <= date('t', strtotime('Y-m-t')); $i++){
            $arr_tanggal[] = [
                'tanggal'   => date('Y-m-d', strtotime(date('Y-m-'.$i)))
            ];
        }

        $def = 0;
        $dt_awal = date('D', strtotime(date('Y-m-01')));
        
        if($dt_awal == 'Sun'){
            $def = 0;
        } else if ($dt_awal == 'Mon'){
            $def = 1;
        } else if ($dt_awal == 'Tue'){
            $def = 2;
        } else if ($dt_awal == 'Wed'){
            $def = 3;
        } else if ($dt_awal == 'Thu'){
            $def = 4;
        } else if ($dt_awal == 'Fri'){
            $def = 5;
        } else if ($dt_awal == 'Sat'){
            $def = 6;
        }

        $d = date('d') + $def;
        
        // dd(date('Y-m-d', strtotime('-'.$d.' days')));

        $diffday = 0;
        if($def == 0){
            $diffday = 0; 
        } else {
            $diffday = '-'.$d;
        }

        // $now = new DateTime( "7 days ago", new DateTimeZone('America/New_York'));
        $now = new DateTime(date('Y-m-d', strtotime(($diffday+1).' days')));
        // dd($now);
        $interval = new DateInterval( 'P1D'); // 1 Day interval
        $period = new DatePeriod( $now, $interval, ($def-1)); // 7 Days

        $sale_data = array();
        foreach( $period as $day) {
            $key = $day->format( 'Y-m-d');
            $sale_data[] = [
                'tanggal'   => $key
            ];
        }

        $merge_tanggal = array_merge($sale_data, $arr_tanggal);

        $dt_date_permonth = [];

        $dt_jadwal = Home::all($request->id);

        foreach($merge_tanggal as $r_tanggal)
        {
            $tanggal = $r_tanggal['tanggal'];

            $title = $description = $start_datetime = $start_date = $end_datetime = $end_date = $id_room = null;
            if(!empty($dt_jadwal)){
                foreach($dt_jadwal as $row){
                    $date_start = date("Y-m-d", strtotime($row->start_datetime));
                    $date_end = date("Y-m-d", strtotime($row->end_datetime));
                    if($tanggal >= $date_start && $tanggal <=  $date_end){
                        $title = $row->title;
                        $description = $row->description;
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
                'hari'          => date('D', strtotime($tanggal)),
                'date'          => date('d', strtotime($tanggal))
            ];
        }

        // dd($dt_date_permonth);

        return view('detail', [
            'kalender'  => $dt_date_permonth,
            'def'       => $def,
            'room'      => Home::gt_ms_room($request->id),
        ]);
    }

    public static function ajax_pcs_jadwal(Request $request)
    {
        if($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'id_room'   => 'required',
                'tanggal'   => 'required',
                'deskripsi' => 'required'
            ]);

            if($validator->fails()) return response()->json(implode(',',$validator->errors()->all()), 422);

            Home::insert_jadwal(
                [
                    'deskripsi' => $request->deskripsi,
                    'id_room'   => $request->id_room,
                    'tanggal'   => $request->tanggal
                ]
            );

            return response()->json(['success' => TRUE, 'message'  => 'Data master kendaraan berhasil disimpan']);
        }
    }
}
