<ul class="action-button-list">
    <li>
        @if($dataizin->status == "i")
        <a href="{{route('edit-izinabsen', ['kode_izin' => $dataizin->kode_izin])}}"  class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit
            </span>
        </a>
        @elseif($dataizin->status == "s")
        <a href="{{route('edit-izinsakit', ['kode_izin' => $dataizin->kode_izin])}}"  class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit
            </span>
        </a>
        @elseif($dataizin->status == "c")
        <a href="{{route('edit-izincuti', ['kode_izin' => $dataizin->kode_izin])}}"  class="btn btn-list text-primary">
            <span>
                <ion-icon name="create-outline"></ion-icon>
                Edit
            </span>
        </a>
        @endif
    </li>
    <li>
        <a href="#" id="deletebutton" class="btn btn-list text-danger" data-dismiss="modal" data-toggle="modal" data-target="#DialogBasic">
            <span>
                <ion-icon name="trash-outline"></ion-icon>
                Delete
            </span>
        </a>
    </li>
</ul>