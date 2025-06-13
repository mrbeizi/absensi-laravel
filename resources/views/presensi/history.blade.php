@extends('layouts.resources')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">History</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="row" style="margin-top: 4rem;">
        <div class="col">
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
                    <button class="btn btn-primary btn-sm w-100" id="button-search"><ion-icon name="search-outline"></ion-icon> Cari</button>
                </div>
            </div>
        </div>
    </div>  
    <div class="row" style="position: fixed; width: 100%; margin: auto; overflow-y: scroll; height: 620px;">
        <div class="col" id="showHistory"></div>
    </div>  
@endsection

@push('myscript')
    <script>
        $(function(){
            $('#button-search').click(function(e){
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();
                $.ajax({
                    type: 'POST',
                    url: '/get-history',
                    data:{
                        _token: "{{csrf_token()}}",
                        bulan: bulan,
                        tahun: tahun,
                    },
                    cache: false,
                    success: function(respond){
                        $('#showHistory').html(respond);
                    }
                });
            });
        });
    </script>
@endpush