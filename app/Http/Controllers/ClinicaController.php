<?php

namespace App\Http\Controllers;

use App\Clinica;
use Illuminate\Http\Request;

class ClinicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Clinica::with('filiais')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFiliais()
    {
        return Clinica::whereNotNull('matriz_id')
            ->with('matriz')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMatrizes()
    {
        return Clinica::whereNull('matriz_id')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Clinica::rules());
        return Clinica::create(request()->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function show(Clinica $clinica)
    {
        return $clinica->load('filiais', 'matriz')->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clinica $clinica)
    {
        $this->validate($request, $clinica->rules());
        $clinica->update($request->all());
        return $clinica->load('filiais');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clinica  $clinica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clinica $clinica)
    {
        $clinica->delete();
        return "true";
    }

    /**
     * Função que retorna todos os registros sem paginação
     *
     * @return void
     */
    public function getAll() {
        return Clinica::all();
    }
}
