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
                                        {{ $row['date']; }}
                                        <a href="#" data-toggle="modal" data-tanggal="{{ $row['tanggal']; }}" data-target="#exampleModal" class="button-tanggal">
                                            <div style="padding-top:80px;;height:100%;width:100%;text-align:center;margin:auto;vertical-align: middle;display: inline-block;">
                                                
                                            </div>
                                        </a>
                                @else
                                    <td valign="top" width="140px" style="background-color:#e4b236 ; text-align: right; border: 2px solid red; color:white; font-size : 20px;">
                                        {{ $row['date']; }}
                                        <br>
                                        <p style="font-size:14px;text-align:left;">
                                        {{ $row['title'] }}
                                        </p>
                                @endif
                                    </td>
                            @endforeach
                        </tr>
                        
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('/detail.js') }}"></script>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <form action="#" id="formJadwal" method="POST" class="form-validate is-alter">
                <div class="modal-body">
                    <input type="hidden" name="tanggal" id="idTanggal">
                    <input type="hidden" nama="id_room" value="{{ $room->id; }}">
                    <div class="form-group">
                        <label for="" style="padding-bottom:6px;">Dekripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>