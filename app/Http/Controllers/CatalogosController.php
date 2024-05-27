<?php
namespace App\Http\Controllers;
use App\Models\detail_reserv_vuelo_hotel;
use App\Models\hotel;
use App\Models\detail_vuelo_cliente;
use App\Models\regimenHospedaje;
use App\Models\reservacion;
use App\Models\sucursal;
use App\Models\vuelo;
use App\Models\claseVuelo;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CatalogosController extends Controller
{
    public function home():View
    {
        return view('home',["breadcrumbs"=>[]]);
    }
    
    public function clientesGet(Request $request): View
    {
        // Iniciar la consulta de todos los clientes
        $query = Cliente::query();
    
        // Filtrar por nombre de cliente si se proporciona
        if ($request->has('NIFCliente') && $request->NIFCliente != '') {
            $query->where('NIFCliente', $request->NIFCliente);
        }
    
        $clientes = $query->get();

        //$clientes = $query->paginate(8)->appends($request->except('page'));
    
        return view('catalogos/clientesGet', [
            'clientes' => $clientes,

            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Clientes" => url("/catalogos/clientes")
            ]
        ]);
    }
    
    public function clientesData(Request $request)
    {
        $query = Cliente::query();

        // Filtrar por nombre de cliente si se proporciona
        if ($request->has('NIFCliente') && $request->NIFCliente != '') {
            $query->where('NIFCliente', $request->NIFCliente);
        }

        return datatables()->of($query)->make(true);
    }

    public function getCliente($id)
    {
        $cliente = Cliente::findOrFail($id);
        return response()->json($cliente);
    }



public function clientesAgregarGet(): View
{
    $clientes = Cliente::all(); // Asumiendo que se listan clientes existentes en la vista de agregar para alguna referencia o validación.
    return view('catalogos/ClientesAgregarGet', [
        'clientes' => $clientes,
        "breadcrumbs" => [
            "Inicio" => url("/"),
            "Clientes" => url("/catalogos/clientes"),
            "Agregar" => url("/catalogos/clientes/agregar")
        ]
    ]);
}

public function clientesAgregarPost(Request $request)
{
    $cliente = new Cliente([
        "nombre" => strtoupper($request->input("nombre")),
        "ciudad" => $request->input("ciudad"),
        "telefono" => $request->input("telefono"),
        "email" => $request->input("email"),
        "estado" => $request->input("estado"),
    ]);
    $cliente->save();

    return redirect("/catalogos/clientes")->with('success', 'Cliente agregado con éxito.');
}

public function clientesModificarGet($NIFCliente)
{
    $cliente = Cliente::findOrFail($NIFCliente);
    $breadcrumbs = [
        'Inicio' => url('/'),
        'Clientes' => url('/catalogos/clientes'),
        'Modificar' => url("/catalogos/clientes/{$NIFCliente}/modificar")
    ];
    return view('catalogos/clientesModificarGet', compact('cliente', 'breadcrumbs'));
}

