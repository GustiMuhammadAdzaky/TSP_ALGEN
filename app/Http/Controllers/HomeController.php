<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $destinasi = Destinasi::all();
        $title = "Halaman Home";
        return view("home", compact("destinasi", "title"));
    }
}
