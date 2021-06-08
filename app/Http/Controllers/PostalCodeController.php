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
            $state = request()->get('state', false);
            $township = request()->get('township', false);
            $orderBy = request()->get('orderBy', 'asc');
            $limit = request()->get('limit', 10);

            $postal_codes = PostalCode::select('code', 'township', 'state');

            if ($state == "null" && $township == "null")
                $postal_codes->limit(100);
            else {
                $postal_codes->where('state', 'LIKE', '%' . $state . '%');
                $postal_codes->where('township', 'LIKE', '%' . $township . '%');
            }

            $postal_codes = $postal_codes->get();

            $api_prices = json_decode(file_get_contents("https://api.datos.gob.mx/v2/precio.gasolina.publico?pageSize=10000"), true);

            $prices = [];

            foreach ($api_prices['results'] as $price) {
                if ($postal_code_index = array_search($price['codigopostal'], array_column($postal_codes->toArray(), 'code')))
                    array_push($prices, array_merge(
                        $price,
                        [
                            'municipio' => $postal_codes->toArray()[$postal_code_index]['township'],
                            'estado' => $postal_codes->toArray()[$postal_code_index]['state']
                        ]
                    ));

                if (sizeof($prices) >= $limit) break;
            };

            $sorted = $orderBy == 'asc' ? collect($prices)->sortBy('regular') : collect($prices)->sortByDesc('regular');
            $pricesSorted = [];

            foreach ($sorted as $sort)
                array_push($pricesSorted, $sort);


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
            Excel::import(new PostalCodesImport, $request->file('file'));
            return response()->json(['success' => true], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'serverError' => [$e->getMessage()]
            ], 500);
        }
    }
}
