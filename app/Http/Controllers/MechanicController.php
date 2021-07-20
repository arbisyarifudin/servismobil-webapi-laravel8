<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['mechanic'] = Mechanic::paginate(5);
        // dd($data);
        return view('mechanic.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mechanic.create');
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
            'nin' => 'nullable|digits:16|unique:mechanics,nin',
            'phone' => 'nullable|digits_between:7,20|unique:mechanics,phone',
            'address' => 'nullable|min:5',
            'photo' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'is_active' => 'required',
        ]);

        try {
            $data = $request->except(['_token', 'photo']);
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $file_name = time() . '.' . $file->extension();
                $file->move(public_path('img/mechanic'), $file_name);
                $data['photo'] = $file_name;
            }
            Mechanic::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('mechanic')->with('flash-success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function show(Mechanic $mechanic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function edit(Mechanic $mechanic)
    {
        $data['mechanic'] = $mechanic;
        return view('mechanic.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mechanic $mechanic)
    {
        $request->validate([
            'name' => 'required|min:3',
            'nin' => 'nullable|digits:16',
            'nin' => 'nullable|digits:16|unique:mechanics,nin',
            'phone' => 'nullable|digits_between:7,20|unique:mechanics,phone',
            'address' => 'nullable|min:5',
            'photo' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'is_active' => 'required',
        ]);

        try {
            $data = $request->except(['_token', 'photo']);

            // check if user upload new photo
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $file_name = time() . "_" . $mechanic->id . "." . $file->extension();
                $file->move(public_path('img/mechanic'), $file_name);
                $data['photo'] = $file_name;

                // delete old photo if exist
                $old_photo = public_path('img/mechanic/' . $mechanic->photo);
                if (file_exists($old_photo) && !empty($mechanic->photo)) {
                    unlink($old_photo);
                }
            }
            $mechanic->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect('mechanic')->with('flash-success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mechanic  $mechanic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mechanic $mechanic)
    {
        // check old photo if exist
        $old_photo = public_path('img/mechanic/' . $mechanic->photo);
        if (file_exists($old_photo) && !empty($mechanic->photo)) {
            unlink($old_photo);
        }
        $mechanic->delete();

        return redirect('mechanic')->with('flash-danger', 'Data berhasil dihapus!');
    }
}
