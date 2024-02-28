<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Home
{
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
}
