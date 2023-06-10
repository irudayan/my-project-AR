<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\church;
use App\Models\Common;
use App\Models\Annualreport;
use App\Models\Staff;
use App\Models\Mainsection;
use App\Models\Subsection;
use App\Models\Pagesection;
use App\Models\QuestionTypedropdown;
use App\Models\Questions;
use App\Helpers\ARHelper;
use Yajra\DataTables\DataTables;
use DB;

class QuestionsController extends Controller
{

    public function addQuestion(Request $request)
    {
        $mainsection = Mainsection::all();
        $questiontype = QuestionTypedropdown::all();
        return view('adminbackend.includes.addquestions',compact('mainsection','questiontype'));
    }

    public function exportall(Request $request)
    {
        $mainsection = Mainsection::all();
        $questiontype = QuestionTypedropdown::all();
        return view('adminbackend.includes.Exportall',compact('mainsection','questiontype'));
    }
    public function QuestionStore(Request $request)
    {  

        // Formula imploding data start
        $formulaAdd = $request->formulaAdd;
        $formulaSubstract = $request->formulaSubstract;
        $formulaMultiply = $request->formulaMultiply;
        $formulaDivide = $request->formulaDivide;

        if($formulaAdd != null){
            $Add = "Add:".implode(",",array_filter($formulaAdd, 'strlen'));
        }else{
            $Add = '';
        }
        if($formulaSubstract != null){
            $Sub =  "Sub:".implode(",",array_filter($formulaSubstract, 'strlen'));
        }else{
            $Sub = '';
        }
        if($formulaMultiply != null){
            $Mul = "Mul:".implode(",",array_filter($formulaMultiply, 'strlen'));
        }else{
            $Mul = '';
        }
        if($formulaDivide != null){
            $Div = "Div:".implode(",",array_filter($formulaDivide, 'strlen'));
        }else{
            $Div = '';
        }

        $opertion = [
            'Add' => $Add,
            'Sub' => $Sub,
            'Mul' => $Mul,
            'Div' => $Div
        ];

        $formula = implode(";",array_filter($opertion, 'strlen'));

        // Formula imploding data end


        $questiontype = $request->Questype;

        $tabName = strtolower($request->Questioncode);

        $tables = DB::select("SHOW TABLES LIKE '".$tabName."'");
        $counttable = count($tables);
        if($counttable == 0){

            $fieldname = "Name";

            if($questiontype == "Percent"){
                DB::statement("CREATE TABLE ".$tabName."(id INT)");
                DB::statement("ALTER TABLE ".$tabName." ADD PRIMARY KEY (id)");
                DB::statement("ALTER TABLE ".$tabName." MODIFY id INT(10) UNSIGNED AUTO_INCREMENT");
                DB::statement("ALTER TABLE ".$tabName." ADD Mainkey bigint(20) NULL");
                DB::statement("ALTER TABLE ".$tabName." ADD Year bigint(20) NULL");
                DB::statement("ALTER TABLE ".$tabName." ADD Name VARCHAR(255) NULL");
                DB::statement("ALTER TABLE ".$tabName." ADD Percent INT(10) NULL");
                DB::statement("ALTER TABLE ".$tabName." ADD created_at timestamp NULL");
                DB::statement("ALTER TABLE ".$tabName." ADD deleted_at timestamp NULL");
            }

            if($questiontype == "Multi Dropdown"){
                DB::statement("CREATE TABLE ".$tabName."(id INT)");
                DB::statement("ALTER TABLE ".$tabName." ADD PRIMARY KEY (id)");
                DB::statement("ALTER TABLE ".$tabName." MODIFY id INT(10) UNSIGNED AUTO_INCREMENT");
                DB::statement("ALTER TABLE ".$tabName." ADD Mainkey VARCHAR(255) NULL");
                DB::statement("ALTER TABLE ".$tabName." ADD FieldName VARCHAR(255) NULL");
                DB::statement("ALTER TABLE ".$tabName." ADD created_at timestamp NULL");
                DB::statement("ALTER TABLE ".$tabName." ADD deleted_at timestamp NULL");
            }

        }
 

        $QuesdropdownOption = $request->QuesdropdownOption;
        if(!empty($QuesdropdownOption)){
            $inColumn = implode(", ",array_filter($QuesdropdownOption, 'strlen'));
        }else{
            $inColumn = "";
        }

        $QuesPercentName = $request->QuespercentName;
        if(!empty($QuesPercentName)){
            $QuesPercent = implode(", ",array_filter($QuesPercentName, 'strlen'));
        }else{
            $QuesPercent = "";
        }


        $QuesmultidropdownName = $request->QuesmultidropdownName;
        if(!empty($QuesmultidropdownName)){
            $Quesmultidropdown = implode(", ",array_filter($QuesmultidropdownName, 'strlen'));
        }else{
            $Quesmultidropdown = "";
        }

        $QuesCheckboxName = $request->QuesCheckboxName;
        $QuesCheckboxCode = $request->QuesCheckboxCode;

        if(!empty($QuesCheckboxName)){
            $QuesCheckdata = [];
            foreach($QuesCheckboxName as $key1 => $val) {
                foreach($QuesCheckboxCode as $key2 => $value) {
                    if($value != ""){
                        if($key2 == $key1){
                            $last = $value;
                            $impArray = array($val, $last);
                            $QuesCheckdata[] = implode(':', $impArray);
                        }
                    }
                }
            }
            foreach($QuesCheckboxCode as $key=>$value){
                $fieldname = $value;
                if($fieldname != ""){
                    $baseData = Schema::hasColumn('annual_report', $fieldname);
                    if($baseData == false){
                        DB::statement("ALTER TABLE annual_report ADD ".$fieldname." VARCHAR(255) NULL");
                    }
                }
            }
            $QuesCheckbox = implode(", ",array_filter($QuesCheckdata, 'strlen'));
        }else{
            $QuesCheckbox = "";
        }

        $request->merge([
            'QuesdropdownOption' => $inColumn,
            'QuesCheckbox' => $QuesCheckbox,
            'QuesPercent' => $QuesPercent,
            'Quesmultidropdown' => $Quesmultidropdown,
            'Formula' => $formula
        ]);

        $input = $request->except('_token','QuesCheckboxName','QuesCheckboxCode','QuespercentName','QuesmultidropdownName','formulaAdd','formulaSubstract','formulaDivide','formulaMultiply');
        foreach($input as $key=>$value){
            $fieldname = $key;
            $baseData = Schema::hasColumn('questions', $fieldname);
            if($baseData == false){
                DB::statement("ALTER TABLE questions ADD ".$fieldname." text NULL");
            }
        }

        $Questioncodename = $request->Questioncode ?? '';
        $annualreportData = Schema::hasColumn('annual_report', $Questioncodename);
        if($annualreportData == false){
            DB::statement("ALTER TABLE annual_report ADD ".$Questioncodename." text NULL");
        }

        $questions = new Questions($input);
        $questions->save();

        $Questions = Questions::all();

        return response()->json(['Success' => "Question Created Successfully!"]);
    }

