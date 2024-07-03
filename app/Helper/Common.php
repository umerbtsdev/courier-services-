<?php

namespace App\Helper;
use Auth;
use Config;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Model\CityManagment\City;
use Session;
use Exception;
use DB;
use App\User;
use App\Model\Transactions\Transactions;
use App\Model\Transactions\TransactionTypes;
use App\Model\ChartofAccount\chartofaccount;
class Common {

	static public function sendEmail($to,$subject,$body,$cc = ""){
		
		$from = "support@sellerdesk.com";
		
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers .= "From: ".$from . "\r\n" ;
		
		if(!empty($cc)){
			$headers.= "BCC: ".$cc;
		}
		
			 //Mail functionality disable by product team. 
			//	mail($to,$subject,$body,$headers);
	}

	
	//GET LOGIN VENDOR ID

	//GET VENDOR WAREHOUSE LIST

    //user wise permission
    static public function userwisepermission($userid, $permission){

      $permission_exist = 0;
        $user = \App\User::findOrfail($userid);

        $role = isset($user->roles)?$user->roles:array();
        //$role->hasPermissionTo($permission);

        foreach ($role->pluck('id') as $per)
        {

            $ro = Role::findOrFail($per);
            $ro->hasPermissionTo($permission);
            if ($ro->hasPermissionTo($permission) == true)
            {
                $permission_exist = 1;
            }

        }

        return $permission_exist;

    }
    static public function getuserbranch($userid){

        return User::join('employee','employee.user_id','=','users.id')
            ->select('employee.branch_id')
            ->where('users.id','=',$userid)->first();
    }
    static function storeFile($file, $folder = 'forms', $disk = 'public')
    {
        return $file->store($folder, ['disk' => $disk]);
    }
    static public function sendmail($data, $tosendmail, $tomailname, $subject){
        Mail::send('emails.reminder', compact('data'), function ($m) use ($tosendmail, $tomailname,$subject) {
            $m->from('logistic@icsgroup.com.pk', 'Transport Management System');

            $m->to($tosendmail, $tomailname)->subject($subject);
        });
        if (Mail::failures()) {
            return "mail fail";
        }
        else{
            return "mail send";
        }
    }

    static public function makeTransaction($accountID,$type,$referenceID,$amount,$transactionDate,$transactionType){

        $TransactionTypes = TransactionTypes::where('name','=',$type)->select('id')->first();
        $TransactionTypeID = $TransactionTypes->id;

        $description = "Invoice #".$referenceID;


        $Transactions = new Transactions();
            $Transactions->account_id = $accountID;
            if($transactionType == "debit"){
                $Transactions->debit = $amount;
            }
            else if($transactionType == "credit"){
                $Transactions->credit = $amount;
            }
            $Transactions->description = $description;
            $Transactions->type_id = $TransactionTypeID;
            $Transactions->reference_id = $referenceID;
            $Transactions->transaction_date = $transactionDate;
            $Transactions->created_at = date('Y-m-d H:i:s');
            $Transactions->created_by = Auth::User()->id;
        $Transactions->save();

        
    }

    static public function updateTransaction($reference_id,$transactionDate,$transactionType)
    {
        if($transactionType == "debit"){
            $Transactions = Transactions::where('reference_id','=',$reference_id)->where('debit','=',null)->first();   
        }
        else if($transactionType == "credit"){
            $Transactions = Transactions::where('reference_id','=',$reference_id)->where('credit','=',null)->first();   
        }
            $Transactions->transaction_date = $transactionDate;
            $Transactions->updated_at = date('Y-m-d H:i:s');
            $Transactions->updated_by = Auth::User()->id;
        $Transactions->save();
    }

    static public function deleteTransaction($reference_id)
    {
        Transactions::where('reference_id','=',$reference_id)->delete();
    }
    
    static public function displaywords($number)
    {
        $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
        $digits = array('', '', 'hundred', 'thousand', 'lakh', 'crore');
       
        $number = explode(".", $number);
        $result = array("","");
        $j =0;
        foreach($number as $val){
            // loop each part of number, right and left of dot
            for($i=0;$i<strlen($val);$i++){
                // look at each part of the number separately  [1] [5] [4] [2]  and  [5] [8]
                
                $numberpart = str_pad($val[$i], strlen($val)-$i, "0", STR_PAD_RIGHT); // make 1 => 1000, 5 => 500, 4 => 40 etc.
                if($numberpart <= 20){
                    $numberpart = 1*substr($val, $i,2);
                    $i++;
                    $result[$j] .= $words[$numberpart] ." ";
                }else{
                    //echo $numberpart . "<br>\n"; //debug
                    if($numberpart > 90){  // more than 90 and it needs a $digit.
                        $result[$j] .= $words[$val[$i]] . " " . $digits[strlen($numberpart)-1] . " "; 
                    }else if($numberpart != 0){ // don't print zero
                        $result[$j] .= $words[str_pad($val[$i], strlen($val)-$i, "0", STR_PAD_RIGHT)] ." ";
                    }
                }
            }
            $j++;
        }
        if(trim($result[0]) != "") echo $result[0] . "Rupees ";
        if($result[1] != "") echo $result[1] . "Paise";
        echo " Only";
    }

}


