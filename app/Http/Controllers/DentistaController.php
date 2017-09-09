<?php

namespace App\Http\Controllers;

use App\Dentista;
use Illuminate\Http\Request;

class DentistaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dentista::orderBy('created_at', 'desc')
        ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Dentista::rules());
        return Dentista::create(request()->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dentista  $dentista
     * @return \Illuminate\Http\Response
     */
    public function show(Dentista $dentista)
    {
        return $dentista->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dentista  $dentista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dentista $dentista)
    {
        $this->validate($request, $dentista->rules());
        $dentista->update($request->all());
        return $dentista;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dentista  $dentista
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dentista $dentista)
    {
        $dentista->delete();
        return "true";
    }

    public function imagem() {
        /*
        * O campo do form com o arquivo tinha o atributo name="file".
        */
        $file = request()->file('img');

        if (empty($file)) {
            abort(400, 'Nenhum arquivo foi enviado.');
        }

        $file_name = time() . '.' .$file->getClientOriginalExtension();
        $file->move(public_path('img'), $file_name);
        return [
            "imgDataUrl"=> 'img/' . $file_name
        ];
    }

    /**
     * Função que retorna todos os registros sem paginação
     *
     * @return void
     */
    public function getAll() {
        return Dentista::all();
    }
}
