<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempIngresos extends Model
{
    use HasFactory;
    protected $table = 'temp_ingreso_egreso';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    //protected $fillable = ['Nombre'];
    protected $guarded = [];
}
