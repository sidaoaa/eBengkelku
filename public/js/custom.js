function show(value) {
    document.getElementById('loader').style.display = value ? 'block' : 'none';
}

function loadPage(URL) {
    show(true);
    location = URL;
}

function newTab(URL) {
    window.open(URL, '_blank');
}

setTimeout(function() {
    show(false);
}, 2000);

function copyLink() {
    const link = window.location.href;
    navigator.clipboard.writeText(link).then(() => {
      alert('Profile link copied to clipboard!');
    });
  }



    function editAddress(address) {
        document.getElementById('addressForm').action = "{{ route('address.update') }}";
        document.getElementById('address_id').value = address.id_alamat_pengiriman;
        document.getElementById('nama').value = address.nama_alamat_pengiriman;
        document.getElementById('kodepos').value = address.kodepos_alamat_pengiriman;
        document.getElementById('lat').value = address.lat_alamat_pengiriman;
        document.getElementById('long').value = address.long_alamat_pengiriman;
        document.getElementById('lokasi').value = address.lokasi_alamat_pengiriman;
        document.getElementById('kota').value = address.id_kota;
        document.getElementById('status').value = address.status_alamat_pengiriman;
    }

