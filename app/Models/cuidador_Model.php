<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class cuidador_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cuidadores_de_animales';

    public $timestamps = false;
    protected $fillable = [
        'id_animal',
        'id_empleado'
    ];

    protected $dates = ['deleted_at'];
    // Relación con Animal
    public function animal()
    {
        return $this->belongsTo(animal_Model::class, 'id_animal');
    }

    // Relación con Cuidador
    public function empleado()
    {
        return $this->belongsTo(empleado_Model::class, 'id_empleado');
    }
}
