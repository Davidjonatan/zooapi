<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class especie_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'especies';

    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'nombre_cientifico',
        'estado_de_conservacion'
    ];

    protected $dates = ['deleted_at'];
    // Relación con Animal
    public function animales()
    {
        return $this->hasMany(animal_Model::class, 'id_de_especie');
    }}
