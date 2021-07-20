<?php

namespace App\Http\Controllers;

use App\Models\PackageProduct;
use Illuminate\Http\Request;

class PackageProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PackageProduct  $packageProduct
     * @return \Illuminate\Http\Response
     */
    public function show(PackageProduct $packageProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PackageProduct  $packageProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(PackageProduct $packageProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PackageProduct  $packageProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PackageProduct $packageProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PackageProduct  $packageProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackageProduct $packageProduct)
    {
        $packageProduct->delete();

        return redirect()->back()->with('flash-danger', 'Produk paket berhasil dihapus!');
    }
}
