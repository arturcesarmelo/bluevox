<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Documento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'file_path',
    ];

    protected $dates =  [ 'deleted_at' ];
}
