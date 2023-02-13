<?php

namespace App\Http\Controllers;

use App\Models\CryptoTransaction;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CryptoHistoryController extends Controller
{
    public function show(): Application|Factory|View
    {
        $account = Auth::user()->accounts;
        $error = '';
        return view(
            'auth.cryptoHistory',
            ['accounts' => $account, 'results' => [], 'filterAccount' => null, 'error' => $error]);
    }

    public function filter(Request $request): View
    {
        $account = Auth::user()->accounts;
        $dateFrom = explode(" ", $request->input('selected_date_from'))[0];
        $dateTo = explode(" ", $request->input('selected_date_to'))[0];
        $interval = $this->dateDifference($dateFrom, $dateTo);
        $filterAccount = $request->get('accountNumber');
        $date1 = Carbon::parse($dateFrom);
        $date2 = Carbon::parse($dateTo);
        $result = [];
        $error = '';

        if($interval) {

            $transactions = CryptoTransaction::where('from_account', $filterAccount)
                ->orWhere('to_account', $filterAccount)
                ->get();

        }else{

            $transactions=[];
            $error = 'The date interval must be less or equal than one year';
        }

        if(strlen($dateTo)!=0 && strlen($dateFrom)!=0){
            foreach($transactions as $transaction){
                $date = Carbon::parse(explode(" ", $transaction->created_at)[0]);
                if($date->gt($date1) && $date->lt($date2)){
                    $result[]= $transaction;
                }
            }
        }

        return view(
            'auth.cryptoHistory',
            ['accounts' => $account, 'results' => $result, 'filterAccount' => $filterAccount, 'error' => $error]);
    }

    private function dateDifference(string $date1, string $date2)
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
