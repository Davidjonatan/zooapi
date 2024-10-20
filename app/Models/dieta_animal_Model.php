<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dieta_animal_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dietas_animales';

    public $timestamps = false;
    protected $fillable = [
        'id_dieta',
        'id_animal'
    ]
    ;

    protected $dates = ['deleted_at'];
    // Relación con Animal
    public function animal()
    {
        return $this->belongsTo(animal_Model::class, 'id_animal');
    }

    // Relación con Dieta
    public function dieta()
    {
        return $this->belongsTo(dieta_Model::class, 'id_dieta');
    }
}
