<?php

namespace App\Http\Controllers;

// Asegúrate de que sólo uses los modelos que necesitas, y quita los 'use' innecesarios.
use Illuminate\Http\Request;
use App\Models\DetailReservVueloHotel;
use App\Models\hotel;
use App\Models\Detail_vuelo_cliente;
use App\Models\reservacion;
use App\Models\sucursal;
use App\Models\vuelo;
use App\Models\claseVuelo;
use App\Models\Cliente; 
use PDF;

class ReportesController extends Controller
{
    public function indexGet(Request $request)
    {
        return view("reportes.indexGet", [
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Reportes" => url("/reportes")
            ]
        ]);
    }

    public function sucursalesClientesGet()
    {
        // Asumiendo que cada reservación tiene un único cliente y que se contarán cuántos clientes únicos han hecho reservaciones en cada sucursal.
        $sucursales = Sucursal::withCount(['reservaciones' => function ($query) {
            $query->select(\DB::raw('count(distinct(NIFCliente))'));
        }])->get();
    
        return view('reportes.sucursalesClientes', [
            'sucursales' => $sucursales,
            'breadcrumbs' => [
                "Inicio" => url("/"),
                "Reportes" => url("/reportes"),
                "Sucursales y Clientes" => url("/reportes/sucursales-clientes")
            ]
        ]);
    }

    // Agrega aquí los métodos para otros reportes
    public function showReservacionesPorPeriodoForm()
    {
    $breadcrumbs = [
        "Inicio" => url("/"),
        "Reportes" => url("/reportes"),
        "Filtrar Reservaciones por Periodo" => url("/reportes/reservaciones-por-periodo")
    ];

    return view('reportes.reservacionesPorPeriodo', compact('breadcrumbs'));
    }

    public function reservacionesPorPeriodo(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);
    
        $reservaciones = Reservacion::whereBetween('fechaReservacion', [$request->fecha_inicio, $request->fecha_fin])->get();
    
        $breadcrumbs = [
            "Inicio" => url("/"),
            "Reportes" => url("/reportes"),
            "Resultados del Filtrado" => url("/reportes/reservaciones-por-periodo")
        ];
    
        // Envía fecha_inicio y fecha_fin a la vista
        return view('reportes.resultadoReservaciones', [
            'reservaciones' => $reservaciones,
            'breadcrumbs' => $breadcrumbs,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin
        ]);
    }

    public function reservasFechaPDF(Request $request)
    {
        // Asegúrate de que 'fecha_inicio' y 'fecha_fin' son recibidos correctamente.
        // Aquí asumimos que estas fechas vienen del request como parámetros.
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
    
        // Aquí se realiza la consulta para obtener las reservaciones dentro del rango de fechas.
        // Verifica que la consulta es correcta y que los nombres de los campos en la base de datos son correctos.
        $reservacionesActivas = Reservacion::whereBetween('fechaReservacion', [$fecha_inicio, $fecha_fin])->get();
    
        // Generando el PDF usando la vista y pasando la variable correctamente.
        $pdf = PDF::loadView('reportes.resultadoReservacionesPDF', [
            'reservaciones' => $reservacionesActivas, // Asegúrate de que el nombre de la variable aquí coincide con el usado en la vista.
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin
        ]);
    
        // Retorna el PDF para descargar
        return $pdf->download('reportes.descargar.pdf', compact('reservacionesActivas'));
    }

    public function viewreservasFechaPDF(Request $request)
    {
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin;
    
        // Aquí se realiza la consulta para obtener las reservaciones dentro del rango de fechas.
        // Verifica que la consulta es correcta y que los nombres de los campos en la base de datos son correctos.
        $reservaciones = Reservacion::whereBetween('fechaReservacion', [$fecha_inicio, $fecha_fin])->get();
        
        $pdf = PDF::loadView('reportes.resultadoReservacionesPDF', compact('reservaciones', 'fecha_inicio', 'fecha_fin'));
        return $pdf->stream('reservaciones_activas.pdf');
    }


    public function showSucursalesGenerales()
    {
        $breadcrumbs = [
            "Inicio" => url("/"),
            "Reportes" => url("/reportes"),
            "Reporte de Sucursales Activas" => url("/reportes/sucursales-generales")
        ];
        
        $sucursales = Sucursal::all();
        return view('reportes.sucursalesGenerales', compact('sucursales', 'breadcrumbs'));
    }
    
    public function viewSucursalesGeneralesPDF()
    {

        $sucursales = Sucursal::all();
        $pdf = PDF::loadView('reportes.sucursalesGeneralesPDF', compact('sucursales'));
        return $pdf->stream('sucursales_generales.pdf');
    }
    
    public function downloadSucursalesGeneralesPDF()
    {
        $sucursales = Sucursal::all();
        $pdf = PDF::loadView('reportes.sucursalesGeneralesPDF', compact('sucursales'));
        return $pdf->download('sucursales_generales.pdf');
    }

        //Reportes para las reservaciones activas
        public function showReservacionesActivas()
        {
            $reservaciones = Reservacion::where('estado', '1')->get(); // Asumiendo que 'activo' es un estado válido
        
            // Definir los breadcrumbs
            $breadcrumbs = [
                "Inicio" => url("/"),
                "Reportes" => url("/reportes"),
                "Reporte de Sucursales Activas" => url("/reportes/sucursales-generales")
            ];
        
            // Pasar las reservaciones y los breadcrumbs a la vista
            return view('reportes.reservacionesActivas', compact('reservaciones', 'breadcrumbs'));
        }
        

    public function downloadReservacionesActivasPDF()
    {
        $reservaciones = Reservacion::where('estado', '1')->get();
        $pdf = PDF::loadView('reportes.reservacionesActivasPDF', ['reservaciones' => $reservaciones]);
    return $pdf->download('reservaciones_activas.pdf');
    }

    public function graficaReservacionesSucursal()
    {
        // Definir los breadcrumbs
        $breadcrumbs = [
            "Inicio" => url("/"),
            "Reportes" => url("/reportes"),
            "Gráfica de Reservaciones por Sucursal" => url("/reportes/grafica-reservaciones-sucursal")
        ];
    
        $data = Reservacion::selectRaw('sucursal.nombreSucursal, COUNT(*) as total')
            ->join('sucursal', 'reservacion.IDSucursal', '=', 'sucursal.IDSucursal')
            ->where('reservacion.estado', '1')
            ->groupBy('sucursal.nombreSucursal')
            ->get();
    
        return view('reportes.graficaReservaciones', compact('data', 'breadcrumbs'));
    }
    




}
