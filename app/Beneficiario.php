<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Beneficiario;
use App\Plano;

class Beneficiario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'nascimento',
        'titular_id',
        'plano_id',
    ];

    protected $dates = ['deleted_at'];

    /**
    * Define an inverse one-to-one or many relationship with Titular
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function Titular() {
       return $this->belongsTo(Beneficiario::class, 'titular_id');
    }

    /**
    * Define an inverse one-to-one or many relationship with Plano
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function Plano() {
       return $this->belongsTo(Plano::class);
    }

    public static function rules($prefix="") {
        $arr =  [
            'nome'=>'required|min:5',
            'nascimento'=>'required',
            'plano_id'=>'required'
        ];

        if($prefix) {
            $newArr = [];
            foreach ($arr as $key => $value) {
                $newArr[$prefix.'.'.$key] = $value;
            }
            return $newArr;
        }
        return $arr;
    }
}
