<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Menampilkan semua kategori milik user yang login
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $categories = Category::where('user_id', $userId)->latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Form tambah kategori
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $validated['user_id'] = Auth::user()->id;

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Form edit kategori
     */
    public function edit(Category $category)
    {
        $this->authorizeAccess($category);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update data kategori
     */
    public function update(Request $request, Category $category)
    {
        $this->authorizeAccess($category);

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * Hapus kategori
     */
    public function destroy(Category $category)
    {
        $this->authorizeAccess($category);
        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * Validasi agar hanya owner bisa akses
     */
    private function authorizeAccess(Category $category): void
    {
        if ($category->user_id !== Auth::user()->id) {
            abort(403, 'Akses ditolak');
        }
    }
}
