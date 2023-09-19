<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;
    protected $table = 'tipo';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = ['Nombre'];
    protected $guarded = [];
}
