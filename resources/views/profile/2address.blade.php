@extends('layouts.app')

@section('content')
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

                    <label>State</label>
                    <select name="status" class="form-control" required>
                      @foreach (['Home', 'Office'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                      @endforeach
                    </select></br>

                    <div class="form-group">
                      <label>Location Google Maps</label>
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script type="text/javascript">
    function initMap() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: {
          lat: -6.1815249,
          lng: 106.3924981
        },
        zoom: 7,
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var input = document.getElementById("location");
      var searchBox = new google.maps.places.SearchBox(input);
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
      });

      searchBox.addListener("places_changed", function() {
        var places = searchBox.getPlaces();
        if (places.length === 0) return;

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
          if (!place.geometry) return;

          var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location
          });

          if (place.geometry.viewport) {
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }

          document.getElementById('lat').value = place.geometry.location.lat();
          document.getElementById('long').value = place.geometry.location.lng();
        });
        map.fitBounds(bounds);
      });

      map.addListener('click', function(event) {
        var marker = new google.maps.Marker({
          position: event.latLng,
          map: map
        });
        document.getElementById("lat").value = event.latLng.lat();
        document.getElementById("long").value = event.latLng.lng();
      });
    }

    // Add script tag for Google Maps API with async and defer
    document.addEventListener("DOMContentLoaded", function() {
      var script = document.createElement('script');
      script.src = "https://maps.googleapis.com/maps/api/js?key=YOUR_VALID_API_KEY&libraries=places&callback=initMap";
      script.async = true;
      script.defer = true;
      document.head.appendChild(script);
    });
  </script>
@endsection
