<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class church extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */
     
    protected $table = 'church';
    
     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */
     
    protected $fillable = ['id', 'Mainkey', 'CHRStatus','Active','CHRMailTo', 'CHRNoMail', 'CHRNoEmail', 'AccreditedDate', 'AffiliatedDate', 'CeasedAffiliationDate', 'StartDate', 'CloseDate', 'Campaign', 'County', 'ChurchEthnic', 'DirectoryCity', 'ClosureReason', 'SecondaryClosureReason', 'ThirdClosureReason', 'Replanted', 'ResidualAssetsUse', 'InsightsGained', 'PotentialPlantCode', 'PotentialChurchName', 'AnnualReport', 'IMKPIReport', 'ChurchType', 'ProjectedLaunchDate', 'ChurchPlantDistrictCode', 'MotherChurch', 'DaughterChurch', 'AssetsValue', 'UpdateDate', 'UpdateBy', 'GreenhouseStartDate', 'GreenhouseEndDate', 'ATMNNeedDate', 'created_at', 'updated_at'];
}
