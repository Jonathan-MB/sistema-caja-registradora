<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class FallbackController extends Controller
{
    public function fallback(Request $request)
    {
        return view('rutaNoEncontrada404');
    }
}
