<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;
    protected $table = 'recibo';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = [
        'Fecha', 'Solicitud', 'Numero', 'Pago',
        'Intereses', 'CantidadActual', 'Capital',
        'Total', 'Usuario', 'FechaInicio'
    ];
    protected $guarded = [];

    public function solicitud()
    {
        // parametros : (ruta del modelo a relacionar, campo origen indice, campo otra tabla indice)
        //RELACION RECIBO-SOLICITUD
        return $this->belongsTo(Solicitud::class, 'Solicitud', 'Id');
    }
}
