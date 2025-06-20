@foreach ($datas as $item)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{date("d-m-Y", strtotime($item->tanggal))}}</td>
        <td>{{$item->nama_jam_kerja}}</td>
        <td>
            <a href="#" class="confirm-delete text-danger" nik="{{$item->nik}}" tanggal="{{$item->tanggal}}">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
            </a> 
        </td>
    </tr>
@endforeach
<script>
    $(function(){
        function loadjamkerjapertanggal(){
            var nik = "{{$nik}}";
            var bulan = "{{$bulan}}";
            var tahun = "{{$tahun}}";
            $('#loadjamkerjapertanggal').load('/jamkerja/'+nik+'/'+bulan+'/'+tahun+'/show');
        };

        $('.confirm-delete').click(function(e){
            e.preventDefault();
            var nik = $(this).attr('nik');
            var tanggal = $(this).attr('tanggal');
            $.ajax({
                type: "POST",
                url: "{{route('hapuspertanggal')}}",
                data: {
                    _token: "{{csrf_token()}}",
                    nik:nik,
                    tanggal:tanggal
                },
                cache:false,
                success: function(respond){
                    if(respond == 1) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Data berhasil dihapus!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            timer: 1500
                        }).then((result) => {
                            loadjamkerjapertanggal();
                        });
                    } else if(respond == 0) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menghapus data!',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            timer: 1500
                        });
                    }
                }
            });
        });
    });
</script>