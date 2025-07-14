<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class TenantDocumentController extends Controller
{
    public function index()
    {
        $user = auth()->user()->fresh();

        $documentsQuery = Document::where('is_global', true);

        if ($user->business) {
            $documentsQuery->orWhereHas('businesses', function ($query) use ($user) {
                $query->where('businesses.id', $user->business->id);
            });
        }

        $documentsQuery->orWhereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        });

        $documents = $documentsQuery->orderBy('created_at', 'desc')->get();

        return view('tenant.documents.index', compact('documents'));
    }
}
