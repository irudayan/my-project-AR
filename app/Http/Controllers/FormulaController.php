<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\church;
use App\Models\Common;
use App\Models\Ethnicity;
use App\Models\Mainsection;
use App\Models\Subsection;
use App\Models\Pagesection;
use App\Models\Ethnicitydropdown;
use App\Models\Languagedropdown;
use App\Models\Annualreport;
use App\Models\User;
use App\Models\ReportSectionStatus;
use App\Helpers\ARHelper;
use App\Models\District;
use App\Models\Questions;
use DB;
use Carbon\Carbon;

class FormulaController extends Controller
{

    public function formulaenableQuestions(Request $request)
    {
        $input = $request->all();
        $Questions = Questions::where('Pagesection',$input['val'])
        // ->where('Questype','Numeric')
        ->whereIn('Questype', Array('Numeric','Formula'))
        ->get();
        return response()->json(['Questions' => $Questions]);
    }

    public function FormulaCalulate(Request $request)
    {
        $input = $request->all();
        $formData = $input['data'];
        
        $add = [];
        $sub = [];
        $sendData = [];
        
        foreach($formData as $value){

            $Questions = Questions::where('Questioncode',$value['code'])->first();

            $QuestionCode = $Questions->Questioncode;

            $Formula = $Questions->Formula;

            if($Formula != null){
                $seprateOperation  = explode(";",$Formula);

                foreach($seprateOperation as $value2){
                    
                    $ArthOperator  = explode(":",$value2);

                    $operation = $ArthOperator[0];

                    if($operation == "Add"){

                        $operationFields = explode(",",$ArthOperator[1]);

                        foreach($operationFields as $fieldcode1){
                            $add[] = $formData[$fieldcode1]['val'];
                        }

                    }
                    if($operation == "Sub"){
                        $operationFields = explode(",",$ArthOperator[1]);
                        foreach($operationFields as $fieldcode2){
                            $sub[] = $formData[$fieldcode2]['val'];
                        }

                    }

                }

                $sendadd = array_sum($add);
                $sendsub = array_sum($sub);

                unset($add);
                $add = array();
                unset($sub);
                $sub = array();

                if($sendadd != 0){
                    $a = $sendadd;
                }else{
                    $a = 0;
                }

                if($sendsub != 0){
                    $s = $sendsub;
                }else{
                    $s = 0;
                }
                
                $all = ($a-$s);

                $sendData[] = [
                    'val' => $all,
                    'code' =>  $QuestionCode
                ];
 
            }

        }
        return response()->json(['dataVal' => $sendData]);
    }

    public function multinumericformula(Request $request)
    {

        $input = $request->all();
        
        $formData = $input['Formdatas'];
        $formula = $input['formula'];

        foreach($formula as $key => $value){
            $QuestionCode = $key;
            $Formula = $value;
        }
        
        $add = [];
        $sub = [];
        $sendData = [];
        
        if($Formula != null){
            $seprateOperation  = explode(";",$Formula);

            foreach($seprateOperation as $value){
                
                $ArthOperator  = explode(":",$value);

                $operation = $ArthOperator[0];

                if($operation == "Add"){

                    $operationFields = explode(",",$ArthOperator[1]);

                    foreach($operationFields as $fieldcode1){
                        $add[] = $formData[$fieldcode1]['val'];
                    }

                }
                if($operation == "Sub"){
                    $operationFields = explode(",",$ArthOperator[1]);
                    foreach($operationFields as $fieldcode2){
                        $sub[] = $formData[$fieldcode2]['val'];
                    }

                }

            }

            $sendadd = array_sum($add);
            $sendsub = array_sum($sub);

            if($sendadd != 0){
                $a = $sendadd;
            }else{
                $a = 0;
            }

            if($sendsub != 0){
                $s = $sendsub;
            }else{
                $s = 0;
            }
            
            $num = ($a-$s);

            $numericValue = $num;
            $QuestionCode = $QuestionCode;

        }
        return response()->json(['numericValue' => $numericValue,'QuestionCode' => $QuestionCode]);
    }


}
