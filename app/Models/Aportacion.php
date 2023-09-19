<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aportacion extends Model
{
    use HasFactory;
    protected $table = 'aportaciones';

    protected $primaryKey = 'Id';

    public $timestamps = false;


    protected $fillable = [
        'Numero',
        'Socio',
        'Fecha',
        'Cantidad',
        'Usuario',
        'FechaIngreso',
        'Mes',
        'Axo'

    ];

    //por seguridad de momento , despues explicacion
    protected $guarded = [];

    public function socio()
    {
        return $this->belongsTo(Persona::class, 'Socio', 'Id');
    }
}
