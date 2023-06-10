<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */

    protected $table = 'staff';

     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */

    protected $guarded =[];

    public function Staff(){
        return $this->belongsTo(Staff::class);
    }

    // protected $fillable = ['id', 'StaffID', 'StaffMainkey', 'EntityMainkey', 'Title', 'FirstName', 'MiddleName', 'LastName', 'Suffix', 'Gender', 'Email', 'Phone', 'PositionTitle','district','churchdistrict','roles','usertype', 'Comment', 'NOComment', 'AddedDate', 'UpdateDate', 'UpdateBy', 'xEmailAutoinc', 'xBillingBeginDate', 'xBillingEndDate', 'xStaffType', 'xDirectory', 'xDirectoryTitle', 'xHidden', 'xBeginDate', 'xEndDate', 'WebDisplay', 'created_at', 'updated_at'];
}
