<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Common extends Model
{
    use HasFactory; 

    /**
     * The database table used by the model.
     *
     * @access protected
     * @var string
     */
     
    protected $table = 'mncommon';
    
     /**
     * The attributes that are mass assignable.
     *
     * @access protected
     * @var array
     */

    protected $fillable = ['id', 'Mainkey', 'Indiv', 'PayrollIndiv', 'ChurchCode', 'ChurchDonorCode', 'FieldCode', 'DistrictCode', 'EntityType', 'FinancialType', 'SubFiles', 'Security', 'SecurityOverridden', 
    'IsConfidential', 'IMWebDisplay', 'NCMWebDisplay', 'ChurchMasterName', 'ChurchThanksName', 'SchoolType', 'MailingName', 'MailingNameOverride', 'FormalMailingNameOLD', 'LicenseName', 'Title', 'FirstName', 'MiddleName', 
    'LastName', 'Suffix', 'AlphaSortName', 'HomePhone', 'OfficePhone', 'Fax', 'CellPhone', 'WebSite', 'USAEmail', 'ForeignEmail', 'LocationCity', 'LocationState', 'LocationZip', 'LocationCountry', 'MailingCity', 'MailingState', 'MailingZip', 
    'MailingCountry', 'Gender', 'MaritalStatus', 'NameUsed', 'DeceasedDate', 'RetiredDate', 'DeceasedCity', 'DeceasedState', 'NotifiedBy', 'ReportedDate', 'CommonNoMail', 'CommonNoEmail', 'CAMANoMail', 'CAMANoEmail', 'OrchardNoMail', 'OrchardNoEmail',
    'PrisonerNumber', 'Denom', 'SourceOfLead', 'AddDate', 'UpdateDate', 'UpdateBy'];
}
