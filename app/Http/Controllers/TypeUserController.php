<?php

namespace App\Http\Controllers;

use App\Models\TypeUser;
use Illuminate\Http\Request;

class TypeUserController extends Controller
{
    public function index()
    {
        $typeUser = TypeUser::all();

        return response()->json([
            'red' => true,
            'data' => $typeUser
        ], 200);
    }
}