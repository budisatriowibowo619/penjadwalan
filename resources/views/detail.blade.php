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
    <link rel="stylesheet" href="{{ asset('custom/style-detail.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- End CSS -->
    
</head>

<body>

    <div class="container">

        <div class="room-title">
            <h1>{{ $room->nama_ruangan; }}</h1>
        </div>

        <div class="calendar">
            
            <table width="100%" class="table-calendar">
                <thead class="head-calendar">
                    <tr>
                        <th>Minggu</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th>Jum'at</th>
                        <th>Sabtu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(collect($kalender)->chunk(7) as $key => $kal)
                    
                        <tr>
                            @foreach($kal as $row)
                                @if(empty($row['title']))
                                    <td valign="top" width="140px" style="text-align: right; border: 2px solid red; color:black; font-size : 20px;">
                                @else
                                    <td valign="top" width="140px" style="background-color:#e4b236 ; text-align: right; border: 2px solid red; color:white; font-size : 20px;">
                                @endif
                                    {{ $row['date']; }}
                                    <br>
                                    <p style="font-size:14px;text-align:left;">
                                    {{ $row['title'] }}
                                    </p>
                                </td>
                            @endforeach
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</body>