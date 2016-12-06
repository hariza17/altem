<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::group(['prefix' => 'api'], function () {
    Route::post('login', 'ApiAuthController@authenticate');
    Route::get('riesgos_estudinate/{id}', 'EstudianteController@getRiesgosByEstudiante');
    Route::get('personal/{codigo}', 'ArchivoPersonalController@getRiesgosPersonalByEstudiantes');
    Route::post('reporte/estudiante_riesgo_programa', 'ReporteController@archivo_personal');
    Route::get('reporte/config/anio', 'ReporteController@getAnios');
    Route::get('personal/{codigo}', 'ArchivoPersonalController@getRiesgosPersonalByEstudiantes');
    Route::get('riesgos_archivo/{codigo}', 'ArchivoPersonalController@riesgoAgregado');

    
    Route::resource('estudiante', 'EstudianteController');

    // Adding JWT Auth Middleware to prevent invalid access
    Route::group(['middleware' => 'jwt.auth'], function () {


        Route::group(['middleware' => ['role:ADMIN|CONSE|PSICO']], function () {

            Route::resource('login', 'ApiAuthController', ['only' => ['index']]);
            Route::get('estudiante_filtro/{id}', 'EstudianteController@ejecutarFiltro');

            Route::resource('intervencion', 'ArchivoPersonalController');
            Route::resource('accion_aplicada', 'AccionAplicadaController');
            Route::get('estudiante_colums', 'EstudianteController@getColumn');

            Route::resource('tipo_riesgo', 'TipoRiesgoController');
            Route::resource('estrategia', 'EstrategiaController');
            Route::get('estrategia_by_riesgo/{id}', 'EstrategiaController@estrategiaByRiesgoId');
            Route::resource('accion', 'AccionController');
            Route::get('accion/acciones_estrategia/{id}', 'AccionController@getByEstrategia');
            Route::resource('tipo_riesgo', 'TipoRiesgoController');
            Route::resource('riesgo', 'RiesgoController');
            Route::resource('filtro', 'FiltroController');
            Route::resource('archivo_personal', 'ArchivoPersonalController');
            Route::get('filtro/filtros_riesgo/{id}', 'FiltroController@getByRiesgo');

            Route::post('role', 'ApiAuthController@createRole');
// Route to create a new permission
            Route::post('permission', 'ApiAuthController@createPermission');
// Route to assign role to user
            Route::post('assign_role', 'ApiAuthController@assignRole');
// Route to attache permission to a role
            Route::post('attach_permission', 'ApiAuthController@attachPermission');
        });

    });






});


Route::get('/', 'PagesController@index');