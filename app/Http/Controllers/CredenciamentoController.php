<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\Beneficiario;
class CredenciamentoController extends Controller
{

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return \DB::transaction(function() use ($request) {
            $this->validate($request, Beneficiario::rules('titular'));
            
            $idadeTitular = Carbon::createFromFormat(
                'Y-m-d',
                request()->input('titular.nascimento')
            );
            
            if(Carbon::now()->diffInYears($idadeTitular) < 18)
                return response()->json([
                    'errors'=>[
                        'nascimento'=>['não é permitido titular menor de 18 anos']
                    ]
                ], 422);
    
            $titular = Beneficiario::create($request->titular);

            foreach ($request->dependentes as $dependente) {
                Beneficiario::create(array_merge($dependente, [
                    'titular_id'=>$titular->id,
                ]));
            }
        });
    }
}
