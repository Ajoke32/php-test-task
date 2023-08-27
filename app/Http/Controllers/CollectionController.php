<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $todos = ["do","work"];
        return response()->json([
            'status' => 'success',
            'todos' => $todos,
        ]);
    }
}
