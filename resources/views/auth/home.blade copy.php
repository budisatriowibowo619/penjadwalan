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
    <table border="0" width="5600px">
       
        @foreach($data->chunk(3) as $datax)

            <thead>
                <tr>
                    @foreach(collect($jadwal)->chunk(7) as $kal)

                        <th width="500px">
                            <form action="/" method="GET">
                                {{-- <button class="arrow-button"><</button> --}}
                                <a href="/logout" class="button-logout">Logout</a>
                                <select name="bulan" id="bulan">
                                    <option value="">Pilih Bulan</option>
                                    <option value="01" {{ ($month_filter == 1) ? 'selected' : '' }}>Januari</option>
                                    <option value="02" {{ ($month_filter == 2) ? 'selected' : '' }}>Februari</option>
                                    <option value="03" {{ ($month_filter == 3) ? 'selected' : '' }}>Maret</option>
                                    <option value="04" {{ ($month_filter == 4) ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ ($month_filter == 5) ? 'selected' : '' }}>Mei</option>
                                    <option value="06" {{ ($month_filter == 6) ? 'selected' : '' }}>Juni</option>
                                    <option value="07" {{ ($month_filter == 7) ? 'selected' : '' }}>Juli</option>
                                    <option value="08" {{ ($month_filter == 8) ? 'selected' : '' }}>Agustus</option>
                                    <option value="09" {{ ($month_filter == 9) ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ ($month_filter == 10) ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ ($month_filter == 11) ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ ($month_filter == 12) ? 'selected' : '' }}>Desember</option>
                                </select>
                                <select name="tahun" id="tahun">
                                    @for ($i = 2020; $i <= date('Y')+2; $i++)
                                        <option value="{{ $i }}" {{ ($i==$year_filter ? "selected" : "") }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <button>GO</button>
                            </form>
                        </th>

                        @foreach($kal as $k)
                            @if ($k['hari'] == "Sun")
                                <th width="150px" style="background-color:red; text-align: right;border: 1px solid red;color:white; padding-right:5px;">{{ $k['date'] }}</th>
                            @else
                                <th width="150px" style="text-align: right; padding-right:5px;">{{ $k['date'] }}</th>
                            @endif
                        @endforeach

                    @endforeach
                </tr>
            </thead>

            @foreach($datax as $row) 
    
                <tr>
                    @foreach (collect($jadwal)->chunk(7) as $jadwalx)

                    <td style="border: 2px solid black;text-align:center;">
                        <a href="pageRoom/{{ $row->slug }}">
                            <div style="padding-top:80px;;height:100%;width:100%;text-align:center;margin:auto;vertical-align: middle;display: inline-block;color:black;">
                                {{ $row->room; }}
                            </div>
                        </a>
                    </td>

                    @foreach ($jadwalx as $row1)
                        @if ( $row1['hari'] == "Sun")
                            @if ( date('d') == $row1['date'])
                                <td width="150px" style="text-align: left;border: 2px solid red;color:red;background-color: red; font-size : 11px; color:white;">
                                    @if ( $row->id == $row1['id_room'] )
                                    <b>{{ $row1['client'] }}</b>
                                    <br>
                                    <br>
                                    {{ $row1['description'] }}
                                    <br>
                                    <br>
                                    {{ $row1['tanggal_full'] }}
                                    <br>
                                    {{ $row1['jam_full'] }}
                                    @endif
                                </td>
                            @else
                                <td width="150px" style="text-align: left;border: 2px solid red;color:red;font-size : 11px;">
                                    @if ( $row->id == $row1['id_room'] )
                                    <b>{{ $row1['client'] }}</b>
                                    <br>
                                    <br>
                                    {{ $row1['description'] }}
                                    <br>
                                    <br>
                                    {{ $row1['tanggal_full'] }}
                                    <br>
                                    {{ $row1['jam_full'] }}
                                    @endif
                                </td>
                            @endif                
                        @else
                            @if ( date('d') == $row1['date'])
                                <td width="150px" style="text-align: left; border: 2px solid black; background-color: blue; font-size : 11px; color:white;">
                                    @if ( $row->id == $row1['id_room'] )
                                        <b>{{ $row1['client'] }}</b>
                                        <br>
                                        <br>
                                        {{ $row1['description'] }}
                                        <br>
                                        <br>
                                        {{ $row1['tanggal_full'] }}
                                        <br>
                                        {{ $row1['jam_full'] }}
                                    @endif
                                </td>
                            @else
                                @if (!empty($row1['description']))
                                    <td width="150px" style="border: 2px solid black; text-align: left;background-color:#e4b236; font-size : 11px; color:white;">
                                        @if ( $row->id == $row1['id_room'] )
                                        <b>{{ $row1['client'] }}</b>
                                        <br>
                                        <br>
                                        {{ $row1['description'] }}
                                        <br>
                                        <br>
                                        {{ $row1['tanggal_full'] }}
                                        <br>
                                        {{ $row1['jam_full'] }}
                                        @endif
                                    </td>
                                @else
                                    <td width="150px" style="text-align: left; border: 2px solid black;"></td>
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