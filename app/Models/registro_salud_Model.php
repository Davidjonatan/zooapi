<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class registro_salud_Model extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'registros_de_salud';

    public $timestamps = false;
    protected $fillable = [
        'id_animal',
        'fecha_de_revision',
        'estado_de_salud'
    ];
    

    protected $dates = ['deleted_at'];  
    // Relación con Animal
    public function animal()
    {
        return $this->belongsTo(animal_Model::class, 'id_animal');
    }
}
