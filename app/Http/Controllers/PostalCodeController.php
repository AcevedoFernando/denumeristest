<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostalCodeRequest;
use App\Imports\PostalCodesImport;
use App\Models\PostalCode;
use Maatwebsite\Excel\Facades\Excel;

class PostalCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Params
            $state = request()->get('state', false);
            $township = request()->get('township', false);
            $orderBy = request()->get('orderBy', 'asc');
            $limit = request()->get('limit', 10);

            // Query
            $postal_codes = PostalCode::select('code', 'township', 'state');

            if ($state == "null" && $township == "null")
                $postal_codes->limit(100); // Limit only if filtersare not specified
            else {
                // Search Matches 
                $postal_codes->where([['state', 'LIKE', '%' . $state . '%'], ['township', 'LIKE', '%' . $township . '%']]);
            }
            // Query end
            $postal_codes = $postal_codes->get();

            // Get prices and turn them into a fix
            $api_prices = json_decode(file_get_contents("https://api.datos.gob.mx/v2/precio.gasolina.publico?pageSize=10000"), true);

            $prices = [];

            // Match API results with postal codes 
            foreach ($api_prices['results'] as $price) {
                // if exists postal code
                if ($postal_code_index = array_search($price['codigopostal'], array_column($postal_codes->toArray(), 'code')))
                    array_push($prices, array_merge(  // Merge price info with postal code 
                        $price,
                        [
                            'municipio' => $postal_codes->toArray()[$postal_code_index]['township'],
                            'estado' => $postal_codes->toArray()[$postal_code_index]['state']
                        ]
                    ));

                if (sizeof($prices) >= $limit) break; // Break if the limit was reached
            };

            // Sort by price
            $sorted = $orderBy == 'asc' ? collect($prices)->sortBy('regular') : collect($prices)->sortByDesc('regular');
            $pricesSorted = [];

            // Remove unnecessary sort index
            foreach ($sorted as $sort)
                array_push($pricesSorted, $sort);

            // Success Response 
            return response()->json([
                'success' => true,
                'count' => sizeof($pricesSorted),
                'results' => $pricesSorted
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'serverError' => [$e->getMessage()]], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostalCodeRequest $request)
    {
        try {
            // Import new postal codes with an Excell file
            Excel::import(new PostalCodesImport, $request->file('file'));
            // Success Response
            return response()->json(['success' => true], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'serverError' => [$e->getMessage()]
            ], 500);
        }
    }
}
