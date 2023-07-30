<?php

namespace App\Http\Controllers\Backend\Chalan;

use App\Models\Chalan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.chalan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.chalan.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chalan $chalan)
    {
        return view('backend.chalan.show');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chalan $chalan)
    {
        return view('backend.chalan.clone');
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chalan $chalan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chalan $chalan)
    {
        //
    }
}
