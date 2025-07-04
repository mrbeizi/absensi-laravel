@extends('layouts.resources')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->

    <style>
        .historicontent{
            display: flex;
        }
        .dataizin {
            margin-left: 10px;
        }
        .dataizin h3 {
            line-height: 3px;
        }
        #statusizin {
            position: absolute;
            right: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="row" style="margin-top: 5rem;">
        <div class="col ml-2 mr-2 mb-1">
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{Session::get('success')}}
                </div>                
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{Session::get('error')}}
                </div>                
            @endif
            @if (Session::get('warning'))
                <div class="alert alert-warning">
                    {{Session::get('warning')}}
                </div>                
            @endif
        </div>        
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="{{route('presensi-izin')}}" method="GET">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <select name="bulan" id="bulan" class="form-select custom-select">
                                    <option value="">Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option {{Request('bulan') == $i ? 'selected' : ''}} value="{{$i}}">{{$monthName[$i]}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <select name="tahun" id="tahun" class="form-select custom-select">
                                    <option value="">Tahun</option>
                                    @for ($year = 2022; $year <= date('Y'); $year++)
                                        <option {{Request('tahun') == $year ? 'selected' : ''}} value={{$year}}>{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <button class="btn btn-primary btn-sm w-100"><ion-icon name="search-outline"></ion-icon> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row" style="position: fixed; width: 100%; margin: auto; overflow-y: scroll; height: 600px;">
        <div class="col ml-2 mr-2">
            @foreach($datas as $data)
            <div class="card mb-1 card_izin" kodeizin="{{$data->kode_izin}}" statusapproved="{{$data->status_approved}}" data-toggle="modal" data-target="#actionSheetIconed">
                <div class="card-body">
                    <div class="historicontent">
                        <div class="iconpresensi">
                            @if($data->status == "i")
                            <ion-icon name="document-text-outline" role="img" class="md hydrated text-primary" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                            @elseif($data->status == "s")
                            <ion-icon name="medkit-outline" role="img" class="md hydrated text-danger" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                            @else
                            <ion-icon name="calendar-outline" role="img" class="md hydrated text-info" aria-label="finger print" style="font-size: 38px;"></ion-icon>
                            @endif
                        </div>
                        <div class="dataizin">
                            <h3>{{date("d-m-Y", strtotime($data->tgl_izin_dari))}} ({{ ($data->status == "i") ? "Izin" : (($data->status == "s") ? "Sakit" : (($data->status == "c") ? "Cuti" : "Data not found")) }})</h3>
                            <small>{{date("d-m-Y", strtotime($data->tgl_izin_dari))}} s.d {{date("d-m-Y", strtotime($data->tgl_izin_sampai))}}</small>
                            <p>{{$data->keterangan}}<br>
                                @if($data->status == "c")
                                <span class="badge bg-info">{{$data->nama_cuti}}</span>
                                @endif
                                @if(!empty($data->docs_sid))
                                <small class="text-primary"><ion-icon name="document-attach-outline"></ion-icon> Lihat SID</small>
                                @endif</p>
                        </div>
                        <div class="mt-2" id="statusizin">
                            @if($data->status_approved == 0)
                            <span class="badge badge-warning">Pending</span>
                            @elseif($data->status_approved == 1)
                            <span class="badge badge-success">Approved</span>
                            @else
                            <span class="badge badge-danger">Rejected</span>
                            @endif
                            <p style="margin-top: 5px; font-weight: bold;">{{countDay($data->tgl_izin_dari,$data->tgl_izin_sampai)}} Hari</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="fab-button animate bottom-right dropdown" style="margin-bottom: 70px;">
        <a href="#" class="fab bg-primary" data-toggle="dropdown">
            <ion-icon name="add-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </a>
        <div class="dropdown-menu">
            <a href="{{route('index-izinabsen')}}" class="dropdown-item bg-primary">
                <ion-icon name="document-outline" role="img" class="md hydrated" aria-label="image outline"></ion-icon>
                <p>Izin Absen</p>
            </a>
            <a href="{{route('index-izinsakit')}}" class="dropdown-item bg-primary">
                <ion-icon name="document-outline" role="img" class="md hydrated" aria-label="videocam outline"></ion-icon>
                <p>Sakit</p>
            </a>
            <a href="{{route('index-izincuti')}}" class="dropdown-item bg-primary">
                <ion-icon name="document-outline" role="img" class="md hydrated" aria-label="videocam outline"></ion-icon>
                <p>Cuti</p>
            </a>
        </div>
    </div>

    <div class="modal fade action-sheet" id="actionSheetIconed" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">AKSI</h5>
                </div>
                <div class="modal-body" id="showact">
    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade dialogbox" id="deleteConfirm" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yakin Dihapus ?</h5>
                </div>
                <div class="modal-body">
                    Data Pengajuan Izin Akan dihapus
                </div>
                <div class="modal-footer">
                    <div class="btn-inline">
                        <a href="#" class="btn btn-text-secondary" data-dismiss="modal">Batalkan</a>
                        <a href="" class="btn btn-text-primary" id="hapuspengajuan">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
@push('myscript')
    <script>
        $(function(){
          $('.card_izin').click(function(e){
            var kode_izin = $(this).attr("kodeizin");
            var status_approved = $(this).attr("statusapproved");
            if(status_approved == 1){
                Swal.fire({
                    title: 'Oops!',
                    text: 'Can not revert the state!',
                    icon: 'warning',
                    timer: 1500
                })
            } else {
                $('#showact').load('/izin/'+kode_izin+'/showact');
            }
          });
        });
    </script>
@endpush