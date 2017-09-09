<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Clinica extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'matriz_id',
        'image_url'
    ];

    public static function rules() {
        return [
            'nome'=>'required|min:5',
        ];
    }

    public static function dataTable() {
        return self::query()->orderBy('created_at', 'desc')->get();
    }

    protected $dates = ['delete_at'];

    public function Filiais() {
        return $this->hasMany('\App\Clinica', 'matriz_id');
    }

    public function Matriz() {
        return $this->belongsTo('\App\Clinica', 'matriz_id');
    }
}
