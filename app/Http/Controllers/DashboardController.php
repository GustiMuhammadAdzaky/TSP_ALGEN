<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\RuteOptimal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()  {

        $data = [
            "destinasi" => Destinasi::count(),
            "optimasi" => RuteOptimal::count()
        ];

        return view('dashboard', compact("data"));
    }
}
