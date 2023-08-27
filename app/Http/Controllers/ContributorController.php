<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContributorRequest;
use App\Models\Collection;
use App\Models\Contributor;
use Illuminate\Http\Request;

class ContributorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $collections=Contributor::all();
        return response()->json([
            'collections' => $collections,
        ]);
    }

    public function store(StoreContributorRequest $request){

        $created = Contributor::create($request->all());

        return response()->json([
            'created'=>$created
        ]);
    }

}
