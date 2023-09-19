<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;
    protected $table = 'banco';

    protected $primaryKey = 'Id';

    public $timestamps = false;


    protected $fillable = ['Nombre'] ;
    
    //por seguridad de momento , despues explicacion
    protected $guarded = [];
}
