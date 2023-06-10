<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ARHelper;
use Illuminate\Http\Request;
use app\Models\User;
use DB;
use App\Mail\role;
use App\Mail\status;
use Illuminate\Support\Facades\Mail;
use App\Models\District;
use App\Models\DistrictChurch;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\Pagesection;
use App\Models\Mainsection;



class ManageusersController extends Controller
{
   function index(){
    
    $users = User::all();
    $userscount = User::all()->count();

    $district = District::all();
    $districtchurch = DistrictChurch::all();

    $Approved =  DB::table('users')
    ->where('approvestatus', '=', 'Approved')
    ->count();
    $distrctstaff =  DB::table('users')
    ->where('usertype', '=', 'District')
    ->count();
    
    $notapproved = $userscount - $Approved;
    $ApprovedPercent = round(($Approved * 100) / $userscount, 2);
    $notapprovedPercent = round(($notapproved * 100) / $userscount, 2);



    return view('backend.includes.userslist',compact('users','district','districtchurch','Approved','notapproved','ApprovedPercent','notapprovedPercent','distrctstaff'));
   }
   public function exportindex(){
    
    $Mainsection = Mainsection::all();

    return view('backend.includes.Export',compact('Mainsection'));
   }

   public function getusertypecount(Request $request){
  
    if($request->val != null){
        $usercounts =  DB::table('users')
        ->where('usertype', '=', $request->val)
        ->count();
   }else{
    $usercounts="" ;
   }
    return response()->json([$usercounts]);
   }
   public function getuserlist(Request $request){
  
    $data = User::all();
    return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('actioncheck', function($row){
                    $check = '';
                     $check =$check.'<a href="javascript:void(0)" data-original-title="view"  style="padding: 0px 0px 0px 19px;" ><input class="form-check-input" type="checkbox"  name="export" id="export" value="'.$row->id.'" data-val="'.$row->Mainkey.'" ></a>';
                    return $check;
                })
                ->addColumn('username', function($row){
                    $username = '';
                     $username =$username.'<a href="javascript:void(0)" class="mainsectionedit" id="mainsectionedit'.$row->id.'" data-id="'.$row->id.'" data-original-title="view" >'.$row->username.'</a>';
                    return $username;
                })

                ->addColumn('district', function($row){
                    $district = '';
                        $district = $district.'<span data-original-title="view"  >'.ARHelper::getdistrict($row->district) ?? ''.'</span>';
                    
                    return $district;
                })
                ->addColumn('churchdistrict', function($row){
                    $churchdistrict = '';
                        $churchdistrict = $churchdistrict.'<span data-original-title="view"  >'.ARHelper::getchurch($row->churchdistrict) ?? ''.'</span>';
                    
                    return $churchdistrict;
                })
                
                ->addColumn('usertype', function($row){

                    $usertype = '';
                    $editor = 'Editor';
                    $distrctstaff = 'District Staff';
            
                if ($row->usertype == 'Users'){
                  
                    $usertype = $usertype.'<span data-original-title="view"  >'.$editor ?? ''.'</span>';
                }
                elseif($row->usertype == 'District'){
                  
                    $usertype = $usertype.'<span data-original-title="view"  >'. $distrctstaff ?? ''.'</span>';
                }
                else{
                   
                    $usertype = $usertype.'<span data-original-title="view"  >'.$row->usertype ?? ''.'</span>';
                }  
                    return $usertype;
                })
                ->addColumn('email', function($row){
                    $email = '';
                    $email =$email.'<a href = mailto:'.$row->email.'>'.$row->email.'</a>';     
                    return $email;
                })
                ->addColumn('approvestatus', function($row){
                    $approvestatus = '';
                    if($row->approvestatus =='Approved'){
                     
                     $approvestatus = $approvestatus.'<span data-original-title="view"  >'. $row->approvestatus ?? ''.'</span>'; 
                    }
                    else{   
                        $approvestatus = $approvestatus.'<span data-original-title="view"  >Not Approved</span>';
                    }  
                    return $approvestatus;
                })

                ->addColumn('status', function($row){
                    $status = '';
                    $status =$status.'<span data-original-title="view"  >'.$row->status ?? ''.'</span>';     
                    return $status;
                })
                ->addColumn('Impersonate', function($row){
                    $Impersonate = '';
                        $ConsrtucturlData = ['email' => $row->email];
                        $encodedata = base64_encode(http_build_query($ConsrtucturlData));
                        $CurPageURL = "/Impersonate/".$encodedata;  
                        
                        $Impersonate =$Impersonate.'<a href = '.$CurPageURL.' target=_blank>Impersonate</a>';     

                    return $Impersonate;
                })
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn = $btn.'<a href="javascript:void(0)" class="mainsectiondelete" id="mainsectiondelete'.$row->id.'" onclick="deleteuser('.$row->id.')" data-id="'.$row->id.'" data-original-title="view"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action','actioncheck','username','district','churchdistrict','usertype','email','status','approvestatus','Impersonate'])
                ->make(true);

   }

   function getusers(Request $request)
   {

    $id = $request->id;
    $user_data = User::find($id);
    $district = ARHelper::getdistrict($user_data->district);
   // $church = ARHelper::getchurch($user_data->churchdistrict);
    $church = $user_data->churchdistrict;
    return response()->json(['data'=> $user_data,'district' =>$district,'church' => $church]);
   }

   function getstaffs(Request $request)
   {
    $id = $request->id;
    $staff_data = Staff::find($id);
    $district = DistrictChurch::where('ChurchMainkey',$staff_data->EntityMainkey)->first();
    $staff =  DB::table('staffrole')
    ->select('StaffID','RoleTypeID')
    ->where('StaffID','=',$staff_data->StaffID)
    ->orderBy('RoleTypeID', 'DESC')
    ->get();
    $roles = [];
    foreach($staff as $s){
       $roles[] =  ARHelper::getstaffrole($s->RoleTypeID);
    }
    //$church = ARHelper::getchurch($user_data->churchdistrict);
    //$church = $user_data->churchdistrict;
    return response()->json(['data'=> $staff_data,'district'=>$district,'staff'=>$staff,'sroles'=> $roles]);
   }

   function UpdateUsers(Request $request)
   {
    $approvestatus = $request->approvestatus;
    $roles = $request->roles;
    if($approvestatus == null){
        $request->merge([
            'approvestatus' => 'Not Approved',
        ]);
    }
    $request->merge([
        'Userstatus' => $request->Userstatus,
    ]);
    if(!empty($roles)){
        $inColumn = implode(", ",$roles);
        $request->merge([
            'roles' => $inColumn,
        ]);
    }else{
        $request->merge([
            'roles' => '',
        ]);
    }
    $request->merge([
        'updated_at' =>Carbon::now(),
    ]);
    $input = $request->except('_token');
    $data = User::where('id',$input['id'])->first();

    $data->update($input);
    return response()->json(['success'=> " Updated Successfully!",'status' => "1"]);
   }

   function UpdateStaffs(Request $request)
   {
    $roles = $request->roles;
    if(!empty($roles)){
        $inColumn = implode(", ",$roles);
        $request->merge([
            'roles' => $inColumn,
        ]);
    }else{
        $request->merge([
            'roles' => '',
        ]);
    }
    if($roles == null){
        $request->merge([
            'roles' => '1',
            'updated_at' =>Carbon::now(),
        ]);
        $input = $request->except('_token');
        $data = Staff::where('id',$input['id'])->first();
        $updatestaff = $data->update($input);
    }else{
        $request->merge([
            'updated_at' =>Carbon::now(),
        ]);
        $input = $request->except('_token');
        $data = Staff::where('id',$input['id'])->first();
        $updatestaff = $data->update($input);
    }
    if($updatestaff){
    return response()->json(['success'=> " Updated Successfully!",'status' => "1"]);
    }

   }

   public function deletestaffs(Request $request)
    {
        $staffid = $request->all();
        $deletestaff = Staff::where('id',$staffid)->first();
        $deletestaff->delete();
        return response()->json(['success'=> " Deleted Successfully!",'status' => "Deleted"]);

    }

    public function deletenewstaffs(Request $request)
    {
        $staffid = $request->all();
        $deletestaff = User::where('id',$staffid)->first();
        $deletestaff->delete();
        return response()->json(['success'=> " Deleted Successfully!",'status' => "Deleted"]);

    }

    public function addnewstaffs(Request $request)
    {
        $roles = $request->roles;
    
        if(!empty($roles)){
            $inColumn = implode(", ",$roles);
            $request->merge([
                'roles' => $inColumn,
            ]);
        }else{
            $request->merge([
                'roles' => '',
            ]);
        }
        $request->merge([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $input = $request->except('_token');
        
        DB::table('staff')->insert($input);
        return response()->json(['success'=> " New Staff Added Successfully!",'action' => "add"]);

    }

    public function getdistrictchurch(Request $request)
    {
        $data = $request->district; 
        // $districtchurch = DistrictChurch::where('DistrictMainkey',$data)->get();
        $districtchurch = DistrictChurch::where('DistrictMainkey',$data)->orderBy('ChurchName', 'asc')->get();
        return response()->json($districtchurch);

    }
    public function getendyearchurchexport(Request $request){
            $input =$request->startyear;
            $years = DB::table('annual_report')->select('YearReported')->where('YearReported','>=',$input)->groupby('YearReported')->get();
            return response()->json($years);
    }
    public function getstartyearchurchexport(Request $request){
        $input =$request->endyear;
        $years = DB::table('annual_report')->select('YearReported')->where('YearReported','<',$input)->groupby('YearReported')->get();
        return response()->json($years);
}
    public function getdistrictchurchexport(Request $request)
    {
        
        $district =$request['district'] ?? ''; 
        // $districtchurch = DistrictChurch::where('DistrictMainkey',$data)->get();
        if($district[0] != 'All'){
        $districtchurch = DB::table('district_churches')->whereIn('DistrictMainkey',$district)->orderBy('ChurchName', 'asc')->get();
        }else{
        $districtall =DB::table('districts')->select('Mainkey')->get();
            $districtdata =[];
            foreach ($districtall as $key => $value) {
                
              $districtdata[] =  $value->Mainkey;
            }           
        $districtchurch = DB::table('district_churches')->whereIn('DistrictMainkey',$districtdata)->orderBy('ChurchName', 'asc')->get();
        }
        return response()->json($districtchurch);

    }
    public function getuserchurchexport(Request $request)
    {
    
        $data = $request->district;     
        $districtchurch = DistrictChurch::where('DistrictMainkey',$data)->orderBy('ChurchName', 'asc')->get();
        return response()->json($districtchurch);

    }
    public function getyearreportedexport(Request $request)
    { 
        $data = $request->usertype; 
        $churchmainkey =$request->churchdistrict;
     
        if ($data == 'Admin' || $data == 'District'|| $data == 'NationalOffice') {
            $years = DB::table('annual_report')->select('YearReported')->groupby('YearReported')->get();
           
        }else{
           
            $years = DB::table('annual_report')->select('YearReported')->where('Mainkey',$churchmainkey)->groupby('YearReported')->get();

        }
        
        return response()->json($years);

    }
    public function Getstaffdetailslink(Request $request){

        $id = $request->id;
        $staff_data = Staff::find($id);
        $district = DistrictChurch::where('ChurchMainkey',$staff_data->EntityMainkey)->first();
        $staff =  DB::table('staffrole')
        ->select('StaffID','RoleTypeID')
        ->where('StaffID','=',$staff_data->StaffID)
        ->orderBy('RoleTypeID', 'DESC')
        ->get();
        $roles = [];
        foreach($staff as $s){
        $roles[] =  ARHelper::getstaffrole($s->RoleTypeID);
        }

        $bytes = random_bytes(25);
        $str = bin2hex($bytes);

        $ConsrtucturlData = [
            'Email' =>  $staff_data->Email,
            'EntityMainkey' =>  $staff_data->EntityMainkey,
            'FirstName' =>  $staff_data->FirstName,
            'LastName' =>  $staff_data->LastName,
            'StaffID' =>  $staff_data->StaffID,
            'DistrictMainkey' =>  $district->DistrictMainkey,
            'ChurchMainkey' =>  $district->ChurchMainkey,
            'otp' => $str
        ];

        $encodedata = base64_encode(http_build_query($ConsrtucturlData));

        return response()->json($encodedata);

        }

        public function deleteusers(Request $request)
        {
            $userid = $request->all();
            $deleteuser = User::where('id',$userid)->first();
            $deleteuser->delete();
            return response()->json(['success'=> " Deleted Successfully!",'status' => "Deleted"]);
    
        }

        public function getdistrictName(Request $request){
            $input =$request->Mainkey;
            
            $Getdisname = District::where('Mainkey',$input)->first();
            $DisName =$Getdisname->Name;
            return response()->json($DisName);
    }

}
