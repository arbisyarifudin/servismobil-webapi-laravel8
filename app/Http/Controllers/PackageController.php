<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['package'] = Package::paginate(5);
        return view('package.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['products'] = Product::all();
        return view('package.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'about' => 'required|min:5',
            'product_id' => 'required|array|min:1',
        ]);


        DB::beginTransaction();
        try {
            $package = Package::create($request->except('_token'));

            foreach ($request->product_id as $key => $id) {
                $data[$key]['product_id'] = $id;
                $data[$key]['package_id'] = $package->id;
            }
            // dd($data);

            PackageProduct::insert($data);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }


        return redirect('package')->with('flash-success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        // $data['package'] = $package;
        $data['package'] = $package;
        $data['products'] = $package->products ??  [];
        // dd($data['package']);
        return view('package.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|min:3',
            'about' => 'required|min:5',
            'product_id' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $package->update($request->except('_token'));

            foreach ($request->product_id as $key => $id) {
                $data[$key]['product_id'] = $id;
                $data[$key]['package_id'] = $package->id;
                // $cek = PackageProduct::where('product_id', $id)->where('package_id', $package->id)->count();
                // if ($cek == 0) {
                //     $data['product_id'] = $id;
                //     $data['package_id'] = $package->id;
                //     PackageProduct::create($data);
                // }
            }

            PackageProduct::where('package_id', $package->id)->delete();
            PackageProduct::insert($data);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }


        return redirect()->back()->with('flash-success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect('package')->with('flash-danger', 'Data berhasil dihapus!');
    }
}