    public function editQuestion($id)
    {
        $val = ARHelper::decryptUrl($id);
        $question = Questions::where('id',$val)->first();
        $mainsection = Mainsection::all();
        $questiontype = QuestionTypedropdown::all();
        return view('adminbackend.includes.addquestions',compact('question','mainsection','questiontype'));
    }

    public function QuestionUpdate(Request $request)
    {
        // Formula imploding data start
        $formulaAdd = $request->formulaAdd;
        $formulaSubstract = $request->formulaSubstract;
        $formulaMultiply = $request->formulaMultiply;
        $formulaDivide = $request->formulaDivide;

        if($formulaAdd != null){
            $Add = "Add:".implode(",",array_filter($formulaAdd, 'strlen'));
        }else{
            $Add = '';
        }
        if($formulaSubstract != null){
            $Sub =  "Sub:".implode(",",array_filter($formulaSubstract, 'strlen'));
        }else{
            $Sub = '';
        }
        if($formulaMultiply != null){
            $Mul = "Mul:".implode(",",array_filter($formulaMultiply, 'strlen'));
        }else{
            $Mul = '';
        }
        if($formulaDivide != null){
            $Div = "Div:".implode(",",array_filter($formulaDivide, 'strlen'));
        }else{
            $Div = '';
        }

        $opertion = [
            'Add' => $Add,
            'Sub' => $Sub,
            'Mul' => $Mul,
            'Div' => $Div
        ];

        $formula = implode(";",array_filter($opertion, 'strlen'));
        // Formula imploding data end

        $QuesdropdownOption = $request->QuesdropdownOption;
        if(!empty($QuesdropdownOption)){
            $inColumn = implode(", ",array_filter($QuesdropdownOption, 'strlen'));
        }else{
            $inColumn = "";
        }

        $QuesPercentName = $request->QuespercentName;
        if(!empty($QuesPercentName)){
            $QuesPercent = implode(", ",array_filter($QuesPercentName, 'strlen'));
        }else{
            $QuesPercent = "";
        }


        $QuesmultidropdownName = $request->QuesmultidropdownName;
        if(!empty($QuesmultidropdownName)){
            $Quesmultidropdown = implode(", ",array_filter($QuesmultidropdownName, 'strlen'));
        }else{
            $Quesmultidropdown = "";
        }

        $QuesCheckboxName = $request->QuesCheckboxName;
        $QuesCheckboxCode = $request->QuesCheckboxCode;

        if(!empty($QuesCheckboxName)){
            $QuesCheckdata = [];
            foreach($QuesCheckboxName as $key1 => $val) {
                foreach($QuesCheckboxCode as $key2 => $value) {
                    if($value != ""){
                        if($key2 == $key1){
                            $last = $value;
                            $impArray = array($val, $last);
                            $QuesCheckdata[] = implode(':', $impArray);
                        }
                    }
                }
            }
            foreach($QuesCheckboxCode as $key=>$value){
                $fieldname = $value;
                if($fieldname != ""){
                    $baseData = Schema::hasColumn('annual_report', $fieldname);
                    if($baseData == false){
                        DB::statement("ALTER TABLE annual_report ADD ".$fieldname." VARCHAR(255) NULL");
                    }
                }
            }
            $QuesCheckbox = implode(", ",array_filter($QuesCheckdata, 'strlen'));
        }else{
            $QuesCheckbox = "";
        }

        if($request->disableCheckbox == ""){
            $disableCheckbox = "";
        }else{
            $disableCheckbox = "Y";
        }

        $request->merge([
            'QuesdropdownOption' => $inColumn,
            'disableCheckbox' => $disableCheckbox,
            'QuesCheckbox' => $QuesCheckbox,
            'QuesPercent' => $QuesPercent,
            'Quesmultidropdown' => $Quesmultidropdown,
            'Formula' => $formula
        ]);

        $input = $request->except('_token','QuesCheckboxName','QuesCheckboxCode','QuespercentName','QuesmultidropdownName','formulaAdd','formulaSubstract','formulaDivide','formulaMultiply');
	
        foreach($input as $key=>$value){
            $fieldname = $key;
            $baseData = Schema::hasColumn('questions', $fieldname);
            if($baseData == false){
                DB::statement("ALTER TABLE questions ADD ".$fieldname." VARCHAR(255) NULL");
            }
        }

        $Questioncodename = $request->Questioncode ?? '';
        $annualreportData = Schema::hasColumn('annual_report', $Questioncodename);
        if($annualreportData == false){
            DB::statement("ALTER TABLE annual_report ADD ".$Questioncodename." text NULL");
        }

        $data = Questions::where('id',$input['id'])->first();
        $data->update($input);
        $Questions = Questions::all();

        return response()->json(['Success' => "Question Updated Successfully!"]);
    }

