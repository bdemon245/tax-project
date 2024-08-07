<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $banners = Banner::latest()->latest()->get();
        $purchaseItem = Purchase::where('user_id', auth()->id())->orderBy('id', 'desc')->take(10)->latest()->get();

        return view('frontend.pages.purchasesItems.purchases', compact('purchaseItem', 'banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase) {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase) {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase) {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase) {
    }
}
