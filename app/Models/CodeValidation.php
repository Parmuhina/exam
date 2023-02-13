<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class CodeValidation
{
    public function checkCodeFour(string $codeFour, int $number): bool
    {
        $account= Auth::user()->accounts;

        $codesFour = Code::where('user_id', $account[0]->user_id)
            ->get()
            ->firstOrFail();

        $explodedCodesFour = explode(' ', $codesFour->four_digit);
        return $explodedCodesFour[$number-1] === $codeFour;
    }

}