    public function getsection(Request $request)
    {
        $data = $request->all();

        $sectionval = str_replace('&amp;', '&', $data['val']);
        
        if($data['type'] == "sub"){
            $section = Subsection::where('MainsectionName',$sectionval)->get();
            $sectionId = "sub-section";
            $name = "";
        }
        if($data['type'] == "page"){
            $section = Pagesection::where('SubsectionName',$sectionval)->get();
            $sectionId = "page-section";
            $name = "";

        }
        if($data['type'] == "parent-question"){
            $section = Questions::where('Pagesection',$sectionval)->get();
            $sectionId = "parent-question";
            $name = "QuestionLabel";
        }
        if($data['type'] == "parent-answer"){
            $section = Questions::where('id',$sectionval)->get();
            $sectionId = "parent-question-ans";
            $name = "ParentAnswer";
        }
        return response()->json(['data'=> $section,'sectionId'=> $sectionId,'name'=>$name]);
    }

    public function GetQuesass(Request $request)
    {
        $data = $request->code;
        $questioncode = $request->questioncode;
        $Question = Questions::where($questioncode,$data)->first();
        return response()->json(['data'=> $Question]);
    }

    public function getChild(Request $request)
    {
        $data = $request->all();
        $Question = Questions::where('ParentQuestion',$data['id'])->get();
        return response()->json(['data'=> $Question,'get'=>"multi"]);
    }