public function clientesModificarPost(Request $request, $NIFCliente)
{
    $cliente = Cliente::findOrFail($NIFCliente);

    // Actualizar solo el nombre a mayúsculas
    $cliente->nombre = strtoupper($request->input('nombre'));
    
    // Guardar los demás datos como vienen del formulario
    $cliente->ciudad = $request->input('ciudad');
    $cliente->telefono = $request->input('telefono');
    $cliente->email = $request->input('email');
    $cliente->estado = $request->input('estado');

    // Guardar los cambios en la base de datos
    $cliente->save();
    
    return redirect('/catalogos/clientes')->with('success', 'Cliente actualizado con éxito.');
}

    //Sección para vuelos, empezando por filtrado para dataTable
    public function vuelosGet(Request $request): View
    {
        // Verificar si la solicitud es Ajax para DataTables
        if ($request->ajax()) {
            return $this->vuelosData($request);
        }
    
        // Consulta normal para la vista
        $query = Vuelo::query();
    
        // Filtrar por origen y destino si se proporcionan
        if ($request->has('origen') && $request->origen != '') {
            $query->where('origen', $request->origen);
        }
        if ($request->has('destino') && $request->destino != '') {
            $query->where('destino', $request->destino);
        }
    
        // Filtrar por número de vuelo si se proporciona
        if ($request->has('idVuelo') && $request->idVuelo != '') {
            $query->where('IDVuelo', $request->idVuelo);
        }
    
        // Implementar paginación y obtener todos los registros
        $vuelos = $query->select('IDVuelo', 'fechaHraSalida', 'fechaHraLlegada', 'origen', 'destino', 'plazasDisponiblesTotales', 'plazasPrimeraClase', 'plazasEconomica', 'plazasEjecutiva')->get();
    
        // Obtener listas únicas para los selects
        $origenes = Vuelo::select('origen')->distinct()->pluck('origen');
        $destinos = Vuelo::select('destino')->distinct()->pluck('destino');
    
        return view('catalogos.vuelosGet', [
            'vuelos' => $vuelos,
            'origenes' => $origenes,
            'destinos' => $destinos,
            'idVueloInput' => $request->idVuelo,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Vuelos" => url("/catalogos/vuelos")
            ]
        ]);
    }

    public function getVuelo($id)
    {
        $vuelo = Vuelo::findOrFail($id);
        return response()->json($vuelo);
    }


    public function vuelosAgregarGet(): View
    {
        $ultimoCodigo = Sucursal::max('codigoSucursal');

        $data = compact('ultimoCodigo');

        return view('catalogos/vuelosAgregarGet', $data,[
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Vuelos" => url("/catalogos/vuelos"),
                "Agregar" => url("/catalogos/vuelos/agregar")
            ],
        ]);
    }

    public function vuelosAgregarPost(Request $request)
    {
        $validatedData = $request->validate([
            'fechaHraSalida' => 'required|date',
            'fechaHraLlegada' => 'required|date|after:fechaHraSalida',
            'origen' => 'required|string',
            'destino' => 'required|string',
            'estado' => 'required|boolean',
            'plazasPrimeraClase' => 'required|integer|min:0',
            'plazasEjecutiva' => 'required|integer|min:0',
            'plazasEconomica' => 'required|integer|min:0',
        ]);

        $validatedData['plazasTotales'] = $validatedData['plazasPrimeraClase'] + $validatedData['plazasEjecutiva'] + $validatedData['plazasEconomica'];
        $validatedData['plazasDisponiblesPrimeraClase'] = $validatedData['plazasPrimeraClase'];
        $validatedData['plazasDisponiblesEjecutiva'] = $validatedData['plazasEjecutiva'];
        $validatedData['plazasDisponiblesEconomica'] = $validatedData['plazasEconomica'];
        $validatedData['plazasDisponiblesTotales'] = $validatedData['plazasPrimeraClase'] + $validatedData['plazasEjecutiva'] + $validatedData['plazasEconomica'];


        Vuelo::create($validatedData);

        return redirect("/catalogos/vuelos")->with('success', 'Vuelo agregado correctamente.');
    }

    public function vuelosModificarGet($id)
    {
        $vuelo = Vuelo::findOrFail($id); // Busca el vuelo por ID o falla si no lo encuentra
    
        return view('catalogos/vuelosModificarGet', [
            'vuelo' => $vuelo,
            'breadcrumbs' => [
                'Inicio' => url("/"),
                'Vuelos' => url("/catalogos/vuelos"),
                'Modificar' => url("/catalogos/vuelos/{$id}/modificar")
            ],
        ]);
    }
    
   
    public function vuelosModificarPost(Request $request, $id)
    {
        $validatedData = $request->validate([
            'fechaHraSalida' => 'required|date',
            'fechaHraLlegada' => 'required|date|after:fechaHraSalida',
            'origen' => 'required|string',
            'destino' => 'required|string',
            'estado' => 'required|boolean',
            'plazasPrimeraClase' => 'required|integer|min:0',
            'plazasEjecutiva' => 'required|integer|min:0',
            'plazasEconomica' => 'required|integer|min:0',
        ]);

        $vuelo = Vuelo::findOrFail($id);

        // Calcular diferencias y actualizar las plazas disponibles
        $differencePrimeraClase = $validatedData['plazasPrimeraClase'] - $vuelo->plazasPrimeraClase;
        $differenceEjecutiva = $validatedData['plazasEjecutiva'] - $vuelo->plazasEjecutiva;
        $differenceEconomica = $validatedData['plazasEconomica'] - $vuelo->plazasEconomica;

        $validatedData['plazasTotales'] = $validatedData['plazasPrimeraClase'] + $validatedData['plazasEjecutiva'] + $validatedData['plazasEconomica'];
        $validatedData['plazasDisponiblesPrimeraClase'] = $vuelo->plazasDisponiblesPrimeraClase + $differencePrimeraClase;
        $validatedData['plazasDisponiblesEjecutiva'] = $vuelo->plazasDisponiblesEjecutiva + $differenceEjecutiva;
        $validatedData['plazasDisponiblesEconomica'] = $vuelo->plazasDisponiblesEconomica + $differenceEconomica;

        $vuelo->update($validatedData);

        return redirect("/catalogos/vuelos")->with('success', 'Vuelo modificado correctamente.');
    }
    
    public function hotelesGet(Request $request): View
    {
        // Iniciar la consulta de todos los hoteles
        $query = Hotel::query();
    
        // Filtrar por nombre de hotel si se proporciona
        if ($request->has('nombre') && $request->nombre != '') {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
    
        // Filtrar por ciudad si se proporciona
        if ($request->has('ciudad') && $request->ciudad != '') {
            $query->where('ciudad', 'like', '%' . $request->ciudad . '%');
        }
    
        // Resultados para table
        $hoteles = $query->get();
        // Obtener listas únicas para los selects
        $nombres = Hotel::select('nombre')->distinct()->pluck('nombre');
        $ciudades = Hotel::select('ciudad')->distinct()->pluck('ciudad');
    
        return view('catalogos/hotelesGet', [
            'hoteles' => $hoteles,
            'nombres' => $nombres,
            'ciudades' => $ciudades,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Hoteles" => url("/catalogos/hoteles")
            ]
        ]);
    }

    public function getHotel($id)
    {
        $hotel = Hotel::findOrFail($id);
        return response()->json($hotel);
    }

    public function hotelesAgregarGet(): View
{
    return view('catalogos/hotelesAgregarGet', [
        "breadcrumbs" => [
            "Inicio" => url("/"),
            "Hoteles" => url("/catalogos/hoteles"),
            "Agregar" => url("/catalogos/hoteles/agregar")
        ]
    ]);
}

  // Método para enviar el formulario de agregar hotel
  public function hotelesAgregarPost(Request $request)
  {
      $validatedData = $request->validate([
          'nombre' => 'required|max:255',
          'numEstrellas' => 'required|integer|min:1|max:5',
          'estado' => 'required|boolean',
          'ciudad' => 'required|max:255',
          'telefono' => 'required|max:18',
          'singleRooms' => 'required|integer|min:0',
          'doubleRooms' => 'required|integer|min:0',
          'familyRooms' => 'required|integer|min:0',
      ]);
  
      $validatedData['totalRooms'] = $validatedData['singleRooms'] + $validatedData['doubleRooms'] + $validatedData['familyRooms'];
      $validatedData['habitacionesDisponiblesSingle'] = $validatedData['singleRooms'];
      $validatedData['habitacionesDisponiblesDouble'] = $validatedData['doubleRooms'];
      $validatedData['habitacionesDisponiblesFamily'] = $validatedData['familyRooms'];
      $validatedData['habitacionesDisponiblesTotales'] = $validatedData['totalRooms'];
  
      Hotel::create($validatedData);
  
      return redirect("/catalogos/hoteles")->with('success', 'Hotel agregado con éxito.');
  }


