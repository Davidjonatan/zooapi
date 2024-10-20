<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class dieta_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dietas';

    public $timestamps = false;
    protected $fillable = [
        'tipo',
        'descripcion'
    ];
   

    protected $dates = ['deleted_at'];
    // Relación con DietaAnimal
    public function dietasAnimales()
    {
        return $this->hasMany(dieta_animal_Model::class, 'id_dieta_animal');
    }
}
