<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['product'] = Product::with('category')->paginate(5);
        return view('product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::all();
        return view('product.create', $data);
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
            'price' => 'required|numeric',
            'about' => 'required|min:5',
            'picture' => 'mimes:jpg,png,jpeg|max:2000',
            'category_id' => 'required',
            'is_active' => 'required',
        ]);

        try {
            $data = $request->except(['_token', 'picture']);
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $file_name = time() . '.' . $file->extension();
                $file->move(public_path('img/product'), $file_name);
                $data['picture'] = $file_name;
            }
            Product::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('product')->with('flash-success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data['product'] = $product;
        $data['categories'] = Category::all();
        return view('product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'about' => 'required|min:5',
            'picture' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'category_id' => 'required',
            'is_active' => 'required',
        ]);

        try {
            $data = $request->except(['_token', 'picture']);

            // check if user upload new picture
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $file_name = time() . "_" . $product->id . "." . $file->extension();
                $file->move(public_path('img/product'), $file_name);
                $data['picture'] = $file_name;

                // delete old picture if exist
                $old_picture = public_path('img/product/' . $product->picture);
                if (file_exists($old_picture) && !empty($product->picture)) {
                    unlink($old_picture);
                }
            }
            $product->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }


        return redirect()->back()->with('flash-success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // check old picture if exist
        $old_picture = public_path('img/product/' . $product->picture);
        if (file_exists($old_picture) && !empty($product->picture)) {
            unlink($old_picture);
        }
        $product->delete();

        return redirect('product')->with('flash-danger', 'Data berhasil dihapus!');
    }
}
