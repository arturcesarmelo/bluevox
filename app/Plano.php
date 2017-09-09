<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Plano extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
    ];

    protected $dates = ['deleted_at'];

    public static function rules() {
        return [
            'nome'=>'required|min:5'
        ];
    }
}
