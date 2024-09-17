@extends('layouts.dashboard')

@section('content')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
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
            <div
                class="bg-gradient-to-b from-green-200 to-green-50 rounded-full w-16 h-16 flex items-center justify-center">
                <i class="fa-solid fa-dollar-sign fa-2x text-green-600"></i>
            </div>
            <div>
                <div class="text-[#272626] font-light text-[14px]">Total Pemasukan</div>
                <div class="text-2xl font-semibold text-gray-800"></div>
            </div>
        </div>
    </div>


    {{-- Chart --}}
    <div
        class="bg-white shadow-none drop-shadow-lg rounded-3xl mt-10 p-6 block justify-center items-center space-y-4 md:space-y-10 md:flex lg:flex lg:space-x-10">
        <canvas id="myBarChart" height="160" width="500">
        </canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // data sample for the chart
        let data = {
            labels: ['Monday', 'Tuesday',
                'Wednesday', 'Thursday',
                'Friday', 'Saturday', 'Sunday'
            ],
            datasets: [{
                label: 'History Access',
                data: [12, 17, 3, 8, 2],
                backgroundColor: 'rgba(70, 192, 192, 0.6)',
                borderColor: 'rgba(150, 100, 255, 1)',
                borderWidth: 1
            }]
        };

        // Configuration options for the chart
        let options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Get the canvas element
        let ctx = document.getElementById('myBarChart')
            .getContext('2d');

        // Create the bar chart
        let myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    </script>
@endsection
