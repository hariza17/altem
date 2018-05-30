<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Filtro;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class FiltroController extends Controller
{

    public function __construct()
    {
        $this->middleware('cors');
        $this->beforeFilter('@find', ['only' => ['show', 'update', 'destroy']]);
    }


    public function find(Route $route)
    {
        $this->filtro = Filtro::find($route->getParameter('filtro'));
    }


    public function index()
    {
        //$sql="SELECT * FROM sat.filtros group by riesgos_id";
        $filtro = Filtro::with('riesgo')
            ->groupBy('riesgos_id')->get();
        return response()->json($filtro);
    }

    public function getByRiesgo($id)
    {
        $filtro = Filtro::where('riesgos_id', $id)->get();
        return response()->json($filtro);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Filtro::create($request->all());
        return response()->json(["mensaje" => "Creado correctamente"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->filtro);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->filtro->fill($request->all());
        $this->filtro->save();
        return response()->json(["mensaje" => "Actualizacion exitosa"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->filtro->delete();
        return response()->json(["mensaje" => "Borrado correctamente"]);
    }
}
