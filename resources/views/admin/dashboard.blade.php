@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e6f0fa, #ffffff);
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #005EB8;
            margin-bottom: 40px;
            text-align: center;
            position: relative;
        }

        .dashboard-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #005EB8;
            margin: 12px auto 0;
            border-radius: 2px;
        }

        .card-stat {
            background: linear-gradient(145deg, #ffffff, #f1f5fa);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card-stat:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .card-stat i {
            font-size: 2.5rem;
            color: #005EB8;
            margin-bottom: 15px;
        }

        .card-stat h3 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }

        .card-stat p {
            font-size: 1.1rem;
            color: #666;
        }

        .chart-container {
            margin-top: 50px;
        }

        canvas {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }
    </style>

    <div class="container mt-5">
        <h1 class="dashboard-title">Dashboard Admin</h1>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card-stat">
                    <i class="fas fa-users"></i>
                    <h3>120</h3>
                    <p>Total Pengguna</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stat">
                    <i class="fas fa-file-alt"></i>
                    <h3>45</h3>
                    <p>Kuisioner Masuk</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stat">
                    <i class="fas fa-star"></i>
                    <h3>4.32</h3>
                    <p>Rata-rata Nilai</p>
                </div>
            </div>
        </div>

        <!-- Grafik -->
        <div class="row chart-container">
            <div class="col-md-8">
                <canvas id="userChart" height="120"></canvas>
            </div>
            <div class="col-md-4">
                <canvas id="questionnaireChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Line Chart - Perkembangan Pengguna
        const ctx1 = document.getElementById('userChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: [50, 70, 90, 120, 150, 180],
                    borderColor: '#005EB8',
                    backgroundColor: 'rgba(0, 94, 184, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                }
            }
        });

        // Pie Chart - Kuisioner
        const ctx2 = document.getElementById('questionnaireChart').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Selesai', 'Belum'],
                datasets: [{
                    data: [45, 15],
                    backgroundColor: ['#005EB8', '#ddd']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
@endsection
