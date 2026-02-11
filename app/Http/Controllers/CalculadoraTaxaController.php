<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculadoraTaxaController extends Controller
{
    public function index()
    {
        return view('pages.calculadora-taxas');
    }
}
