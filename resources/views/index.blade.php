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
    <table border="2" width="4000px">
        <thead>
        <tr>
            <th width="400px">
                <select name="bulan" id="bulan">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                <select name="tahun" id="tahun">
                    @for ($i = 2014; $i <= date('Y')+2; $i++)
                        <option value="{{ $i }}" {{ ($i==date('Y') ? "selected" : "") }}>{{ $i }}</option>
                    @endfor
                </select>
                <button>GO</button>
            </th>
            @for ($i = 1; $i <= date('t', strtotime('Y-m-d')); $i++)
                @if ( date('D', strtotime(date('Y-m-'.$i.''))) == "Sun")
                    <th width="140px" style="text-align: right;border: 1px solid red;color:red;">{{ date('d', strtotime(date('Y-m-'.$i.''))) }}</th>
                @else
                    <th width="140px" style="text-align: right;">{{ date('d', strtotime(date('Y-m-'.$i.''))) }}</th>
                @endif
            @endfor
        </tr>
    </thead>

        @foreach($data as $row)
            <tr>
                <td style="border: 2px solid black;">{{ $row->nama_ruangan }}</td>
                @foreach ($jadwal as $row1)

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
            </tr>
        @endforeach
        
      </table>
    
    </div>
</body>