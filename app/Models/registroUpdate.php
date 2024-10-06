<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class registroUpdate extends Model
{
    public $timestamps = false;
 
    protected $table = 'registroUpdate';
    
    protected $primaryKey = 'idRegistro';

    protected $guarded = ['idRegistro'];
    
    protected $fillable = ['columna',
                            'ultimaFecha',
                            'cantidadUpdate',
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'ultimaFecha' => 'date',
        'cantidadUpdate' => 'int',
    ];

    /**
     * Obtener las relaciones del modelo.
     */
    
}