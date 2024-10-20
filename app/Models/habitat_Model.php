<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class habitat_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'habitats';

    public $timestamps = false;
    protected $fillable = [
        'nombre',
        'clima',
        'region'
    ];
    

    protected $dates = ['deleted_at'];
    // Relación con Animal
    public function animales()
    {
        return $this->hasMany(animal_Model::class, 'id_habitat');
    }}
