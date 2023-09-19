<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    use HasFactory;
    protected $table = 'egreso';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = ['Numero','Fecha','Descripcion','Tipo','Cantidad','Rubro','Usuario','FechaIngreso'];
    protected $guarded = [];

    public function tipo()
    {
        // parametros : (ruta del modelo a relacionar, campo origen indice, campo otra tabla indice)
        //RELACION EGRESO-TIPO
        return $this->belongsTo(Tipo::class, 'Tipo', 'Id');
    }
    public function rubro()
    {
        // parametros : (ruta del modelo a relacionar, campo origen indice, campo otra tabla indice)
        //RELACION EGRESO-RUBRO
        return $this->belongsTo(Rubro::class, 'Rubro', 'Id');
    }
    public function usuario()
    {
        // parametros : (ruta del modelo a relacionar, campo origen indice, campo otra tabla indice)
        //RELACION EGRESO-USER
        return $this->belongsTo(Usuario::class, 'Usuario', 'Id');
    }


}
