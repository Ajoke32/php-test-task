<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionRequest;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $collections=Collection::all();
        return response()->json([
            'status' => 'success',
            'collections' => $collections,
        ]);
    }

    public function store(StoreCollectionRequest $request){

        $created = Collection::create($request->all());
        return response()->json([
            'created'=>$created
        ]);
    }

    public function details(Request $request){

        $collection = Collection::where('id','=',$request->id);

        return response()->json(
            [
                'collection'=>$collection
                    ->with("contributor")
                    ->get()
            ]
        );
    }

    public function remainsToCollect(Request $request){

        if(isset($request->remains)) {
            return response()->json([
                "collections" => Collection::
                select("collections.title", "contributors.amount", "collections.target_amount")
                    ->join('contributors', 'collections.id', '=', 'contributors.collection_id')
                    ->groupBy("contributors.amount", "collections.target_amount", 'collections.id', "collections.title")
                    ->havingRaw("collections.target_amount - (SELECT SUM(c.amount) FROM contributors c where c.collection_id = collections.id) = ?",[$request->remains])
                    ->get()
            ]);
        }

        return response()->json([
           "error"=>"remains input required"
        ]);
    }

    public function lessThanTarget(Request $request){

        return response()->json([
           "collections"=>Collection::select("collections.title", "contributors.amount", "collections.target_amount")
               ->join('contributors', 'collections.id', '=', 'contributors.collection_id')
               ->groupBy("contributors.amount", "collections.target_amount", 'collections.id', "collections.title")
               ->havingRaw("(SELECT SUM(amount) FROM contributors where contributors.collection_id=collections.id)<collections.target_amount")
               ->get()
        ]);
    }
}

