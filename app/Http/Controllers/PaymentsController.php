<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create()
    {
        return Inertia::render('Payments/Create');
    }
}
