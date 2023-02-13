<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CodesController extends Controller
{
    public function show(): Application|Factory|View
    {
        $codesFour= Auth::user()->codes->four_digit;
        $codesFive= Auth::user()->codes->five_digit;

        return view('auth.codes',
            [
                'codesFour'=>explode(" ",$codesFour),
                'codesFive'=>explode(" ",$codesFive)
            ]
        );
    }
}
