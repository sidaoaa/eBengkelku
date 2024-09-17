@extends('layouts.dashboard')

@section('content')
  @if (session('success'))
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          confirmButtonColor: "#3085d6",
          text: '{{ session('success') }}'
        });
      });
    </script>
  @endif

  <div class="mt-8">
    <div class="flex justify-center">
      <div class="w-full bg-white shadow-lg rounded-lg">
        <div class="p-6">
          <h2 class="text-2xl font-bold mb-6 text-center">Add New Workshop</h2>

          <div class="flex flex-wrap">
            <div class="w-full flex justify-center items-center">
              <img src="{{ url('logos/add.png') }}" class="max-w-52">
            </div>

            <div class="w-full">
              <form method="POST" action="{{ route('workshop_seller.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                  <label class="block text-lg font-medium text-gray-700" for="nama_bengkel">Workshop
                    Name</label>
                  <div class="text-red-500 text-sm">
                    @error('nama_bengkel')
                      {{ $message }}
                    @enderror
                  </div>
                  <input type="text" name="nama_bengkel" id="nama_bengkel"
                    class="mt-1 block w-full px-3 py-2  border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    required maxlength="255" placeholder="Required ...">
                </div>

                <div class="mb-4">
                  <label class="block text-lg font-medium text-gray-700" for="tagline_bengkel">Tagline</label>
                  <div class="text-red-500 text-sm">
                    @error('nama_bengkel')
                      {{ $message }}
                    @enderror
                  </div>
                  <input type="text" name="tagline_bengkel" id="tagline_bengkel"
                    class="mt-1 block w-full px-3 py-2  border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    required maxlength="255" placeholder="Required ...">
                </div>

                <div class="mb-4 flex items-start space-x-5">
                  <!-- Upload Image -->
                  <div>
                    <label class="block text-lg font-medium text-gray-700">Upload Image</label>
                    <div class="text-red-500 text-sm">
                      @error('nama_bengkel')
                        {{ $message }}
                      @enderror
                    </div>
                    <label for="foto_bengkel" class="cursor-pointer">
                      <img src="{{ url('logos/image.png') }}" id="image-1" class="w-44 rounded-md">
                      <input type="file" accept="image/*" name="foto_bengkel" id="foto_bengkel" class="hidden"
                        onchange="previewImage('image-1', 'foto_bengkel')">
                    </label>
                  </div>

                  <!-- Upload Cover Image -->
                  <div>
                    <label class="block text-lg font-medium text-gray-700">Upload Cover Image</label>
                    <div class="text-red-500 text-sm">
                      @error('nama_bengkel')
                        {{ $message }}
                      @enderror
                    </div>
                    <label for="foto_cover_bengkel" class="cursor-pointer">
                      <img src="{{ url('logos/image.png') }}" id="image-2" class="w-44 rounded-md">
                      <input type="file" accept="image/*" name="foto_cover_bengkel" id="foto_cover_bengkel"
                        class="hidden" onchange="previewImage('image-2', 'foto_cover_bengkel')">
                    </label>
                  </div>
                </div>

                <div class="mb-4">
                  <label class="block text-lg font-medium text-gray-700" for="alamat_bengkel">Address
                    Workshop</label>
                  <div class="text-red-500 text-sm">
                    @error('nama_bengkel')
                      {{ $message }}
                    @enderror
                  </div>
                  <textarea name="alamat_bengkel" id="alamat_bengkel"
                    class="mt-1 block w-full px-3 py-4 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    required placeholder="Required ..."></textarea>
                </div>

                <div class="mb-4">
                  <label class="block text-lg font-medium text-gray-700" for="kodepos_bengkel">Pos
                    Code</label>
                  <div class="text-red-500 text-sm">
                    @error('nama_bengkel')
                      {{ $message }}
                    @enderror
                  </div>
                  <input type="text" name="kodepos_bengkel" id="kodepos_bengkel"
                    class="mt-1 block w-full px-3 py-2  border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    required maxlength="255" placeholder="Required ...">
                </div>
                <div class="mb-4">
                  <label class="block text-lg font-medium text-gray-700" for="whatsapp">WhatsApp</label>
                  <div class="text-red-500 text-sm">
                    @error('nama_bengkel')
                      {{ $message }}
                    @enderror
                  </div>
                  <input type="text" name="whatsapp" id="whatsapp"
                    class="mt-1 block w-full px-3 py-2  border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    required maxlength="255" placeholder="Paste Link Here ...">
                </div>
                <div class="mb-4">
                  <label class="block text-lg font-medium text-gray-700" for="tiktok">Medsos Tiktok</label>
                  <div class="text-red-500 text-sm">
                    @error('nama_bengkel')
                      {{ $message }}
                    @enderror
                  </div>
                  <input type="text" name="tiktok" id="tiktok"
                    class="mt-1 block w-full px-3 py-2  border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    required maxlength="255" placeholder="Paste Link Here ...">
                </div>
                <div class="mb-4">
                  <label class="block text-lg font-medium text-gray-700" for="instagram">Medsos Instagram</label>
                  <div class="text-red-500 text-sm">
                    @error('nama_bengkel')
                      {{ $message }}
                    @enderror
                  </div>
                  <input type="text" name="instagram" id="instagram"
                    class="mt-1 block w-full px-3 py-2  border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    required maxlength="255" placeholder="Paste Link Here ...">
                </div>
                <div class="mb-4">
                  <label class="block text-lg font-medium text-gray-700" for="open_time">
                    Open Time
                  </label>
                  <div class="text-red-500 text-sm">
                    @error('open_time')
                      {{ $message }}
                    @enderror
                  </div>
                  <input type="time" name="open_time" id="open_time"
                    class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    required placeholder="Select time ...">
                </div>

                <!-- Close Time -->
                <div class="mb-4">
                  <label class="block text-lg font-medium text-gray-700" for="close_time">
                    Close Time
                  </label>
                  <div class="text-red-500 text-sm">
                    @error('close_time')
                      {{ $message }}
                    @enderror
                  </div>
                  <input type="time" name="close_time" id="close_time"
                    class="mt-1 block w-full px-3 py-2 border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                    required placeholder="Select time ...">
                </div>

                {{-- <div class="mb-4">
                                    <label class="block text-lg font-medium text-gray-700" for="lokasi_bengkel">Location
                                        Google Maps</label>
                                    <input type="text" name="lokasi_bengkel" id="lokasi_bengkel"
                                        class="mt-1 block w-full px-3 py-2  border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                        required placeholder="Find Location ...">
                                    <div id="map" class="mt-2 w-full h-80 rounded-md  border-gray-300"></div>
                                </div>

                                <input type="hidden" name="lat_bengkel" id="lat_bengkel" required>
                                <input type="hidden" name="long_bengkel" id="long_bengkel" required> --}}

                <div class="flex justify-between mt-6 font-medium text-sm">
                  <button type="button"
                    class="bg-yellow-400 text-white font-bold py-2 px-4 rounded hover:bg-yellow-500" id="kembali">
                    <i class='bx bx-arrow-back'></i> Back
                  </button>

                  <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">
                    <i class='bx bx-check-double'></i> Done
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Include Google Maps API -->
  {{-- <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQJVneS_3wPUDDgXk9jAb8dNG50aToLEA&libraries=places&callback=initMap"
        async defer></script> --}}

  <script type="text/javascript">
    // var markers = [];
    // var marker;

    // function taruhMarker(peta, posisiTitik) {
    //     marker.setPosition(posisiTitik);
    //     document.getElementById("lat").value = posisiTitik.lat();
    //     document.getElementById("long").value = posisiTitik.lng();
    // }

    function previewImage(imageId, inputId) {
      const file = document.getElementById(inputId).files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById(imageId).src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    }

    // function initMap() {
    //     var map = new google.maps.Map(document.getElementById("map"), {
    //         center: {
    //             lat: -6.1815249,
    //             lng: 106.3924981
    //         },

    //         zoom: 7,
    //         disableDefaultUI: true,
    //         mapTypeId: google.maps.MapTypeId.ROADMAP
    //     });

    //     var input = document.getElementById("location");
    //     var searchBox = new google.maps.places.SearchBox(input);
    //     map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    //     map.addListener('bounds_changed', function() {
    //         searchBox.setBounds(map.getBounds());
    //     });

    //     var markers = [];

    //     searchBox.addListener("places_changed", function() {
    //         var places = searchBox.getPlaces();

    //         if (places.length == 0) {
    //             return;
    //         }

    //         markers.forEach(function(marker) {
    //             marker.setMap(null);
    //         });

    //         markers = [];

    //         var bounds = new google.maps.LatLngBounds();

    //         places.forEach(function(place) {

    //             var icon = {
    //                 url: place.icon,
    //                 size: new google.maps.Size(71, 71),
    //                 origin: new google.maps.Point(0, 0),
    //                 anchor: new google.maps.Point(17, 34),
    //                 scaledSize: new google.maps.Size(25, 25)
    //             };

    //             markers.push(new google.maps.Marker({
    //                 map: map,
    //                 title: place.name,
    //                 position: place.geometry.location
    //             }));

    //             if (place.geometry.viewport) {
    //                 bounds.union(place.geometry.viewport);
    //             } else {
    //                 bounds.extend(place.geometry.location);
    //             }

    //             $('#lat').val(place.geometry.location.lat());
    //             $('#long').val(place.geometry.location.lng());
    //         });

    //         map.fitBounds(bounds);

    //         google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
    //             this.setZoom(15);
    //         });
    //     });
    //     google.maps.event.addListener(map, 'click', function(event) {

    //         taruhMarker(this, event.latLng);
    //     });
    // }
  </script>
@endsection
