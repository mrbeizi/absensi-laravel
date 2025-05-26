<style>
    #map {
        height: 180px;
    }
</style>
<div id="map"></div>
<script>
    var lokasi = "{{ $presensi->location_in }}";
    var lok = lokasi.split(",");
    var lat = lok[0];
    var long = lok[1];
    var map = L.map('map').setView([lat, long], 17);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    var marker = L.marker([lat, long]).addTo(map);
    var circle = L.circle([1.141649,104.042440], { // lokasi kantor yang sama pada presensi.index (folder->file)
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 80
    }).addTo(map);

    var popup = L.popup()
        .setLatLng([lat, long])
        .setContent("{{$presensi->nama_lengkap}}")
        .openOn(map);
</script>