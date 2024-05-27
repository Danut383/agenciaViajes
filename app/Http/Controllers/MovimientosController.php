<?php
namespace App\Http\Controllers;
use App\Models\DetailReservVueloHotel;
use App\Models\hotel;
use App\Models\Detail_vuelo_cliente;
use App\Models\reservacion;
use App\Models\sucursal;
use App\Models\vuelo;
use App\Models\ClaseVuelo;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;
use DateTime;   
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Regimen_hospedaje;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;


class MovimientosController extends Controller
{
    public function reservacionGet(Request $request): View
    {
        $query = Reservacion::with('detailReservVueloHotel.vuelo', 'detailReservVueloHotel.hotel', 'detailReservVueloHotel.claseVuelo', 'cliente', 'sucursal');
    
        // Filtrar por cliente si se proporciona un ID de cliente
        if ($request->has('NIFCliente') && $request->NIFCliente != '') {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('NIFCliente', $request->NIFCliente);
            });
        }
    
        // Implementar paginación y mantener filtros
        $reservaciones = $query->get();
    
        // Obtener todas las clases de vuelo y clavearlas por IDClaseVuelo
        $clasesVuelo = ClaseVuelo::all()->keyBy('IDClaseVuelo');
        $sucursales = Sucursal::all();
        $vuelos = Vuelo::all();
        $hoteles = Hotel::all();
        $detalleVueloCliente = DetailReservVueloHotel::all();
        $regimenesHospedaje = Regimen_hospedaje::all();
        // Obtener todos los clientes que tienen al menos una reservación
        $clientes = Cliente::whereHas('reservaciones')->get();
    
        return view('movimientos.reservacionesGet', [
            'reservaciones' => $reservaciones,
            'clientes' => $clientes,
            'sucursales' => $sucursales,
            'vuelos' => $vuelos,
            'hoteles' => $hoteles,
            'regimenesHospedaje' => $regimenesHospedaje,
            'detalleVueloCliente' => $detalleVueloCliente,
            'clasesVuelo' => $clasesVuelo,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Reservaciones" => url("/movimientos/Reservaciones")
            ]
        ]);
    }

    public function getHorarios($IDVuelo)
    {
        $vuelo = Vuelo::findOrFail($IDVuelo);
        return response()->json([
            'fechahoraSalida' => $vuelo->fechaHraSalida,
            'fechahoraLlegada' => $vuelo->fechaHraLlegada,
        ]);
    }
    
    public function reservacionAgregarGet(Request $request): View
    {
        $clasesVuelo = ClaseVuelo::where('estado', 1)->get();
        $origenes = Vuelo::select('origen')->distinct()->pluck('origen');
        $destinos = Vuelo::select('destino')->distinct()->pluck('destino');
        $sucursales = Sucursal::all();
        $clientes = Cliente::all();
        $vuelos = Vuelo::all();
        $hoteles = Hotel::all();
        $regimenesHospedaje = Regimen_hospedaje::all();
    
        $selectedOrigen = $request->input('origen');
        $selectedDestino = $request->input('destino');
        $selectedIDVuelo = $request->input('IDVuelo');
    
        return view('movimientos/reservacionesAgregarGet', [
            'sucursales' => $sucursales,
            'clientes' => $clientes,
            'vuelos' => $vuelos,
            'origenes' => $origenes,
            'destinos' => $destinos,
            'clasesVuelo' => $clasesVuelo,
            'hoteles' => $hoteles,
            'regimenesHospedaje' => $regimenesHospedaje,
            'selectedOrigen' => $selectedOrigen,
            'selectedDestino' => $selectedDestino,
            'selectedIDVuelo' => $selectedIDVuelo,
            'breadcrumbs' => [
                "Inicio" => url("/"),
                "Reservaciones" => url("/movimientos/reservaciones"),
                "Agregar" => url("/movimientos/reservaciones/agregar")
            ]
        ]);
    }
    
    public function reservacionAgregarPost(Request $request)
    {
        $clasesVuelo = ClaseVuelo::where('estado', 1)->pluck('IDClaseVuelo')->toArray();
    
        // Validar datos comunes
        $validatedData = $request->validate([
            'IDSucursal' => 'required|exists:sucursal,IDSucursal',
            'NIFCliente' => 'required|exists:cliente,NIFCliente',
            'fechaReservacion' => 'required|date',
            'estado' => 'required|boolean',
            'IDHotel' => 'nullable|exists:hotel,IDHotel',
            'IDRegimenHospedaje' => 'nullable|exists:regimen_hospedaje,IDRegimenH',
            'fechaHoraRegimen' => 'nullable|date_format:Y-m-d\TH:i',
            'fechaHoraRegFin' => 'nullable|date_format:Y-m-d\TH:i|after:fechaHoraRegimen',
            'tipoHabitacion' => 'nullable|string|in:single,double,family',
            'numeroPersonas' => 'nullable|integer|min:1|max:9',
            'IDVuelo' => 'nullable|exists:vuelo,IDVuelo',
        ]);
    
        DB::beginTransaction();
    
        try {
            // Crear la reservación principal
            $reservacion = Reservacion::create([
                'IDSucursal' => $validatedData['IDSucursal'],
                'NIFCliente' => $validatedData['NIFCliente'],
                'fechaReservacion' => $validatedData['fechaReservacion'],
                'estado' => $validatedData['estado'],
            ]);
    
            // Validar y procesar los datos del vuelo si el checkbox está marcado para vuelo
            if ($request->has('checkVuelo') && $request->checkVuelo == 'on') {
                $validatedVueloData = $request->validate([
                    'IDVuelo' => 'required|exists:vuelo,IDVuelo',
                    'origen' => 'nullable|string',
                    'destino' => 'nullable|string',
                    'fechahoraSalida' => 'required|date_format:Y-m-d\TH:i|date',
                    'fechahoraLlegada' => 'required|date_format:Y-m-d\TH:i|date',
                    'boletos' => 'required|array|min:1|max:9',
                    'boletos.*.clase' => ['required', Rule::in($clasesVuelo)],
                    'boletos.*.cantidad' => 'required|integer|min:1|max:9',
                ]);
    
                $fechahoraSalida = Carbon::createFromFormat('Y-m-d\TH:i', $validatedVueloData['fechahoraSalida'])->format('Y-m-d H:i:s');
                $fechahoraLlegada = Carbon::createFromFormat('Y-m-d\TH:i', $validatedVueloData['fechahoraLlegada'])->format('Y-m-d H:i:s');
    
                $vuelo = Vuelo::find($validatedVueloData['IDVuelo']);
                $totalBoletos = array_sum(array_column($validatedVueloData['boletos'], 'cantidad'));
    
                $claseDisponibilidad = [
                    1 => $vuelo->plazasDisponiblesPrimeraClase,
                    2 => $vuelo->plazasDisponiblesEjecutiva,
                    3 => $vuelo->plazasDisponiblesEconomica
                ];
    
                foreach ($validatedVueloData['boletos'] as $boleto) {
                    if ($boleto['cantidad'] > $claseDisponibilidad[$boleto['clase']]) {
                        throw new \Exception('No hay suficientes asientos disponibles en la clase seleccionada.');
                    }
                }
    
                $boletosJson = json_encode($validatedVueloData['boletos']);
    
                DetailReservVueloHotel::create([
                    'IDReservacion' => $reservacion->IDReservacion,
                    'IDVuelo' => $validatedVueloData['IDVuelo'],
                    'fechahoraSalida' => $fechahoraSalida,
                    'fechahoraLlegada' => $fechahoraLlegada,
                    'boletos' => $boletosJson,
                ]);
            }
    
            // Validar y procesar los datos del hotel si el checkbox está marcado para hotel
            if ($request->has('checkHotel') && $request->checkHotel == 'on') {
                $validatedHotelData = $request->validate([
                    'IDHotel' => 'required|exists:hotel,IDHotel',
                    'IDRegimenHospedaje' => 'nullable|exists:regimen_hospedaje,IDRegimenH',
                    'tipoHabitacion' => 'required|string|in:single,double,family',
                    'fechaHoraRegimen' => 'required|date_format:Y-m-d\TH:i',
                    'fechaHoraRegFin' => 'required|date_format:Y-m-d\TH:i|after:fechaHoraRegimen',
                    'numeroPersonas' => 'required|integer|min:1|max:9',
                ]);
    
                $fechaHoraRegimen = Carbon::createFromFormat('Y-m-d\TH:i', $validatedHotelData['fechaHoraRegimen'])->format('Y-m-d H:i:s');
                $fechaHoraRegFin = Carbon::createFromFormat('Y-m-d\TH:i', $validatedHotelData['fechaHoraRegFin'])->format('Y-m-d H:i:s');
    
                $hotel = Hotel::find($validatedHotelData['IDHotel']);
    
                $habitacionDisponibilidad = [
                    'single' => $hotel->habitacionesDisponiblesSingle,
                    'double' => $hotel->habitacionesDisponiblesDouble,
                    'family' => $hotel->habitacionesDisponiblesFamily
                ];
    
                if ($habitacionDisponibilidad[$validatedHotelData['tipoHabitacion']] < 1) {
                    throw new \Exception('No hay habitaciones disponibles del tipo seleccionado.');
                }
    
                DetailReservVueloHotel::create([
                    'IDReservacion' => $reservacion->IDReservacion,
                    'IDHotel' => $validatedHotelData['IDHotel'],
                    'IDRegimenHospedaje' => $validatedHotelData['IDRegimenHospedaje'],
                    'fechaHoraRegimen' => $fechaHoraRegimen,
                    'fechaHoraRegFin' => $fechaHoraRegFin,
                    'tipoHabitacion' => $validatedHotelData['tipoHabitacion'],
                    'numeroPersonas' => $validatedHotelData['numeroPersonas'],
                ]);
            }
    
            DB::commit();
    
            return redirect('/movimientos/reservaciones')->with('success', 'Reservación creada con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al crear la reservación: ' . $e->getMessage()]);
        }
    }

    
    
    public function reservacionesModificarGet($IDReservacion) {
        $reservacion = Reservacion::with(['sucursal'])->findOrFail($IDReservacion);
        $sucursales = Sucursal::all();
        $clientes = Cliente::join("reservacion","reservacion.NIFCliente","=","cliente.NIFCliente")
        -> where("IDReservacion",$IDReservacion)->first();
        $breadcrumbs =[
            "Inicio" => "/",
            "Reservaciones" => "/movimientos/reservaciones",
            "Modificar" => "/movimientos/reservaciones/{$IDReservacion}/modificar"
        ];

        return view('movimientos/reservacionesModificarGet', [
            'reservacion' => $reservacion,
            'sucursales' => $sucursales,
            'clientes' => $clientes,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
    public function reservacionesModificarPost(Request $request, $IDReservacion)
    {
        $request->validate([
            'IDSucursal' => 'required|exists:sucursal,IDSucursal', 
            'estado' => 'required|boolean'
        ]);

        $reservacion = Reservacion::findOrFail($IDReservacion);
        $reservacion->update([
            'IDSucursal' => $request->IDSucursal,
            'estado' => $request->estado
        ]);

        return redirect('/movimientos/reservaciones')
                        ->with('success', 'Reservación actualizada correctamente.');
    }


    public function reservacionesVueloModificarGet($IDReservacion)
    {
        $reservacion = Reservacion::findOrFail($IDReservacion);
        $clientes = Cliente::all();
        $vuelos = Vuelo::all();
        $hoteles = Hotel::all();
        $sucursales = Sucursal::all();
        $clasesVuelo = ClaseVuelo::all();
        $regimenesHospedaje = Regimen_hospedaje::all();
        $clientNomb = Cliente::join("reservacion","reservacion.NIFCliente","=","cliente.NIFCliente")
        -> where("IDReservacion",$IDReservacion)->first();
        $breadcrumbs = [
            'Inicio' => url('/'),
            'Reservacion' => url('/movimientos/reservaciones/'),
            'Modificar Vuelo' => url("/movimientos/reservaciones/{$IDReservacion}/modificar_vuelo")
        ];

        return view('movimientos/reservacionVueloModificarGet', compact('reservacion', 'clientes', 'vuelos', 'hoteles', 'sucursales', 'clasesVuelo', 'regimenesHospedaje', 'breadcrumbs', 'clientNomb'));
    }

    public function reservacionesVueloModificarPost(Request $request, $IDReservacion)
{
    $request->validate([
        'IDVuelo' => 'required|exists:vuelo,IDVuelo',
        'estado' => 'required|boolean',
        'fechaHraSalida' => 'required|date_format:Y-m-d\TH:i',
        'fechaHraLlegada' => 'required|date_format:Y-m-d\TH:i',
    ]);

    $reservacion = Reservacion::findOrFail($IDReservacion);
    $reservacion->update([
        'IDVuelo' => $request->IDVuelo,
        'estado' => $request->estado
    ]);

    if ($reservacion->detailReservVueloHotel) {
        $reservacion->detailReservVueloHotel->update([
            'IDVuelo' => $request->IDVuelo,
            'fechahoraSalida' => \Carbon\Carbon::parse($request->fechaHraSalida)->format('Y-m-d H:i:s'),
            'fechahoraLlegada' => \Carbon\Carbon::parse($request->fechaHraLlegada)->format('Y-m-d H:i:s'),
        ]);
    } else {
        DetailReservVueloHotel::create([
            'IDReservacion' => $reservacion->IDReservacion,
            'IDVuelo' => $request->IDVuelo,
            'fechahoraSalida' => \Carbon\Carbon::parse($request->fechaHraSalida)->format('Y-m-d H:i:s'),
            'fechahoraLlegada' => \Carbon\Carbon::parse($request->fechaHraLlegada)->format('Y-m-d H:i:s'),
            'estado' => $request->estado,
        ]);
    }

    return redirect()->route('reservaciones.index')->with('success', 'Reservación de vuelo actualizada correctamente.');
}
    
    public function reservacionesHotelModificarGet($IDReservacion)
    {
    $reservacion = Reservacion::findOrFail($IDReservacion);
    $hoteles = Hotel::all();
    $clientNomb = Cliente::join("reservacion","reservacion.NIFCliente","=","cliente.NIFCliente")
        -> where("IDReservacion",$IDReservacion)->first();
    $regimenesHospedaje = Regimen_hospedaje::all();

    $breadcrumbs = [
        'Inicio' => url('/'),
        'Reservaciones' => url('/movimientos/reservaciones/'),
        'Modificar Hotel' => url("/movimientos/reservaciones/{$IDReservacion}/modificar_hotel")
    ];

    return view('movimientos/reservacionesHotelModificarGet', compact('reservacion', 'hoteles', 'regimenesHospedaje', 'breadcrumbs', 'clientNomb'));
    }
    
    public function reservacionesHotelModificarPost(Request $request, $IDReservacion)
    {
        $request->validate([
            'IDHotel' => 'required|exists:hotel,IDHotel',
            'IDRegimenHospedaje' => 'required|exists:regimen_hospedaje,IDRegimenH',
            'estado' => 'required|boolean',
            'horaRegimen' => 'required|date_format:H:i', // Solo la hora es requerida
            'horaRegFin' => 'required|date_format:H:i', // Solo la hora es requerida
        ]);

        $reservacion = Reservacion::findOrFail($IDReservacion);
        $detail = $reservacion->detailReservVueloHotel;

        if ($detail) {
            $fechaRegimen = \Carbon\Carbon::parse($detail->fechaHoraRegimen)->format('Y-m-d');
            $fechaRegFin = \Carbon\Carbon::parse($detail->fechaHoraRegFin)->format('Y-m-d');

            $detail->update([
                'IDHotel' => $request->IDHotel,
                'IDRegimenHospedaje' => $request->IDRegimenHospedaje,
                'fechaHoraRegimen' => $fechaRegimen . ' ' . $request->horaRegimen,
                'fechaHoraRegFin' => $fechaRegFin . ' ' . $request->horaRegFin,
                'estado' => $request->estado,
            ]);
        } else {
            DetailReservVueloHotel::create([
                'IDReservacion' => $reservacion->IDReservacion,
                'IDHotel' => $request->IDHotel,
                'IDRegimenHospedaje' => $request->IDRegimenHospedaje,
                'fechaHoraRegimen' => now()->format('Y-m-d') . ' ' . $request->horaRegimen,
                'fechaHoraRegFin' => now()->addDays(1)->format('Y-m-d') . ' ' . $request->horaRegFin,
                'estado' => $request->estado,
            ]);
        }

        return redirect()->route('reservaciones.index')->with('success', 'Reservación de hotel actualizada correctamente.');
    }


}