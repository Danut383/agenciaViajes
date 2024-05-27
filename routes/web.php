<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\MovimientosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Autenticación y Registro
require __DIR__.'/auth.php';

// Ruta raíz redirige al dashboard si está autenticado, si no al login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard (requiere autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil del Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas del Catálogo de Clientes
    Route::prefix('catalogos/clientes')->group(function () {
        Route::get('/', [CatalogosController::class, 'ClientesGet']);
        Route::get('agregar', [CatalogosController::class, 'ClientesAgregarGet']);
        Route::post('agregar', [CatalogosController::class, 'ClientesAgregarPost']);
        Route::get('{NIFCliente}/modificar', [CatalogosController::class, 'clientesModificarGet'])->where('NIFCliente', '[0-9]+');
        Route::post('{NIFCliente}/modificar', [CatalogosController::class, 'clientesModificarPost'])->where('NIFCliente', '[0-9]+');
        Route::get('/data', [CatalogosController::class, 'clientesData']); // Ruta para DataTables
        Route::get('/{id}', [CatalogosController::class, 'getCliente']); // Ruta para obtener datos de un cliente específico a modificar

    });

    // Rutas del Catálogo de Vuelos
    Route::prefix('catalogos/vuelos')->group(function () {
        Route::get('/', [CatalogosController::class, 'vuelosGet']);
        Route::get('agregar', [CatalogosController::class, 'vuelosAgregarGet']);
        Route::post('agregar', [CatalogosController::class, 'vuelosAgregarPost']);
        //modal demodificar
        Route::get('/{id}', [CatalogosController::class, 'getVuelo'])->name('vuelos.show');
        Route::get('{vuelo}/modificar', [CatalogosController::class, 'vuelosModificarGet'])->where('vuelo', '[0-9]+');
        Route::put('{vuelo}/modificar', [CatalogosController::class, 'vuelosModificarPost']);
        Route::get('/data', [CatalogosController::class, 'vuelosData']); // Ruta para DataTables
    });

    // Rutas del Catálogo de Hoteles y Sucursales
    Route::prefix('catalogos')->group(function () {
        Route::prefix('hoteles')->group(function () {
            Route::get('/', [CatalogosController::class, 'hotelesGet']);
            Route::get('agregar', [CatalogosController::class, 'hotelesAgregarGet']);
            Route::post('agregar', [CatalogosController::class, 'hotelesAgregarPost']);
            Route::get('{id}/modificar', [CatalogosController::class, 'hotelModificarGet']);
            Route::post('{id}/modificar', [CatalogosController::class, 'hotelActualizarPost']);
            Route::get('{id}', [CatalogosController::class, 'getHotel'])->where('id', '[0-9]+'); // Ruta para obtener datos de un hotel específico
        });

        Route::prefix('sucursales')->group(function () {
            Route::get('/', [CatalogosController::class, 'sucursalesGet']);
            Route::get('agregar', [CatalogosController::class, 'sucursalesAgregarGet']);
            Route::post('agregar', [CatalogosController::class, 'sucursalesAgregarPost']);
            Route::get('{id}/modificar', [CatalogosController::class, 'sucursalModificarGet']);
            Route::post('{id}/modificar', [CatalogosController::class, 'sucursalModificarPost']);
            Route::get('{id}', [CatalogosController::class, 'getSucursal'])->where('id', '[0-9]+'); // Ruta para obtener datos de una sucursal específica
        });
    });
    
    //Manejar solicitudes AJAX
    Route::get('/vuelos/by-route', [VueloController::class, 'getByRoute']);

    Route::get('/vuelos/routes', [MovimientosController::class, 'getUniqueRoutes']);
    // Ruta para obtener horarios basados en origen, destino e IDVuelo
    Route::get('/vuelos/horarios/{origen}/{destino}/{IDVuelo}', [MovimientosController::class, 'getHorariosPorOrigenDestino']);

   // Rutas de Reservaciones
    Route::prefix('movimientos/reservaciones')->group(function () {
        Route::get('', [MovimientosController::class, 'reservacionGet'])->name('reservaciones.index');
        Route::get('/horarios/{IDVuelo}', [MovimientosController::class, 'getHorarios']);
        Route::get('agregar', [MovimientosController::class, 'reservacionAgregarGet']);
        Route::post('agregar', [MovimientosController::class, 'reservacionAgregarPost']);
        Route::get('{IDReservacion}/modificar', [MovimientosController::class, 'reservacionesModificarGet'])->name('reservaciones.modificar');
        Route::post('{IDReservacion}/modificar', [MovimientosController::class, 'reservacionesModificarPost'])->name('reservaciones.update');
        Route::get('{IDReservacion}/modificar_vuelo', [MovimientosController::class, 'reservacionesVueloModificarGet'])->where('IDReservacion', '[0-9]+');
        Route::post('{IDReservacion}/modificar_vuelo', [MovimientosController::class, 'reservacionesVueloModificarPost'])->where('IDReservacion', '[0-9]+');
        Route::get('{IDReservacion}/modificar_hotel', [MovimientosController::class, 'reservacionesHotelModificarGet'])->name('rhotel.modificar');
        Route::post('{IDReservacion}/modificar_hotel', [MovimientosController::class, 'reservacionesHotelModificarPost'])->name('rhotel.update');
    });



    // Rutas de Reportes
    Route::get('/reportes', [ReportesController::class, 'indexGet'])->name('reportes.index');
    Route::get('/reportes/sucursales-clientes', [ReportesController::class, 'sucursalesClientesGet'])->name('reportes.sucursales-clientes');
    Route::get('/reportes/reservaciones-activas-pdf', [ReportesController::class, 'reservacionesActivasPdf'])->name('reportes.reservaciones-activas-pdf');

    Route::get('/reportes/sucursales-generales', [ReportesController::class, 'showSucursalesGenerales'])->name('reportes.sucursales-generales');
    Route::get('/reportes/sucursales-generales-pdf/view', [ReportesController::class, 'viewSucursalesGeneralesPDF'])->name('reportes.sucursales-generales-pdf.view');
    Route::get('/reportes/sucursales-generales-pdf/download', [ReportesController::class, 'downloadSucursalesGeneralesPDF'])->name('reportes.sucursales-generales-pdf.download');
    //Seleccion del periodo para reportes
    Route::get('/reportes/reservaciones-por-periodo', [ReportesController::class, 'showReservacionesPorPeriodoForm'])->name('reportes.reservaciones-por-periodo-form');
    Route::post('/reportes/reservaciones-por-periodo', [ReportesController::class, 'reservacionesPorPeriodo'])->name('reportes.reservaciones-por-periodo');
    //reporte en tabla
    Route::get('/reportes/reservaciones-periodo-pdf/view', [ReportesController::class, 'viewreservasFechaPDF'])->name('reportes.reservaspdf.view');
    Route::get('/reportes/reservaciones-periodo-pdf/download', [ReportesController::class, 'reservasFechaPDF'])->name('reportes.descargar-pdf');
    
    //reporte reservas activas
    Route::get('/reportes/reservaciones-activas', [ReportesController::class, 'showReservacionesActivas'])->name('reportes.reservaciones-activas');
    
    Route::get('/reportes/download-reservaciones-activas-pdf', [ReportesController::class, 'downloadReservacionesActivasPDF'])->name('download-reservaciones-activas-pdf');
    Route::get('/reportes/grafica-reservaciones-sucursal', [ReportesController::class, 'graficaReservacionesSucursal'])->name('grafica-reservaciones-sucursal');



});
