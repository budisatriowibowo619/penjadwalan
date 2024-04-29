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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- End CSS -->
    
</head>

<body>

    <a href="/logout" class="float" title="Logout">
        <i class="fas fa-sign-out-alt my-float"></i>
    </a>

    <button class="float-left" title="Kembali" onclick="history.back()">
        <i class="fas fa-arrow-left my-float-left"></i>
    </button>

    <div class="container">

        <div class="room-title">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <h1>{{ $room->room; }}</h1>
                    <form action="/pageRoom/{{ $room->slug; }}" method="GET">
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
                </div>
                <div class="col-md-4" style="text-align:right !important;">
                    {{-- <a href="/logout" class="btn btn-danger" style="color:white;">Logout</a> --}}
                </div>
            </div>
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
                                @if(empty($row['description']))
                                    @if($row['hari'] == "Sun") 
                                        @if($row['tanggal'] ==  date('Y-m-d'))
                                            <td valign="top" width="150px" style="text-align: right; border: 6px solid red; color:black; font-size : 20px;">
                                        @else
                                            <td valign="top" width="150px" style="text-align: right; border: 2px solid red; color:black; font-size : 20px;">
                                        @endif
                                    @else
                                        @if($row['tanggal'] ==  date('Y-m-d'))
                                        <td valign="top" width="150px" style="text-align: right; border: 6px solid black !important; color:black; font-size : 20px;">
                                        @else
                                        <td valign="top" width="150px" style="text-align: right; border: 2px solid black; color:black; font-size : 20px;">
                                        @endif
                                    @endif
                                        {{ $row['date']; }}
                                        <a href="#" class="button-tanggal">
                                            <div style="padding-top:80px;;height:100%;width:100%;text-align:center;margin:auto;vertical-align: middle;display: inline-block;">
                                                
                                            </div>
                                        </a>
                                @else
                                    @if($row['hari'] == "Sun")
                                        @if($row['tanggal'] ==  date('Y-m-d'))
                                            <td valign="top" width="150px" style="background-color:red ; text-align: right; border: 6px solid #853435; color:WHITE; font-size : 20px;">
                                        @else
                                            <td valign="top" width="150px" style="background-color:red ; text-align: right; border: 2px solid red; color:white; font-size : 20px;">
                                        @endif
                                    @else
                                        @if($row['tanggal'] ==  date('Y-m-d'))
                                        <td valign="top" width="150px" style="background-color:#e4b236 ; text-align: right; border: 6px solid black; color:white; font-size : 20px;">
                                        @else
                                        <td valign="top" width="150px" style="background-color:#e4b236 ; text-align: right; border: 2px solid black; color:white; font-size : 20px;">
                                        @endif
                                    @endif
                                        {{ $row['date']; }}
                                        <a href="#" onclick="showPreviewPenjadwalan({{ $row['id_jadwal']; }})" class="button-tanggal" style="color:#ffffff">
                                            <div style="padding-top:0px;;height:100%;width:100%;text-align:center;margin:auto;vertical-align: middle;display: inline-block;">
                                                <p style="font-size:14px;text-align:left;">
                                                    <b>{{ $row['client'] }}</b>
                                                    <br>
                                                    {{ $row['description'] }}
                                                    <br>
                                                    {{ $row['tanggal_full'] }}
                                                    <br>
                                                    {{ $row['jam_full'] }}
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
<script src="{{ asset('/detail_sales.js') }}"></script>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Data Jadwal</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <form action="#" id="formJadwal" method="POST" class="form-validate is-alter">
                <div class="modal-body">
                    <input type="hidden" name="tanggal" id="idTanggal">
                    <input type="hidden" name="id_room" value="{{ $room->id; }}">
                    <div class="form-group">
                        <label for="" style="padding-bottom:6px;">Tanggal</label>
                        <input type="text" name="tgl" id="inputTanggal" class="form-control" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="" style="padding-bottom:6px;">Sales In Charge</label>
                        <input type="text" name="klien" id="inputSales" class="form-control" placeholder="Sales In Charge" required>
                    </div>
                    {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" style="padding-bottom:6px;">Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="" style="padding-bottom:6px;">Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="form-control" required>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <label for="" style="padding-bottom:6px;">Dekripsi</label>
                        <textarea id="inputDeskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnClose">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>