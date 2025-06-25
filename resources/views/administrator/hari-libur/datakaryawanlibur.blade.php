@foreach ($karyawan as $item)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$item->nik}}</td>
        <td>{{$item->nama_lengkap}}</td>
        <td>{{$item->jabatan}}</td>
        <td>
            <a href="#" class="hapuskaryawanlibur" nik="{{$item->nik}}">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
            </a>
        </td>
    </tr>
@endforeach
<script>
    $(function(){
        function loadlistkaryawan() {
            var kode_libur = "{{$kode_libur}}";
            $('#loadlistkaryawan').load('/hari-libur/setharilibur/'+ kode_libur +'/getkaryawanlibur');
        }

        $('.hapuskaryawanlibur').click(function(e){
            var kode_libur = "{{$kode_libur}}";
            var nik = $(this).attr('nik');
            $.ajax({
                type: "POST",
                url: "{{route('hapus-karyawan-libur')}}",
                data:{
                    _token: "{{csrf_token()}}",
                    kode_libur:kode_libur,
                    nik:nik

                },
                cache:false,
                success: function(respond){
                    if(respond === '1') {
                        Swal.fire({
                            title: 'Good!',
                            text: 'Karyawan berhasil dihapus!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            timer: 1500
                        });
                        loadlistkaryawan();
                    } else if(respond === "exist") {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Data sudah ditambahkan!',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            title: 'Oops!',
                            text: respond,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            timer: 1500
                        });
                    }
                }
            });
        });
    });
</script>