<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitud';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = [
        'Numero', 'Fecha', 'Solicitante', 'Fiador', 'Cantidad',
        'Monto', 'Tipo', 'Tasa', 'Meses', 'NumeroCredito', 'Estado',
        'UsuarioIngreso', 'FechaIngreso', 'UsuarioAprobacion', 'FechaAprobacion',
        'UsuarioAnulacion', 'FechaAnulacion'
    ];
    protected $guarded = [];

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'Tipo', 'Id');
    }
    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'Estado', 'Id');
    }
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'Solicitante', 'Id');
    }

    public function fiador()
    {
        return $this->belongsTo(Persona::class, 'Fiador', 'Id');
    }
}
