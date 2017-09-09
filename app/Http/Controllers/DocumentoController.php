<?php

namespace App\Http\Controllers;

use App\Documento;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Documento::orderBy('created_at', 'desc')
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
        /*
        * O campo do form com o arquivo tinha o atributo name="file".
        */
        $file = request()->file('file');

        if (empty($file)) {
            abort(400, 'Nenhum arquivo foi enviado.');
        }

        $file_name = time() . pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
        
        $file->move(public_path('files'), $file_name . ".csv");
        
        $arr = csvToArray('files/' . $file_name . '.csv');

        $this->exportar($arr, $file_name);

        $documento = Documento::create([
            'nome'=>$file->getClientOriginalName($file_name),
            'file_path'=> 'files/' . $file_name . '.xls'
        ]);
        return $documento;
    }

    public function exportar($arr, $file_name) {
        $export = \Excel::create($file_name, function($excel) use ($arr, $file_name) {
            
            $excel->sheet('excel', function($sheet) use ($arr) {
        
                $sheet->fromArray($arr);
        
            });
        
        })->store('xls');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documento $documento)
    {
        //
    }
}
