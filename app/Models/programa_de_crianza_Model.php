<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class programa_de_crianza_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'programas_de_crianza';

    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'fecha_de_inicio',
        'fecha_de_finalizacion'
    ];
    

    protected $dates = ['deleted_at'];
    // Relación con Animal
    public function animales()
    {
        return $this->belongsToMany(animal_Model::class, 'programas_cria_de_animales', 'id_programa_de_crianza', 'id_animal');
    }
}
