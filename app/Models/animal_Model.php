<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class animal_Model extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'animales';
    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'edad',
        'genero',
        'id_de_especie',
        'id_habitat'
    ];
    

    protected $dates = ['deleted_at'];
    // Relación con Especie
    public function especie()
    {
        return $this->belongsTo(especie_Model::class, 'id_de_especie');
    }

    // Relación con Hábitat
    public function habitat()  
    {
        return $this->belongsTo(habitat_Model::class, 'id_habitat');
    }

    // Relación con DietaAnimal
    public function dietas()
    {
        return $this->hasMany(dieta_animal_Model::class, 'id_animal');
    }

    // Relación con Registros de Salud
    public function registrosSalud()
    {
        return $this->hasMany(registro_salud_Model::class, 'id_animal');
    }

    // Relación con Cuidadores
    public function cuidadores()
    {
        return $this->belongsToMany(empleado_Model::class, 'cuidadores_de_animales', 'id_animal', 'id_empleado');
    }

    // Relación con Programas de Crianza
    public function programasCrianza()
    {
        return $this->belongsToMany(ProgramaCrianza::class, 'programas_cria_de_animales', 'id_animal', 'id_programa_de_crianza');
    }

}
