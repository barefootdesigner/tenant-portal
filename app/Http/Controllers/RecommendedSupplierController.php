<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecommendedSupplier;
use App\Models\SupplierCategory;

class RecommendedSupplierController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->input('category');

        $categories = SupplierCategory::all();

        $suppliers = RecommendedSupplier::query()
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('supplier_category_id', $categoryId);
            })
            ->with('supplierCategory')
            ->orderBy('name')
            ->get();

        return view('tenant.suppliers.index', compact('suppliers', 'categories', 'categoryId'));
    }
}
