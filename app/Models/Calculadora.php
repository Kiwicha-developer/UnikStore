<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calculadora extends Model
{
    public $timestamps = false;
 
    protected $table = 'Calculadora';
    
    protected $primaryKey = 'idCalculadora';

    protected $guarded = ['idCalculadora'];
    
    protected $fillable = ['igv',
                            'facturacion'
                            ];

    
    protected $hidden = [
        
    ];

    
    protected $casts = [
        'idCalculadora' => 'int',
        'igv' => 'float',
        'facturacion' => 'float'
    ];

    /**
     * Obtener las relaciones del modelo.
     */
}