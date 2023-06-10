<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ethnicity extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */
     
    protected $table = 'ethnicity';
    
     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */

    protected $fillable = ['id', 'autoinc', 'Mainkey', 'Qualifier', 'Ethnicity', 'Percentage', 'UpdateBy'];
}
