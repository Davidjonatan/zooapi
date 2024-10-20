<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class empleado_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'empleados';

    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'anios_de_experiencia'
    ];
    

    protected $dates = ['deleted_at'];
    // Relación con Animal
    public function animales()
    {
        return $this->belongsToMany(animal_Model::class, 'cuidadores_de_animales', 'id_empleado', 'id_animal');
    }   
}
