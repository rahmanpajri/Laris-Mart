<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryItem;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryItem::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
        ]);

        $category = CategoryItem::create($request->all());
        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required',
        ]);

        $category = CategoryItem::findOrFail($id);
        $category->update($request->all());
        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = CategoryItem::findOrFail($id);

        if ($category->items()->count() > 0) {
            return response()->json([
                'error' => 'Jenis Barang ini tidak bisa dihapus karena masih digunakan oleh item.'
            ], 400);
        }

        $category->delete();

        return response()->json(['success' => 'Jenis Barang berhasil dihapus.']);
    }
}
