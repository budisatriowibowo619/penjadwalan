<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Home
{
    public static function all()
    {
        $get_tb_jadwal = DB::table('schedules')->where('status', 1)->get();

        return $get_tb_jadwal;
    }

    public static function gt_ms_room()
    {
        $get_ms_room = DB::table('ms_room')->where('status', 1)->get();

        return $get_ms_room;
    }
}