public function hotelModificarGet($id)
{
    $hotel = Hotel::findOrFail($id);
    $breadcrumbs = [
        "Inicio" => url("/"),
        "Hoteles" => url("/catalogos/hoteles"),
        "Modificar" => url("/catalogos/hoteles/{$id}/modificar")
    ];

    return view('catalogos.hotelModificarGet', [
        'hotel' => $hotel,
        'breadcrumbs' => $breadcrumbs, 
    ]);
}

    public function hotelActualizarPost($id, Request $request)
    {
    $hotel = Hotel::findOrFail($id);

    $validatedData = $request->validate([
        'nombre' => 'required|max:255',
        'numEstrellas' => 'required|integer|min:1|max:5',
        'estado' => 'required|boolean',
        'ciudad' => 'required|max:255',
        'telefono' => 'required|max:18',
        'singleRooms' => 'required|integer|min:0',
        'doubleRooms' => 'required|integer|min:0',
        'familyRooms' => 'required|integer|min:0',
    ]);

    $validatedData['totalRooms'] = $validatedData['singleRooms'] + $validatedData['doubleRooms'] + $validatedData['familyRooms'];

    // Calcular diferencias y actualizar las habitaciones disponibles
    $differenceSingle = $validatedData['singleRooms'] - $hotel->singleRooms;
    $differenceDouble = $validatedData['doubleRooms'] - $hotel->doubleRooms;
    $differenceFamily = $validatedData['familyRooms'] - $hotel->familyRooms;

    $validatedData['habitacionesDisponiblesSingle'] = $hotel->habitacionesDisponiblesSingle + $differenceSingle;
    $validatedData['habitacionesDisponiblesDouble'] = $hotel->habitacionesDisponiblesDouble + $differenceDouble;
    $validatedData['habitacionesDisponiblesFamily'] = $hotel->habitacionesDisponiblesFamily + $differenceFamily;
    $validatedData['habitacionesDisponiblesTotales'] = $validatedData['habitacionesDisponiblesSingle'] + $validatedData['habitacionesDisponiblesDouble'] + $validatedData['habitacionesDisponiblesFamily'];

    $hotel->update($validatedData);

    return redirect('/catalogos/hoteles')->with('success', 'Hotel actualizado con éxito.');
    }

    public function sucursalesGet(Request $request): View
    {
        $query = Sucursal::query();
        
        if ($request->has('nombreSucursal') && $request->nombreSucursal != '') {
            $query->where('nombreSucursal', 'like', '%' . $request->nombreSucursal . '%');
        }
    
        if ($request->has('ciudad') && $request->ciudad != '') {
            $query->where('ciudad', 'like', '%' . $request->ciudad . '%');
        }
    
        $sucursales = $query->get();
        $ultimoCodigo = Sucursal::max('codigoSucursal') +1;

        $nombres = Sucursal::select('nombreSucursal')->distinct()->pluck('nombreSucursal');
        $ciudades = Sucursal::select('ciudad')->distinct()->pluck('ciudad');
    
        return view('catalogos.sucursalGet', [
            'sucursales' => $sucursales,
            'nombres' => $nombres,
            'ciudades' => $ciudades,
            'ultimoCodigo' => $ultimoCodigo,
            "breadcrumbs" => [
                "Inicio" => url("/"),
                "Sucursales" => url("/catalogos/sucursales")
            ]
        ]);
    }
    
    public function getSucursal($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        return response()->json($sucursal);
    }

