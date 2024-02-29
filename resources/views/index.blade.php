<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Penjadwalan App | {{ isset($page) ? $page : "Page"; }}</title>

    <link rel="icon" type="image/png" href="">

    <!-- Start CSS -->
    {{-- <link rel="stylesheet"  href="{{ asset('/dashlite/css/dashlite.css?ver=3.1.0') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('/dashlite/css/theme.css?ver=3.1.0') }}">
    <link rel="stylesheet" href="{{ asset('custom/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('custom/style.css') }}">
    <!-- End CSS -->
    
</head>

<body>
    
    <div class="tableFixHead">
    <table border="2" width="5000px">
       
        @foreach($data->chunk(3) as $datax)

            <thead>
                <tr>
                    @foreach(collect($kalender)->chunk(7) as $kal)

                        <th width="300px">
                            <select name="bulan" id="bulan">
                                <option value="">Pilih Bulan</option>
                                <option value="1" {{ (date('m') == 1) ? 'selected' : '' }}>Januari</option>
                                <option value="2" {{ (date('m') == 2) ? 'selected' : '' }}>Februari</option>
                                <option value="3" {{ (date('m') == 3) ? 'selected' : '' }}>Maret</option>
                                <option value="4" {{ (date('m') == 4) ? 'selected' : '' }}>April</option>
                                <option value="5" {{ (date('m') == 5) ? 'selected' : '' }}>Mei</option>
                                <option value="6" {{ (date('m') == 6) ? 'selected' : '' }}>Juni</option>
                                <option value="7" {{ (date('m') == 7) ? 'selected' : '' }}>Juli</option>
                                <option value="8" {{ (date('m') == 8) ? 'selected' : '' }}>Agustus</option>
                                <option value="9" {{ (date('m') == 9) ? 'selected' : '' }}>September</option>
                                <option value="10" {{ (date('m') == 10) ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ (date('m') == 11) ? 'selected' : '' }}>November</option>
                                <option value="12" {{ (date('m') == 12) ? 'selected' : '' }}>Desember</option>
                            </select>
                            <select name="tahun" id="tahun">
                                @for ($i = 2014; $i <= date('Y')+2; $i++)
                                    <option value="{{ $i }}" {{ ($i==date('Y') ? "selected" : "") }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <button>GO</button>
                        </th>

                        @foreach($kal as $k)
                            @if ($k['hari'] == "Sun")
                                <th width="140px" style="text-align: right;border: 1px solid red;color:red;">{{ $k['day'] }}</th>
                            @else
                                <th width="140px" style="text-align: right;">{{ $k['day'] }}</th>
                            @endif
                        @endforeach

                    @endforeach
                </tr>
            </thead>

            @foreach($datax as $row) 
    
                <tr>
                    {{-- <td style="border: 2px solid black;">{{ $row->nama_ruangan }}</td> --}}
                    @foreach (collect($jadwal)->chunk(7) as $jadwalx)

                    <td style="border: 2px solid black;text-align:center;">
                        <a href="detail/{{ $row->id }}">
                            <div style="padding-top:80px;;height:100%;width:100%;text-align:center;margin:auto;vertical-align: middle;display: inline-block;">
                                {{ $row->nama_ruangan }}
                            </div>
                        </a>
                    </td>

                    @foreach ($jadwalx as $row1)
                        @if ( $row1['hari'] == "Sun")
                            @if ( date('d') == $row1['date'])
                                <td width="140px" style="text-align: left;border: 2px solid red;color:red;background-color: red; font-size : 11px; color:white;">
                                    @if ( $row->id == $row1['id_room'] )
                                        {{ $row1['title'] }}
                                        <br>
                                        <br>
                                        {{ $row1['start_date'] }} <br> s/d <br>{{ $row1['end_date'] }}
                                    @endif
                                </td>
                            @else
                                <td width="140px" style="text-align: left;border: 2px solid red;color:red;font-size : 11px;">
                                    @if ( $row->id == $row1['id_room'] )
                                        {{ $row1['title'] }}
                                        <br>
                                        <br>
                                        {{ $row1['start_date'] }} s/d {{ $row1['end_date'] }}
                                    @endif
                                </td>
                            @endif                
                        @else
                            @if ( date('d') == $row1['date'])
                                <td width="140px" style="text-align: left; border: 2px solid black; background-color: blue; font-size : 11px; color:white;">
                                    @if ( $row->id == $row1['id_room'] )
                                        {{ $row1['title'] }}
                                        <br>
                                        <br>
                                        {{ $row1['start_date'] }} <br> s/d <br>{{ $row1['end_date'] }}
                                    @endif
                                </td>
                            @else
                                @if (!empty($row1['title']))
                                    <td width="140px" style="border: 2px solid black; text-align: left;background-color:#e4b236; font-size : 11px; color:white;">
                                        @if ( $row->id == $row1['id_room'] )
                                            {{ $row1['title'] }}
                                            <br>
                                            <br>
                                            {{ $row1['start_date'] }} <br> s/d <br>{{ $row1['end_date'] }}
                                        @endif
                                    </td>
                                @else
                                    <td width="140px" style="text-align: left; border: 2px solid black;"></td>
                                @endif
                            @endif      
                        @endif
                    @endforeach

                    @endforeach
                </tr>

            @endforeach

        @endforeach
        
      </table>
    
    </div>
</body>