<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{

    public function index()
    {
        $response = Http::get('http://127.0.0.1:8000/api/categories');
        $categories = $response->json();

        return view('categories.index', ['categories' => $categories]);
    }
}
