<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    use HasFactory;
    protected $table = 'rubro';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = ['Nombre','Activo','Tipo'];
    protected $guarded = [];
    //FUNCION PARA CREA LA RELACION DE LAS TABLAS RUBRO Y TIPO
    public function ObjTipo()
    {
        // parametros : (ruta del modelo a relacionar, campo origen indice, campo otra tabla indice)
        return $this->belongsTo('App\Models\Tipo', 'Tipo', 'Id');
    }
}