    public function getChildAnsQues(Request $request)
    {
        $data = $request->all();
        $Question = Questions::where('ParentQuestion',$data['id'])->where('ParentQuestionAns',$data['val'])->first();
        return response()->json(['data'=> $Question,'get'=>"single"]);
    }

    public function getQuesParent(Request $request)
    {
        $data = $request->all();
        $Question = Questions::where('id',$data['ques'])->first();
        $inputval = Annualreport::select($Question->Questioncode)->where('Mainkey',$data['mainkey'])->where('YearReported',$data['year'])->first();
        $code = $Question->Questioncode;
        $value = $inputval->$code ?? '';
        return response()->json(['dataQues'=> $value]);
    }

    public function getChildAns(Request $request)
    {
        $data = $request->all();
        $inputval = Annualreport::select($data['ques'])->where('Mainkey',$data['mainkey'])->where('YearReported',$data['year'])->first();
        $code = $data['ques'];
        $value = $inputval->$code;
        if($value != null){
            return response()->json(['dataQues'=> $value]);
        }else{
            return response()->json(['dataQues'=> '']);
        }
    }

    public function deleteQuestion(Request $request)
    {
        $id = $request->id;
        $Questioncode = Questions::where('id',$id)->first();

        $QuesCheckbox = $Questioncode->QuesCheckbox ?? '';
        if($QuesCheckbox != ""){
            $getcheckbox = explode(", ",$QuesCheckbox);

            foreach($getcheckbox as $key => $value){
                $checkval = explode(":",$value);
                $baseData = Schema::hasColumn('annual_report', $checkval[1]);
                if($baseData == true){
                    DB::statement("ALTER TABLE `annual_report` DROP $checkval[1]");
                }
            }
        }

        $baseData = Schema::hasColumn('annual_report', $Questioncode->Questioncode);
        
        if($baseData == true){
            DB::statement("ALTER TABLE `annual_report` DROP $Questioncode->Questioncode");
        }
        $Question = Questions::where('id',$id)->delete();
        return response()->json(['data'=> "Question deleted successfully", 'rowid'=> $request->id ]);
    }

    public function updateQuestionposition(Request $request)
    {
        foreach ($request->Position as $key => $Position) {
            $submain = Questions::find($Position['id'])->update(['Position' => $Position['Position']]);
        }
        return response()->json(['data'=> 'success']);
    }
    protected function checkQuestioncode(Request $request)
    {  
        $data= $request->all();
        $route = $data['route'];
        if($route == "add"){
            $user = Questions::all()->where('Questioncode',$data['Questioncode'])->first();
            if ($user) {
                return "false";
            } else {
                return "true";
            }
        }else{
            return "true";
        }
        
    }

}


