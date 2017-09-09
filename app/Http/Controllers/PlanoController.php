<?php

namespace App\Http\Controllers;

use App\Plano;
use Illuminate\Http\Request;

class PlanoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Plano::orderBy('created_at', 'desc')
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
        $this->validate($request, Plano::rules());
        return Plano::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function show(Plano $plano)
    {
        return $plano->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plano $plano)
    {
        $this->validate($request, $plano::rules());
        return $plano::update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plano $plano)
    {
        $plano->delete();
        return "true";
    }

    public function getAll(){
        return Plano::all();
    }
}
