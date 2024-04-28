<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Schedule;
use App\Models\Room;
use App\Models\Home;

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
            $user_status = 0;
            $gt_user_status = Home::get_user_status();
            $user_view = '';
            if($gt_user_status == 1){
                $user_view = 'auth/home';
            } else if ($gt_user_status == 2){
                $user_view = 'auth/home';
            } else {
                $user_view = 'auth/home';
            }
            return view($user_view, [
                'page'          => 'Home',
                'js_script'     => '/js/home.js',
                'dt_date'       => $gt_all_date,
                'room_jadwal'   => $gt_date_and_schedules,
                'data'          => Room::all(),
                'month_filter'  => $month_filter,
                'year_filter'   => $year_filter
            ]);
        } else {
            return view('auth/login', [
                'page'      => 'Login',
                'js_script' => '/js/auth/login.js' 
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
            $user_status = 0;
            $gt_user_status = Home::get_user_status();
            $user_view = '';
            if($gt_user_status == 1){
                $user_view = 'auth/room';
            } else if ($gt_user_status == 2){
                $user_view = 'sales/room';
            } else {
                $user_view = 'room';
            }
            return view($user_view, [
                'kalender'      => $gt_date_and_schedules_by_room,
                'room'          => $get_room_by_slug,
                'month_filter'  => $month_filter,
                'year_filter'   => $year_filter
            ]);
        } else {
            return view('auth/login', [
                'page'      => 'Login',
                'js_script' => '/js/auth/login.js' 
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

    public function ajax_gt_penjadwalan(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'id'   => 'required'
            ]);

            if($validator->fails()) {
                return response()->json(implode(',',$validator->errors()->all()), 422);
            }
            
            $gt_penjadwalan = Schedule::where('id', $request->id)->first();

            $arr_penjadwalan = [];

            if(!empty($gt_penjadwalan))
            {
                $arr_penjadwalan = [
                    'id'            => $gt_penjadwalan->id,
                    'client'        => $gt_penjadwalan->client,
                    'description'   => $gt_penjadwalan->description,
                    'tanggal'       => $gt_penjadwalan->date
                ];
            }

            return response()->json($arr_penjadwalan);

        }
    }

}
