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
            <form action="/detail/{{ $room->id; }}" method="GET">
                <select name="bulan" id="bulan">
                    <option value="">Pilih Bulan</option>
                    <option value="01" {{ (date('m') == 1) ? 'selected' : '' }}>Januari</option>
                    <option value="02" {{ (date('m') == 2) ? 'selected' : '' }}>Februari</option>
                    <option value="03" {{ (date('m') == 3) ? 'selected' : '' }}>Maret</option>
                    <option value="04" {{ (date('m') == 4) ? 'selected' : '' }}>April</option>
                    <option value="05" {{ (date('m') == 5) ? 'selected' : '' }}>Mei</option>
                    <option value="06" {{ (date('m') == 6) ? 'selected' : '' }}>Juni</option>
                    <option value="07" {{ (date('m') == 7) ? 'selected' : '' }}>Juli</option>
                    <option value="08" {{ (date('m') == 8) ? 'selected' : '' }}>Agustus</option>
                    <option value="09" {{ (date('m') == 9) ? 'selected' : '' }}>September</option>
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
            </form>
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
                                    @if($row['hari'] == "Sun") 
                                        @if($row['tanggal'] ==  date('Y-m-d'))
                                            <td valign="top" width="140px" style="text-align: right; border: 6px solid red; color:black; font-size : 20px;">
                                        @else
                                            <td valign="top" width="140px" style="text-align: right; border: 2px solid red; color:black; font-size : 20px;">
                                        @endif
                                    @else
                                        @if($row['tanggal'] ==  date('Y-m-d'))
                                        <td valign="top" width="140px" style="text-align: right; border: 6x solid black; color:black; font-size : 20px;">
                                        @else
                                        <td valign="top" width="140px" style="text-align: right; border: 2px solid black; color:black; font-size : 20px;">
                                        @endif
                                    @endif
                                        {{ $row['date']; }}
                                        <a href="#" data-toggle="modal" data-tanggal="{{ $row['tanggal']; }}" data-target="#exampleModal" class="button-tanggal">
                                            <div style="padding-top:80px;;height:100%;width:100%;text-align:center;margin:auto;vertical-align: middle;display: inline-block;">
                                                
                                            </div>
                                        </a>
                                @else
                                    @if($row['hari'] == "Sun")
                                        @if($row['tanggal'] ==  date('Y-m-d'))
                                            <td valign="top" width="140px" style="background-color:red ; text-align: right; border: 6px solid #853435; color:WHITE; font-size : 20px;">
                                        @else
                                            <td valign="top" width="140px" style="background-color:red ; text-align: right; border: 2px solid #853435; color:white; font-size : 20px;">
                                        @endif
                                    @else
                                        @if($row['tanggal'] ==  date('Y-m-d'))
                                        <td valign="top" width="140px" style="background-color:#e4b236 ; text-align: right; border: 6px solid black; color:white; font-size : 20px;">
                                        @else
                                        <td valign="top" width="140px" style="background-color:#e4b236 ; text-align: right; border: 2px solid black; color:white; font-size : 20px;">
                                        @endif
                                    @endif
                                        {{ $row['date']; }}
                                        <a href="#" onclick="hapusJadwal({{ $row['id_jadwal']; }})" class="button-tanggal" style="color:#ffffff">
                                            <div style="padding-top:0px;;height:100%;width:100%;text-align:center;margin:auto;vertical-align: middle;display: inline-block;">
                                                <p style="font-size:14px;text-align:left;">
                                                {{ $row['title'] }}
                                                </p>
                                            </div>
                                        </a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <input type="hidden" name="id_room" value="{{ $room->id; }}">
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