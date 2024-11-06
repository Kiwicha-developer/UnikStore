<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristicas_Sugerencias extends Model
{
    public $timestamps = false;
    protected $table = 'Caracteristica_Sugerencia';
    
    protected $primaryKey = 'idSugerencia';

    protected $guarded = ['idSugerencia'];
    
    protected $fillable = ['idSugerencia',
                            'idCaracteristica',
                            'sugerencia',
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idSugerencia' => 'int',
        'idCaracteristica' => 'int'
    ];

    public function Caracteristicas_Grupo(){
        return $this->belongsTo(Caracteristicas::class,'idCaracteristica','idCaracteristica');
    }


    /**
     * Obtener las relaciones del modelo.
     */
}