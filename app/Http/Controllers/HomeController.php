<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Schedule;
use App\Models\Room;

use Auth;

class HomeController extends Controller
{
    
    public static function page_calendar(Request $request)
    {

        $default_date = date('Y-m'); $month_filter = date('m'); $year_filter = date('Y');
        if (!empty($request->bulan)) {
            $default_date = $request->tahun.'-'.$request->bulan; 
            $month_filter = $request->bulan; 
            $year_filter = $request->tahun;
        }

        $gt_date_and_schedules = Schedule::gt_date_and_schedules($default_date);
        $gt_all_date = Schedule::gt_all_date($default_date);
        
        if(Auth::check()){
            return view('auth/home', [
                'page'          => 'Home',
                'js_script'     => '/js/home.js',
                // 'jadwal'        => $gt_date_and_schedules,
                'dt_date'       => $gt_all_date,
                'room_jadwal'   => $gt_date_and_schedules,
                'data'          => Room::all(),
                'month_filter'  => $month_filter,
                'year_filter'   => $year_filter
            ]);
        } else {
            return view('home', [
                'page'          => 'Home',
                'js_script'     => '/js/home.js',
                // 'jadwal'        => $gt_date_and_schedules,
                'dt_date'       => $gt_all_date,
                'room_jadwal'   => $gt_date_and_schedules,
                'data'          => Room::all(),
                'month_filter'  => $month_filter,
                'year_filter'   => $year_filter
            ]);
        }

    }

    public static function page_room(Request $request)
    {

        $default_date = date('Y-m'); $month_filter = date('m'); $year_filter = date('Y');

        if(!empty($request->bulan))
        {
            $default_date = $request->tahun.'-'.$request->bulan;
            $month_filter = $request->bulan;
            $year_filter = $request->tahun;
        }

        $get_room_by_slug = Room::where(['slug' => $request->slug])->first();

        $gt_date_and_schedules_by_room = Schedule::gt_date_and_schedules_by_room($default_date, $get_room_by_slug->id, $month_filter, $year_filter);

        if(Auth::check()){
            return view('auth/room', [
                'kalender'      => $gt_date_and_schedules_by_room,
                'room'          => $get_room_by_slug,
                'month_filter'  => $month_filter,
                'year_filter'   => $year_filter
            ]);
        } else {
            return view('room', [
                'kalender'      => $gt_date_and_schedules_by_room,
                'room'          => $get_room_by_slug,
                'month_filter'  => $month_filter,
                'year_filter'   => $year_filter
            ]);
        }
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

                    Schedule::updateOrCreate(
                    [
                        'id'            => $request->id
                    ],
                    [
                        'id_room'       => $request->post('id_room'),
                        'description'   => $request->post('deskripsi'),
                        'date'          => $request->post('tanggal'),
                        'client'        => $request->post('klien'),
                        // 'start_time'    => $request->post('jam_mulai'),
                        // 'end_time'      => $request->post('jam_selesai')
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

    public static function ajax_del_jadwal(Request $request)
    {
        if($request->ajax()) {

            Schedule::updateOrCreate(
                [
                    'id'        => $request->id
                ],
                [
                    'status'    => 0
                ]);

            return response()->json([
                'success'   => TRUE,
                'message'   => 'Jadwal berhasil dihapus'
            ]);
        }
    }

}
