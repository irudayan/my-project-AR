<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSectionStatus extends Model
{
    use HasFactory; 

    /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */
     
    protected $table = 'reportsectionstatus';
    
     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */

    protected $guarded =[];

    public function ReportSectionStatus(){
        return $this->belongsTo(ReportSectionStatus::class);
    }

}
