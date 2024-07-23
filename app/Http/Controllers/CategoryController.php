<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoryItem;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryItem::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
        ]);

        CategoryItem::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, CategoryItem $category)
    {
        $request->validate([
            'category' => 'required',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy(CategoryItem $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Barang berhasil dihapus.');
    }
}
