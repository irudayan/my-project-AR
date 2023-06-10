<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districtactivedate extends Model
{
    use HasFactory; 
    /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */
     
    protected $table = 'districtactivedates';
    
     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */

    protected $guarded =[];

    public function Districtactivedate(){
        return $this->belongsTo(Districtactivedate::class);
    }
}
