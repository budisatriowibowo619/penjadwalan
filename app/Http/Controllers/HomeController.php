<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Home;

use DateTime;
use DateTimeZone;
use DateInterval;
use DatePeriod;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $dt_date_permonth = [];

        $dt_jadwal = Home::all();

        $default_date = 'Y-m';
        $bulan_filter = date('m');
        $tahun_filter = date('Y');
        if(!empty($request->bulan))
        {
            $default_date = $request->tahun.'-'.$request->bulan;
            $bulan_filter = $request->bulan;
            $tahun_filter = $request->tahun;
        }

        for ($i = 1; $i <= date('t', strtotime($default_date.'-01')); $i++){
            $tanggal = date('Y-m-d', strtotime(date($default_date.'-'.$i.'')));

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

        for ($i = 1; $i <= date('t', strtotime($default_date.'-01')); $i++) {
            $arr_tanggal[] = [
                'tanggal'   => date($default_date.'-'.$i),
                'day'       => date('d', strtotime(date('Y-m-'.$i.''))),
                'hari'      => date('D', strtotime(date('Y-m-'.$i.'')))
            ];
        }

        return view('index', [
            'page'      => 'Home',
            'js_script' => '/js/home.js',
            'jadwal'    => $dt_date_permonth,
            'data'      => Home::gt_ms_room() ,
            'kalender'  => $arr_tanggal,
            'bulan_filter'  => $bulan_filter,
            'tahun_filter'  => $tahun_filter
        ]);
    }

    public function detail(Request $request)
    {

        $dt_tanggal = [];

        $default_date = 'Y-m';
        $bulan_filter = date('m');
        $tahun_filter = date('Y');
        if(!empty($request->bulan))
        {
            $default_date = $request->tahun.'-'.$request->bulan;
            $bulan_filter = $request->bulan;
            $tahun_filter = $request->tahun;
        }

        for ($i = 1; $i <= date('t', strtotime($default_date.'-01')); $i++){
            $arr_tanggal[] = [
                'tanggal'   => date('Y-m-d', strtotime(date($default_date.'-'.$i)))
            ];
        }

        $def = 0;
        $dt_awal = date('D', strtotime(date($default_date.'-01')));
        
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

        if(!empty($request->bulan))
        {
            $jumlah_hari_sebelumnya = 0;
            if($request->bulan != date('m')){
                if($request->bulan < date('m')) {  
                    // $jumlah_hari_sebelumnya = date('t', strtotime(date($default_date.'-01')));
                    $startTimeStamp = strtotime(date($default_date.'-01'));
                    $datestring= date('Y-m-d').'last day of last month';
                    $dt = date_create($datestring);
                    $endTimeStamp = strtotime($dt->format('Y-m-d'));

                    $timeDiff = abs($endTimeStamp - $startTimeStamp);

                    $numberDays = $timeDiff/86400;  // 86400 seconds in one day

                    // and you might want to convert to integer
                    $numberDays = intval($numberDays) + 1;
                    $jumlah_hari_sebelumnya = $numberDays;

                    $d = date('d') + $def + $jumlah_hari_sebelumnya - 1;
                } else {

                    if($request->tahun != date('Y')){
                        $startTimeStamp = strtotime(date($default_date.'-01'));
                    $datestring= date('Y-m-d').'last day of last month';
                    $dt = date_create($datestring);
                    $endTimeStamp = strtotime($dt->format('Y-m-d'));

                    $timeDiff = abs($endTimeStamp - $startTimeStamp);

                    $numberDays = $timeDiff/86400;  // 86400 seconds in one day

                    // and you might want to convert to integer
                    $numberDays = intval($numberDays) + 1;
                    $jumlah_hari_sebelumnya = $numberDays;

                    $d = date('d') + $def + $jumlah_hari_sebelumnya - 1;
                    } else {
                        $startTimeStamp = date('Y-m-d',strtotime(date('Y-m-t', strtotime(date($default_date.'-01')))));
                        dd($startTimeStamp);
                        $datestring= date('Y-m-d');
                        $dt = date_create($datestring);
                        $endTimeStamp = strtotime($dt->format('Y-m-d'));

                        $timeDiff = abs($startTimeStamp - $endTimeStamp);

                        $numberDays = $timeDiff/86400;  // 86400 seconds in one day

                        // and you might want to convert to integer
                        $numberDays = intval($numberDays) + 3;
                        $jumlah_hari_selanjutnya = $numberDays;
                        
                        $d = date('d') + $def + $jumlah_hari_selanjutnya -  1;
                    }
                }
            } else {
                $d = date('d') + $def - 1;
            }
        } else {
            $d = date('d') + $def - 1;
        }

        // dd($d);


        $diffday = 0;
        $defi = 0;
        // dd($def);
        $sale_data = array();
        $now = new DateTime(date('Y-m-d', strtotime('-'.($d).' days')));
        // dd($now);

        if($def == 0){
            $diffday = 0; 
        } else if ($def == 1){
            $now = new DateTime(date('Y-m-d', strtotime('-'.($d).' days')));
            $sale_data[] = [
                'tanggal'   => $now->format('Y-m-d')
            ];
        } else {
            $diffday = '-'.$d;
            $defi = $def -1;
            $now = new DateTime(date('Y-m-d', strtotime('-'.($d).' days')));
            // dd($now);
            $interval = new DateInterval( 'P1D'); // 1 Day interval
            $period = new DatePeriod( $now, $interval, ($defi)); // 7 Days

            foreach( $period as $day) {
                $key = $day->format( 'Y-m-d');
                $sale_data[] = [
                    'tanggal'   => $key
                ];
            }
        }

        // dd($diffday);

        $merge_tanggal = array_merge($sale_data, $arr_tanggal);

        $dt_date_permonth = [];

        $dt_jadwal = Home::all($request->id);

        foreach($merge_tanggal as $r_tanggal)
        {
            $tanggal = $r_tanggal['tanggal'];

            $title = $description = $start_datetime = $start_date = $end_datetime = $end_date = $id_room = null;
            $id_jadwal = 0;
            if(!empty($dt_jadwal)){
                foreach($dt_jadwal as $row){
                    $date_start = date("Y-m-d", strtotime($row->start_datetime));
                    $date_end = date("Y-m-d", strtotime($row->end_datetime));
                    if($tanggal >= $date_start && $tanggal <=  $date_end){
                        $id_jadwal = $row->id;
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
                'date'          => date('d', strtotime($tanggal)),
                'id_jadwal'     => $id_jadwal
            ];

        }

        // dd($dt_date_permonth);

        return view('detail', [
            'kalender'  => $dt_date_permonth,
            'def'       => $def,
            'room'      => Home::gt_ms_room($request->id),
            'bulan_filter'  => $bulan_filter,
            'tahun_filter'  => $tahun_filter
        ]);
    }

    public static function ajax_pcs_jadwal(Request $request)
    {
        if($request->ajax()) {    
            $validator = Validator::make($request->all(), 
            [
                'id_room'   => 'required',
                'tanggal'   => 'required',
                'deskripsi' => 'required'
            ], 
            [
                'required' => ':attribute'
            ], 
            [
                'id_room'   => 'Ruangan tidak terdeteksi!',
                'tanggal'   => 'Tanggal tidak terdeteksi!',
                'deskripsi' => 'Deskripsi harus diisi!'
            ]);

            if($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => implode(',',$validator->errors()->all())
                ]);
                
            } else {
                try {
                    Home::insert_jadwal([
                        'deskripsi' => $request->post('deskripsi'),
                        'id_room'   => $request->post('id_room'),
                        'tanggal'   => $request->post('tanggal')
                    ]);

                    return response()->json([
                        'status' => 200,
                        'message' => 'Berhasil mendambahkan schedule!'
                    ]);
                } catch (\Throwable $th) {
                    
                    return response()->json([
                        'status' => 400,
                        'message' => 'Terjadi kesalahan saat mendambahkan schedule!'
                    ]);
                }
            } 
        }
    }

    public function ajax_del_jadwal(Request $request)
    {
        if($request->ajax()) {

            Home::delete_jadwal([
                'id'    => $request->id
            ]);

            return response()->json([
                'success'   => TRUE,
                'message'   => 'Jadwal berhasil dihapus'
            ]);
        }
    }

}