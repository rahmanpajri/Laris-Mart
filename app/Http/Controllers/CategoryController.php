<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    protected $apiUrl = 'http://127.0.0.1/Laris-Mart/public/api/categories';

    public function index()
    {
        $response = Http::get($this->apiUrl);
        $categories = $response->json();

        return view('categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
        ]);

        Http::post($this->apiUrl, $request->all());

        return redirect()->route('categories.index')->with('success', 'Jenis Barang berhasil ditambahkan..');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
        ]);

        Http::put("{$this->apiUrl}/{$id}", $request->all());

        return redirect()->route('categories.index')->with('success', 'Jenis Barang berhasil di update..');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiUrl}/{$id}");

        if ($response->failed()) {
            $error = $response->json()['error'];
            return redirect()->route('categories.index')->withErrors(['category' => $error]);
        }

        return redirect()->route('categories.index')->with('success', 'Jenis Barang berhasil dihapus.');
    }
}
