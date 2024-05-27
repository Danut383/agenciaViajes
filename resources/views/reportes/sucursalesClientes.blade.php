<!--EN ESTA VIEW, SE MUESTRA LA GRÁFICA DE BARRAS, SE CUENTAN LOS NÚMEROS DE CLIENTES POR CADA SUCURSAL-->
@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h1 class="text-center mb-4">Reporte Gráfico de Clientes por Sucursal</h1>
                <canvas id="sucursalesChart" width="100%" height="100"></canvas>    <!--tamaño de gráfica-->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('sucursalesChart').getContext('2d');
                    const sucursalesChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode($sucursales->pluck('nombreSucursal')->take(10)) !!},
                            datasets: [{
                                label: 'NÚMERO DE CLIENTES ÚNICOS',
                                data: {!! json_encode($sucursales->pluck('reservaciones_count')->take(10)) !!},
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    stacked: true, // Agrega esta línea para que los valores se muestren en enteros
                                    ticks: {
                                        stepSize: 1, // Establece el tamaño de paso a 1
                                        precision: 0 // Establece la precisión a 0 para mostrar solo enteros
                                    }
                                },
                                x: {
                                    ticks: {
                                        autoSkip: false,
                                        maxRotation: 90,
                                        minRotation: 90
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
