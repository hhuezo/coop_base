<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuario';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = ['Usuario','Clave','Nombre','Rol','Activo'];
    

    protected $guarded = [];
}
