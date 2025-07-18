<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedSupplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'website',
        'logo_path',
        'supplier_category_id',
    ];

    public function supplierCategory()
    {
        return $this->belongsTo(SupplierCategory::class);
    }
}
