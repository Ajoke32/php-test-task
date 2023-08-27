<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionRequest;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Mockery\Exception;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            $collections = Collection::all();
            return response()->json([
                'collections' => new CollectionResource($collections),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    public function store(StoreCollectionRequest $request)
    {
        try {
            $created = Collection::create($request->all());
            return response()->json([
                'created' => $created
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    public function details(Request $request)
    {
        try {
            $collection = Collection::where('id', '=', $request->id);

            return response()->json([
                'collection' => $collection
                    ->with("contributor")
                    ->get()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    public function remainsToCollect(Request $request)
    {

        if (!isset($request->remains)) {
            return response()->json([
                "error" => "remains input required"
            ]);
        }

        try {
            return response()->json([
                "collections" => Collection::
                select("collections.title", "contributors.amount", "collections.target_amount")
                    ->join('contributors', 'collections.id', '=', 'contributors.collection_id')
                    ->groupBy("contributors.amount", "collections.target_amount", 'collections.id', "collections.title")
                    ->havingRaw("collections.target_amount - (SELECT SUM(c.amount) FROM contributors c where c.collection_id = collections.id) = ?", [$request->remains])
                    ->get()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }

    }

    public function lessThanTarget(Request $request)
    {
        try {
            return response()->json([
                "collections" => Collection::select("collections.title", "contributors.amount", "collections.target_amount")
                    ->join('contributors', 'collections.id', '=', 'contributors.collection_id')
                    ->groupBy("contributors.amount", "collections.target_amount", 'collections.id', "collections.title")
                    ->havingRaw("(SELECT SUM(amount) FROM contributors where contributors.collection_id=collections.id)<collections.target_amount")
                    ->get()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }

    }
}

