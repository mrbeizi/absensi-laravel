<form action="/data-user/{{ $user->id }}/update" method="POST" id="formUser">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                </span>
                <input type="text" value="{{$user->name}}" name="name" id="name" class="form-control" placeholder="Nama User">
            </div>
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-at"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0v-1.5a9 9 0 1 0 -5.5 8.28" /></svg>
                </span>
                <input type="text" value="{{$user->email}}" name="email" id="email" class="form-control" placeholder="Alamat email">
            </div>
            <div class="input-icon mb-3">                                        
                <select name="kode_dept" id="kode_dept" class="form-select">
                    <option value="">- Pilih Departemen -</option>
                    @foreach ($department as $d)
                        <option value="{{$d->kode_dept}}" {{ $d->kode_dept == $user->kode_dept ? 'selected' : '' }}>{{$d->nama_dept}}</option>
                    @endforeach
                </select>
            </div>                        
            <div class="input-icon mb-3">                                        
                <select name="role" id="role" class="form-select">
                    <option value="">- Pilih Role -</option>
                    @foreach ($roles as $r)
                        <option value="{{$r->id}}" {{ $r->id == $user->role_id ? 'selected' : '' }}>{{$r->name}}</option>
                    @endforeach
                </select>
            </div>  
            <div class="input-icon mb-3">                                        
                <select name="kode_cabang" id="kode_cabang" class="form-select">
                    <option value="">- Pilih Kantor -</option>
                    @foreach ($cabang as $c)
                        <option value="{{$c->kode_cabang}}" {{ $c->kode_cabang == $user->kode_cabang ? 'selected' : '' }}>{{$c->nama_cabang}}</option>
                    @endforeach
                </select>
            </div>  
            <div class="form-group">
                <button class="btn btn-primary float-end"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>update</button>
            </div>
        </div>
    </div>    
</form>