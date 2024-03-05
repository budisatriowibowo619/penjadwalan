<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DateTime;
use DateTimeZone;
use DateInterval;
use DatePeriod;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function convert_nama_bulan($bulan = 0)
    {
        $text = '';
        
        if(!empty($bulan)){
            if($bulan == '1'){
                $text = 'Januari';
            } else if($bulan == '2'){
                $text = 'Februari';
            } else if($bulan == '3'){
                $text = 'Maret';
            } else if($bulan == '4'){
                $text = 'April';
            } else if($bulan == '5'){
                $text = 'Mei';
            } else if($bulan == '6'){
                $text = 'Juni';
            } else if($bulan == '7'){
                $text = 'Juli';
            } else if($bulan == '8'){
                $text = 'Agustus';
            } else if($bulan == '9'){
                $text = 'September';
            } else if($bulan == '10'){
                $text = 'Oktober';
            } else if($bulan == '11'){
                $text = 'November';
            } else if($bulan == '12'){
                $text = 'Desember';
            }
        }

        return $text;
    }

    public static function gt_date_and_schedules($default_date)
    {
        $get_schedules = static::where('status',1)->get();

        $dt_date_permonth = [];
        for ($i = 1; $i <= date('t', strtotime($default_date.'-01')); $i++){
            $tanggal = date('Y-m-d', strtotime(date($default_date.'-'.$i.'')));

            $title = $description = $start_datetime = $start_date = $end_datetime = $end_date = $id_room = $tanggal_full = $jam_full = $client = null;
            if(!empty($get_schedules)){
                foreach($get_schedules as $row){
                    if($tanggal == $row->date){
                        $description = $row->description;
                        $id_room = $row->id_room;
                        $tanggal_full = date("d", strtotime($row->date)).' '.static::convert_nama_bulan(date("m", strtotime($row->date))).' '.date("Y", strtotime($row->date));
                        $jam_full = date("H:i", strtotime($row->start_time)).' s/d '.date('H:i', strtotime($row->end_time));
                        $client = $row->client;
                    }
                }
            }

            $dt_date_permonth[] = [
                'client'        => $client,
                'tanggal'       => $tanggal,
                'description'   => $description,
                'id_room'       => $id_room,
                'hari'          => date('D', strtotime($tanggal)),
                'date'          => date('d', strtotime($tanggal)),
                'tanggal_full'  => $tanggal_full,
                'jam_full'      => $jam_full
            ];
        }

        return $dt_date_permonth;
    }

    public static function gt_date_and_schedules_by_room($default_date, $get_id_room, $month_filter, $year_filter)
    {
        $arr_tanggal = [];
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

        if(!empty($month_filter))
        {
            $jumlah_hari_sebelumnya = 0;
            if($month_filter != date('m')){
                if($month_filter < date('m')) {  
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

                    if($year_filter != date('Y')){
                        $startTimeStamp = strtotime(date($default_date.'-01'));
                        $datestring= date('Y-m-d').'last day of last month';
                        $dt = date_create($datestring);
                        $endTimeStamp = strtotime($dt->format('Y-m-d'));

                        $timeDiff = abs($endTimeStamp - $startTimeStamp);

                        $numberDays = $timeDiff/86400;  // 86400 seconds in one day

                        $numberDays = intval($numberDays) + 1;
                        $jumlah_hari_sebelumnya = $numberDays;

                        $d = date('d') + $def + $jumlah_hari_sebelumnya - 1;
                    } else {
                        $startTimeStamp = strtotime(date('Y-m-01', strtotime(date($default_date.'-01'))));
                        $datestring= date('Y-m-d');
                        $dt = date_create($datestring);
                        $endTimeStamp = strtotime($dt->format('Y-m-d'));

                        $timeDiff = abs($startTimeStamp - $endTimeStamp);

                        $numberDays = $timeDiff/86400;  // 86400 seconds in one day

                        $numberDays = intval($numberDays);
                        $jumlah_hari_selanjutnya = $numberDays;
                        
                        $d = $jumlah_hari_selanjutnya - $def;
                    }
                }
            } else {
                $d = date('d') + $def - 1;
            }
        } else {
            $d = date('d') + $def - 1;
        }

        $diffday = 0; $defi = 0; $sale_data = array();

        if($def == 0){
            $diffday = 0; 
        } else if ($def == 1){
            if($month_filter < date('m')) {
                $now = new DateTime(date('Y-m-d', strtotime('-'.($d).' days')));
            } else {
                $now = new DateTime(date('Y-m-d', strtotime('+'.($d).' days')));
            }
            $sale_data[] = [
                'tanggal'   => $now->format('Y-m-d')
            ];
        } else {
            $diffday = '-'.$d;
            $defi = $def -1;
            if($month_filter < date('m')) {
                $now = new DateTime(date('Y-m-d', strtotime('-'.($d).' days')));
            } else {
                if($year_filter == date('Y')){
                    if($month_filter != date('m')){
                        $now = new DateTime(date('Y-m-d', strtotime('+'.($d).' days')));
                    } else {
                        $now = new DateTime(date('Y-m-d', strtotime('-'.($d).' days')));
                    }
                } else {
                    $now = new DateTime(date('Y-m-d', strtotime('-'.($d).' days')));
                }
            }
            $interval = new DateInterval( 'P1D'); // 1 Day interval
            $period = new DatePeriod( $now, $interval, ($defi)); // 7 Days
            foreach( $period as $day) {
                $key = $day->format( 'Y-m-d');
                $sale_data[] = [
                    'tanggal'   => $key
                ];
            }
        }

        $merge_tanggal = array_merge($sale_data, $arr_tanggal);

        $dt_date_permonth = [];

        $get_schedules = static::where(['status' => 1,'id_room' => $get_id_room])->get();

        foreach($merge_tanggal as $r_tanggal)
        {
            $tanggal = $r_tanggal['tanggal'];

            $title = $description = $start_datetime = $start_date = $end_datetime = $end_date = $id_room = $tanggal_full = $jam_full = $client = null;
            $id_jadwal = 0;
            if(!empty($get_schedules)){
                foreach($get_schedules as $row){
                    if($tanggal == $row->date){
                        $id_jadwal = $row->id;
                        $description = $row->description;
                        $id_room = $row->id_room;
                        $tanggal_full = date("d", strtotime($row->date)).' '.static::convert_nama_bulan(date("m", strtotime($row->date))).' '.date("Y", strtotime($row->date));
                        $jam_full = date("H:i", strtotime($row->start_time)).' s/d '.date('H:i', strtotime($row->end_time));
                        $client = $row->client;
                    }
                }
            }

            $dt_date_permonth[] = [
                'client'        => $client,
                'tanggal'       => $tanggal,
                'description'   => $description,
                'id_room'       => $id_room,
                'hari'          => date('D', strtotime($tanggal)),
                'date'          => date('d', strtotime($tanggal)),
                'tanggal_full'  => $tanggal_full,
                'jam_full'      => $jam_full,
                'id_jadwal'     => $id_jadwal
            ];

        }

        return $dt_date_permonth;
    }
    
}
