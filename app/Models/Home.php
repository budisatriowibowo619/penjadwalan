<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Home
{

    public static function get_user_status()
    {
        $get_user = User::where('id', auth()->id())->first();

        return $get_user['user_status'];
    }

    public static function all($id_room = 0)
    {
        if(empty($id_room)){
            $get_tb_jadwal = DB::table('schedules')->where('status', 1)->get();
        } else {
            $get_tb_jadwal = DB::table('schedules')->where(['status' => 1,'id_room' => $id_room])->get();
        }

        return $get_tb_jadwal;
    }

    public static function gt_ms_room($id = 0)
    {
        if(empty($id)){
            $get_ms_room = DB::table('ms_room')->where('status', 1)->get();
        } else {
            $get_ms_room = DB::table('ms_room')->where(['status' => 1,'id' => $id])->first();
        }

        return $get_ms_room;
    }

    public static function insert_jadwal($params = [])
    {
        DB::table('schedules')->insert([
            'title'         => $params['deskripsi'],
            'id_room'       => $params['id_room'],
            'start_datetime'=> $params['tanggal'].' 00:00:00',
            'end_datetime'  => $params['tanggal'].' 00:00:00',
        ]);
    }

    public static function delete_jadwal($params = [])
    {
        DB::table('schedules')->where('id', $params['id'])->update(['status' => 0]);
    }

}
