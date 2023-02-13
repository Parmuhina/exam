<?php

namespace App\Http\Controllers;

use App\Models\CurrencyTransaction;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PaymentHistoryController extends Controller
{
   public function show(): View
   {
       $account= Auth::user()->accounts;
       return view(
           'auth.paymentHistory',
           ['accounts'=>$account, 'results'=>[], 'filterAccount'=>null, 'error'=>'']);
   }

   public function filter(Request $request): View
   {
       $error='';
       $account= Auth::user()->accounts;
       $dateFrom =explode(" ",$request->input('selected_date_from'))[0];
       $dateTo = explode(" ", $request->input('selected_date_to'))[0];
       $interval = $this->dateDifference($dateFrom, $dateTo);
       $filterAccount = $request->get('accountNumber');
       $sendersName = $request->get('sendersName');
       $date1 = Carbon::parse($dateFrom);
       $date2 = Carbon::parse($dateTo);
       $result=[];

        if($interval) {
            $transactions = CurrencyTransaction::where('from_account', $filterAccount)
                ->orWhere('to_account', $filterAccount)
                ->get();
        }else{
            $transactions=[];
            $error = 'The date interval must be less or equal than one year';
        }
        if(strlen($sendersName)!=0 && strlen($dateTo)!=0 && strlen($dateFrom)!=0){
            foreach($transactions as $transaction){
                $date = Carbon::parse(explode(" ", $transaction->created_at)[0]);
                if($transaction->senders_name===$sendersName && $date->gt($date1) && $date->lt($date2)){
                    $result[]= $transaction;
                }
            }
        }elseif(strlen($sendersName)!=0 ){
           foreach($transactions as $transaction){
               if($transaction->senders_name===$sendersName){
                   $result[]= $transaction;
               }
           }
       }elseif(strlen($dateTo)!=0 && strlen($dateFrom)!=0){
           foreach($transactions as $transaction){
               $date = Carbon::parse(explode(" ", $transaction->created_at)[0]);
               if($date->gt($date1) && $date->lt($date2)){
                   $result[]= $transaction;
               }
           }
       }

       return view(
           'auth.paymentHistory',
           ['accounts'=>$account,'results'=>$result, 'filterAccount'=>$filterAccount, 'error'=>$error]);
   }

   private function dateDifference($date1, $date2)
   {
       $carbon_date1 = Carbon::parse($date1);
       $carbon_date2 = Carbon::parse($date2);

       $difference_in_days = $carbon_date1->diffInDays($carbon_date2);
       $difference_in_years = $carbon_date1->diffInYears($carbon_date2);

       // Calculate the number of leap years in the difference
       $leap_years = 0;
       for ($year = $carbon_date1->year; $year < $carbon_date1->year + $difference_in_years; $year++) {
           if (Carbon::createFromDate($year, 1, 1)->isLeapYear()) {
               $leap_years++;
           }
       }

       // Subtract the number of extra days in the leap years
       $difference_in_days -= $leap_years;

       return $difference_in_days <= 365;
   }
}
