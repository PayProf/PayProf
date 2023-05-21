<?php

namespace App\Http\Controllers;

use App\Models\Directeur;
use App\Http\Requests\StoreDirecteurRequest;
use App\Http\Requests\UpdateDirecteurRequest;
use App\Http\Controllers\AuthController;

class DirecteurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDirecteurRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirecteurRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Directeur  $directeur
     * @return \Illuminate\Http\Response
     */
    public function show(Directeur $directeur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Directeur  $directeur
     * @return \Illuminate\Http\Response
     */
    public function edit(Directeur $directeur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDirecteurRequest  $request
     * @param  \App\Models\Directeur  $directeur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirecteurRequest $request, Directeur $directeur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Directeur  $directeur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Directeur $directeur)
    {
        //
    }
}
