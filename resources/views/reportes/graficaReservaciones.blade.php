@extends('components.layout')
@section('content')
@component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent
    <h1>Gráfica de Reservaciones por Sucursal</h1>
    <canvas id="myChart"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! $data->pluck('nombreSucursal') !!},
                datasets: [{
                    label: 'Número de Reservaciones',
                    data: {!! $data->pluck('total') !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
