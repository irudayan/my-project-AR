<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annualreport extends Model
{
    use HasFactory; 

    /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */
     
    protected $table = 'annual_report';
    
     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */

    protected $guarded =[];

    public function Annualreport(){
        return $this->belongsTo(Annualreport::class);
    }

    // protected $fillable = ['id', 'Mainkey', 'YearReported', 'YearCompleteFlag', 'Submitted', 'SubmittedDate', 'Verified', 'MembersRemoved', 'MembersAdded', 'MembersTotal', 'PreviousYearMembers', 'AdherentsTotal', 'InclusiveTotal', 'MorningAttendance', 'SmallGroupAttendance', 'YouthGroupAttendance', 'ChildrenAttendance', 'Conversions0to11', 'Conversions12to18', 'Conversions19to30', 'ConversionsOver30', 'ConversionsTotal', 'BaptismsTotal', 'IncomeLocal', 'FamilySupportLocal', 'FamilySupportGCM', 'DistrictOperatingBudget', 'DistrictChurchPlantBudget', 'STMCMAForeign', 'STMCMADomestic', 'STMCMAContributions', 'STMNonCMAForeign', 'STMNonCMADomestic', 'STMNonCMAContributions', 'STMEvent', 'BulletinCount', 'Language', 'LanguageOther', 'MultiSiteLocations', 'ChurchDebt', 'MembershipDone', 'AttendanceDone', 'ConversionsDone', 'BaptismsDone', 'IncomeDone', 'ContributionsDone', 'STMCMADone', 'STMNonCMADone', 'MiscellaneousDone', 'StaffDone', 'CommentDone', 'Comment', 'UpdateDate', 'UpdateBy', 'LeadersDeveloped', 'LeadersDeployed', 'PlantIntent', 'ChurchMultDone', 'DigitalAttendance', 'Ethnicity', 'CAProgramConsultation', 'CAProgramPEAK', 'CAProgramATMN', 'CAProgramFreshStart', 'CAProgramMaxImpact', 'EthnicityOther', 'CAProgramDynamicInfluence', 'DiscipleshipPlan', 'DiscipleshipPlanNumber', 'LeadershipPlan', 'LeadershipPlanNumber', 'EvangelismPlan', 'EvangelismPlanNumber', 'OutreachPlan', 'OutreachPlanNumber', 'GroupPrayer', 'AllianceWorkersSupported', 'DigitalService', 'ChurchPlant', 'ChurchPlantList', 'UpdateByName', 'MailingName', 'AMGiving', 'GCFGiving', 'AMGivingPercent', 'GCFGivingPercent','validate','created_at', 'updated_at'];
}
