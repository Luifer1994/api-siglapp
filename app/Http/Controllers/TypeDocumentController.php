<?php

namespace App\Http\Controllers;

use App\Models\TypeDocument;
use Illuminate\Http\Request;

class TypeDocumentController extends Controller
{
    public function index()
    {
        $typeDocuments = TypeDocument::all();

        return response()->json([
            'red' => true,
            'data' => $typeDocuments
        ], 200);
    }
}