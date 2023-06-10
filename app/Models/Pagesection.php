<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagesection extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */
     
    protected $table = 'pagesection';
    
     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */
     
    protected $fillable = ['id', 'Name', 'MainsectionName', 'SubsectionName','PagesectionColumn','PageSectionCode', 'Description', 'Position','created_at', 'updated_at'];
}
