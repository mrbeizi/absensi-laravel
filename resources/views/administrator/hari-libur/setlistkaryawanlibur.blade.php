<div class="row">
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="loadlist"></tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        function loadlist() {
            var kode_libur = "{{$kode_libur}}";
            $('#loadlist').load('/hari-libur/setharilibur/'+ kode_libur +'/getlistkaryawan');
        }
        loadlist();
    });
</script>