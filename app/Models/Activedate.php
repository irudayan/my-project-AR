<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activedate extends Model
{
    use HasFactory; 

    /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */
     
    protected $table = 'activedate';
    
     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */

    protected $guarded =[];

    public function Activedate(){
        return $this->belongsTo(Activedate::class);
    }
}