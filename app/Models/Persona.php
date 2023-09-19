<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'persona';

    protected $primaryKey = 'Id';

    public $timestamps = false;


    protected $fillable = ['Nombre', 'Dui', 'Nit', 'Telefono', 'Correo', 'Socio', 'Banco', 'NumeroCuenta', 'Activo'];


    protected $guarded = [];

    public function banco()
    {
        // parametros : (ruta del modelo a relacionar, campo origen indice, campo otra tabla indice)
        return $this->belongsTo(Banco::class, 'Banco', 'Id');
    }
}
