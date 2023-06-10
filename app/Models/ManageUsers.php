<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageUsers extends Model
{
    use HasFactory;

     /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */
     
    protected $table = 'manageusers';
    
     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */
     
    protected $fillable = ['id', 'user_id', 'district_mainkey', 'church_mainkey', 'created_at', 'updated_at'];
}
 