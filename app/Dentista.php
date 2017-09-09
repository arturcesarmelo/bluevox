<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Dentista extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'image_url'
    ];

    protected $dates = [ 'deleted_at' ];

    public static function rules() {
        return [
            'nome'=>'required|min:5',
        ];
    }
}
