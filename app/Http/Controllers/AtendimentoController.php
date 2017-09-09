<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atendimento;
class AtendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Atendimento::orderBy('created_at', 'desc')
            ->with('clinica', 'dentista');

        if(request()->clinica_id) 
            $query->whereClinicaId(request()->clinica_id);
        if(request()->dentista_id) 
            $query->whereDentistaId(request()->dentista_id);
        if(request()->dia_semana)
            $query->whereDiaSemana(request()->dia_semana);

        return $query->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Atendimento::rules());
        return Atendimento::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Atendimento $atendimento)
    {
        return $atendimento->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Atendimento $atendimento)
    {
        $this->validate($request, Atendimento::rules());
        $atendimento->update($request->all());
        return $atendimento;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Atendimento $atendimento)
    {
        $atendimento->delete();
        return "true";
    }
}
