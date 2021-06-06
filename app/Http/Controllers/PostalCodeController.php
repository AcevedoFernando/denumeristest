<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostalCodeRequest;
use App\Imports\PostalCodesImport;
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
        return 'index';
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'show';
    }
}
