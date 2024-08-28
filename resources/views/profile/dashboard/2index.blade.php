@extends('layouts.dashboard')

@section('content')
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 20px;
      text-align: center;
    }

    h1 {
      color: green;
    }

    canvas {
      border: 2px solid #858080;
    }
  </style>

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

  <div
    class="bg-white shadow-none drop-shadow-lg rounded-3xl mt-10 p-6 block justify-center items-center space-y-4 md:space-y-10 md:flex lg:flex lg:space-x-10">
    <div class="flex items-center space-x-8 mt-8 h-full">
      <div class="bg-gradient-to-b from-green-200 to-green-50 rounded-full w-16 h-16 flex items-center justify-center">
        <i class="fas fa-box fa-2x text-green-500"></i>
      </div>
      <div>
        <div class="text-[#272626]">Total Barang</div>
        <div class="text-2xl font-semibold text-gray-800"></div>
      </div>
    </div>

    <div class="border-r border-gray-200"></div>
    <div class="flex items-center space-x-8 h-full">
      <div class="bg-gradient-to-b from-green-200 to-green-50 rounded-full w-16 h-16 flex items-center justify-center">
        <i class="fa-solid fa-chart-line fa-2x text-green-600"></i>
      </div>
      <div>
        <div class="text-[#272626]">Total Transaksi</div>
        <div class="text-2xl font-semibold text-gray-800"></div>
      </div>
    </div>

    <div class="border-r border-gray-200"></div>

    <div class="flex items-center space-x-8 h-full">
      <div class="bg-gradient-to-b from-green-200 to-green-50 rounded-full w-16 h-16 flex items-center justify-center">
        <i class="fa-solid fa-dollar-sign fa-2x text-green-600"></i>
      </div>
      <div>
        <div class="text-[#272626] font-light text-[14px]">Total Pemasukan</div>
        <div class="text-2xl font-semibold text-gray-800"></div>
      </div>
    </div>
  </div>

  <?php
  $bulan = date('Y-m');
  
  if (isset($_GET['bulan'])) {
      $bulan = $_GET['bulan'];
  }
  ?>

  {{-- Chart --}}
  <div
    class="bg-white shadow-none drop-shadow-lg rounded-3xl mt-10 p-6 block justify-center items-center space-y-4 md:space-y-10 md:flex lg:flex lg:space-x-10">
    <canvas id="myBarChart" height="160" width="500">
    </canvas>
  </div>
  <script type="text/javascript">
    <?php
    $day = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    ?>
    var xValues = [
      <?php foreach($day as $data_day){ ?> '<?= htmlspecialchars($data_day) ?>',
      <?php } ?>
    ];
    var yValues = [
      <?php foreach($day as $data_day){ ?>

      <?php
      $log_pelanggan = DB::table('tb_pelanggan')
          ->join('tb_log_pelanggan', 'tb_log_pelanggan.id_pelanggan', '=', 'tb_pelanggan.id_pelanggan')
          ->where('tb_log_pelanggan.delete_log_pelanggan', '=', 'N')
          ->whereRaw('date_format(tb_log_pelanggan.tgl_log_pelanggan,\'%Y-%m\') = ? ', [$bulan])
          ->whereRaw('date_format(tb_log_pelanggan.tgl_log_pelanggan,\'%a\') = ? ', [$data_day])
          ->where('tb_log_pelanggan.id_pelanggan', '=', Session::get('id_pelanggan'))
          ->orderBy('tb_log_pelanggan.id_log_pelanggan', 'DESC')
          ->get();
      ?>

      <?= htmlspecialchars($log_pelanggan->count()) ?>,

      <?php } ?>
    ];

    new Chart("riwayat_akses", {
      type: "bar",
      data: {
        labels: xValues,
        datasets: [{
          label: "Jumlah",
          fill: false,
          backgroundColor: window.chartColors.blue,
          borderColor: window.chartColors.blue,
          data: yValues
        }]
      },
      options: {
        responsive: true,
        legend: {
          display: false
        },
        tooltips: {
          mode: 'index',
          intersect: false,
        },
        hover: {
          mode: 'nearest',
          intersect: true
        }
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
