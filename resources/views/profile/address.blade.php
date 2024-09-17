@extends('layouts.app')

@section('content')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <section class="section section-white"
    style="position: relative; overflow: hidden; padding-top: 100px; padding-bottom: 20px;">
    <div
      style="background-image: url('{{ url('logos/wallpaper.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; background-repeat: no-repeat; position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0;">
    </div>
    <div class="bg-white" style="position: absolute; width: 100%; top: 0; bottom: 0; left: 0; right: 0; opacity: 0.7;">
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-12" align="center">
          <h4 class="text-primary">Add New Address</h4>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-white" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6" align="center">
                  <img src="{{ asset('logos/add.png') }}" style="max-width: 70%;">
                </div>
                <div class="col-md-6">
                  <form method="POST" enctype="multipart/form-data" action="{{ route('address.save') }}">
                    @csrf
                    <!-- input fields -->
                    <label>City</label>
                    <select name="kota" class="form-control" required>
                      @php
                        $kota = DB::table('tb_kota')
                            ->join('tb_provinsi', 'tb_kota.id_provinsi', '=', 'tb_provinsi.id_provinsi')
                            ->where('tb_kota.delete_kota', '=', 'N')
                            ->orderBy('tb_kota.nama_kota', 'ASC')
                            ->get();
                      @endphp
                      @if ($kota->isEmpty())
                        <option value="">- Data not found -</option>
                      @else
                        @foreach ($kota as $data_kota)
                          <option value="{{ $data_kota->id_kota }}">{{ $data_kota->nama_kota }}</option>
                        @endforeach
                      @endif
                    </select><br>

                    <label>Address</label>
                    <textarea name="nama" class="form-control" required placeholder="Required ..."></textarea><br>

                    <label>Pos Code</label>
                    <input type="number" name="kodepos" class="form-control" required placeholder="Required ..."><br>

                    <label>Status</label>
                    <select name="status" class="form-control" required>
                      @foreach (['Home', 'Office'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                      @endforeach
                    </select></br>

                    <div class="form-group">
                      <label>Location</label>
                      <input type="text" name="lokasi" id="location" required placeholder="Find Location ..."
                        style="width: 90%; border-radius: 5px; border: 1px solid lightgrey; padding: 5px 15px; margin: 15px;">
                      <div id="map" style="width: 100%; height: 300px; margin: 0px; border-radius: 5px;"></div>
                    </div>

                    <div class="form-group has-info">
                      <label>Latitude</label>
                      <input type="text" name="lat" id="lat" class="form-control" readonly required>
                    </div>

                    <div class="form-group has-info">
                      <label>Longitude</label>
                      <input type="text" name="long" id="long" class="form-control" readonly required>
                    </div></br>
                    <a href="../profile?visit=&page=profile" class="btn btn-sm btn-warning" id="kembali"> Back</a>

                    <button type="submit" class="btn btn-sm btn-success">
                      Done
                    </button>
                  </form>
                  @if ($errors->any())
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script type="text/javascript">
    function initLeafletMap() {
      var map = L.map('map').setView([-6.1815249, 106.3924981], 7);

      // Add the OpenStreetMap tiles
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap'
      }).addTo(map);

      var marker;

      // Set up event listener for map clicks to place the marker
      map.on('click', function(e) {
        if (marker) {
          map.removeLayer(marker); // Remove previous marker
        }

        marker = L.marker(e.latlng).addTo(map); // Add a new marker
        document.getElementById("lat").value = e.latlng.lat; // Update the lat input
        document.getElementById("long").value = e.latlng.lng; // Update the long input
      });

      // Handle form submission with preset latitude and longitude
      var latInput = document.getElementById("lat");
      var lngInput = document.getElementById("long");

      if (latInput.value && lngInput.value) {
        var presetLatLng = L.latLng(latInput.value, lngInput.value);
        marker = L.marker(presetLatLng).addTo(map);
        map.setView(presetLatLng, 13);
      }
    }

    // Initialize Leaflet map when the document is ready
    document.addEventListener("DOMContentLoaded", function() {
      initLeafletMap();
    });
  </script>

@endsection
