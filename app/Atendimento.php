<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Clinica;
use App\Dentista;
class Atendimento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clinica_id',
        'dentista_id',
        'dia_semana',
        'hora_inicio',
        'hora_fim'
    ];

    protected $dates = [ 'deleted_at' ];


    protected $appends = ['dia_semana_text'];

    public static function rules() {
        return [
            'clinica_id' => 'required',
            'dentista_id' => 'required',
            'dia_semana' => 'required',
            'hora_inicio' => 'required',
            'hora_fim' => 'required'
        ];
    }

    /**
    * Define an inverse one-to-one or many relationship with Clinica
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function Clinica() {
       return $this->belongsTo(Clinica::class);
    }

    /**
    * Define an inverse one-to-one or many relationship with Dentista
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function Dentista() {
       return $this->belongsTo(Dentista::class);
    }

    public function getDiaSemanaTextAttribute () {
        return collections('dias_semana')[$this->dia_semana];
    }
}
