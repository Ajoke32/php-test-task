<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContributorRequest;
use App\Models\Collection;
use App\Models\Contributor;
use Illuminate\Http\Request;
use Mockery\Exception;

class ContributorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try{
            $collections = Contributor::all();
            return response()->json([
                'collections' => $collections,
            ]);
        }catch (Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'code'=>$e->getCode()
            ]);
        }
    }

    public function store(StoreContributorRequest $request){

        try{
            $created = Contributor::create($request->all());

            return response()->json([
                'created'=>$created
            ]);
        }catch (Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'code'=>$e->getCode()
            ]);
        }
    }

}
