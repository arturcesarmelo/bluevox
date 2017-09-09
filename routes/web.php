<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app', [
        'title'=>'Home'
    ]);
});

Route::resource('clinicas','ClinicaController');
Route::resource('dentistas','DentistaController');
Route::resource('atendimentos','AtendimentoController');
Route::resource('documentos','DocumentoController');
Route::resource('planos','PlanoController');
Route::resource('beneficiarios','BeneficiarioController');


Route::get('clinicas-all', 'ClinicaController@getAll');
Route::get('filiais', 'ClinicaController@getFiliais');
Route::get('matrizes', 'ClinicaController@getMatrizes');
Route::post('clinica-imagem', 'ClinicaController@imagem');

Route::post('dentista-imagem','DentistaController@imagem');
Route::get('dentistas-all', 'DentistaController@getAll');
Route::post('documentos/exportar', 'DocumentoController@exportar');

Route::get('planos-all', 'PlanoController@getAll');
Route::post('credenciamentos', 'CredenciamentoController@store');