public function sucursalesAgregarGet(): View
{
    $ultimoCodigo = Sucursal::max('codigoSucursal') +1;
    $breadcrumbs = [
        "Inicio" => url("/"),
        "Sucursales" => url("/catalogos/sucursales"),
        "Agregar" => url("/catalogos/sucursales/agregar")
    ];
    
    // Combina ambos arrays en uno solo, debido a los parametros de breadcrumbs, chocan y se deben concatenar
    $data = compact('ultimoCodigo') + ['breadcrumbs' => $breadcrumbs];

    // Pasa el array combinado a la vista
    return view('catalogos/sucursalAgregarGet', $data);
    
}

public function sucursalesAgregarPost(Request $request)
{
    $rules = [
        'codigoSucursal' => 'required|integer|unique:sucursal,codigoSucursal',
        'nombreSucursal' => 'required|max:255',
        'direccion' => 'required|max:255',
        'ciudad' => 'required|max:255',
        'provincia' => 'required|max:255',
        'estado' => 'required|boolean',
        'noExt' => 'required|max:10',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect('/catalogos/sucursales/agregar')
            ->withErrors($validator)
            ->withInput();
    }

    $sucursal = new Sucursal($request->all());
    $sucursal->save();

    return redirect("/catalogos/sucursales")->with('success', 'Sucursal agregada con éxito.');
}

public function sucursalModificarGet($id)
{
    $sucursal = Sucursal::findOrFail($id);
    $todasLasSucursales = Sucursal::all(); // Obtener todas las sucursales para el select

    $breadcrumbs = [
        "Inicio" => url("/"),
        "Sucursales" => url("/catalogos/sucursales"),
        "Modificar" => url("/catalogos/sucursales/{$id}/modificar")
    ];

    return view('catalogos.sucursalModificarGet', [
        'sucursal' => $sucursal,
        'todasLasSucursales' => $todasLasSucursales,
        'breadcrumbs' => $breadcrumbs
    ]);
}

public function sucursalModificarPost($id, Request $request)
{
    $validatedData = $request->validate([
        'codigoSucursal' => 'required|integer|unique:sucursal,codigoSucursal,' . $id . ',IDSucursal', // Corrección aquí
        'nombreSucursal' => 'required|max:255',
        'direccion' => 'required|max:255',
        'noExt' => 'required|max:10',
        'ciudad' => 'required|max:255',
        'provincia' => 'required|max:255',
        'estado' => 'required|boolean',
    ]);

    $sucursal = Sucursal::findOrFail($id);
    $sucursal->update($validatedData);

    return redirect("/catalogos/sucursales")->with('success', 'Sucursal actualizada con éxito.');
}



}