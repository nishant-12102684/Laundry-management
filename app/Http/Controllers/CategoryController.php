<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in the database.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_unit' => 'required|numeric|min:0'
        ]);

        // Create a new category record
        Category::create([
            'name' => $request->input('name'),
            'price_per_unit' => $request->input('price_per_unit')
        ]);

        // Redirect to categories index with a success message
        return redirect()->route('categories.index')
            ->with('success', 'Category added successfully');
    }
}
