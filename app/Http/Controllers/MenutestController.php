<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenutestController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::all();
        return view('menutest', compact('menuItems'));
    }
}