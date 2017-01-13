<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Intervencion;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;


class IntervencionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct(){
		$this->middleware('cors');
		$this->beforeFilter('@find',['only'=>['show','update','destroy']]);
	}

	public function find(Route $route){

		$this->intervencion=Intervencion::find($route->getParameter('intervencion'));

	}

    public function index()
    {
        $intervencion = Intervencion::all();
		return response()->json($intervencion);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Intervencion::create($request->all());
		return response()->json(["mensaje"=>"Creado correctamente"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return response()->json($this->intervencion);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

       	$this->intervencion->fill($request->all());
		$this->intervencion->save();
		return response()->json(["mensaje"=>"Actualizacion exitosa"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteIntervencion(Request $request){
        $idEstrategia=$request->input('idestrategia');
        $idArchivo=$request->input('idarchivo');
        $intervencion=Intervencion::where('estrategias_id',$idEstrategia)
            ->where('archivo_personal_id',$idArchivo)->first();
        //dd($intervencion);
        $intervencion->delete();

        return response()->json(["mensaje"=>"Eliminacion exitosa"]);
    }

    public function destroy($id)
    {

         $this->intervencion->delete();
    }
}
