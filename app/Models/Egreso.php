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

    public function ObjEgresoTipo()
    {
        // parametros : (ruta del modelo a relacionar, campo origen indice, campo otra tabla indice)
        //RELACION EGRESO-TIPO
        return $this->belongsTo('App\Models\Tipo', 'Tipo', 'Id');
    }   
    public function ObjEgresoRubro()
    {
        // parametros : (ruta del modelo a relacionar, campo origen indice, campo otra tabla indice)
        //RELACION EGRESO-RUBRO
        return $this->belongsTo('App\Models\Rubro', 'Rubro', 'Id');
    }  
    public function ObjEgresoUsuario()
    {
        // parametros : (ruta del modelo a relacionar, campo origen indice, campo otra tabla indice)
        //RELACION EGRESO-USER
        return $this->belongsTo('App\Models\Usuario', 'Usuario', 'Id');
    }  
             
    
}
