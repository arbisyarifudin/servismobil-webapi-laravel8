<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['admin'] = Admin::PerLevel()->paginate(5);
        return view('admin.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
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
            'username' => 'required|string|unique:admins,username|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'nin' => 'nullable|digits:16|unique:admins,nin',
            'phone' => 'nullable|digits_between:7,20|unique:admins,phone',
            'address' => 'nullable|min:5',
            'photo' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'level' => 'required',
            'password' => 'required|min:6'
        ]);

        try {
            $data = $request->except(['photo']);
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $file_name = time() . '.' . $file->extension();
                $file->move(public_path('img/admin'), $file_name);
                $data['photo'] = $file_name;
            }
            Admin::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('admin')->with('flash-success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $data['admin'] = $admin;
        return view('admin.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $uniqNin = "";
        $uniqPhone = "";
        if ($admin->email != $request->email) {
            $uniqNin = "|unique:admins,nin";
        }

        if ($admin->phone != $request->phone) {
            $uniqPhone = "|unique:admins,phone";
        }
        $request->validate([
            'name' => 'required|min:3',
            'nin' => 'nullable|digits:16' . $uniqNin,
            'phone' => 'nullable|digits_between:7,20' . $uniqPhone,
            'address' => 'nullable|min:5',
            'photo' => 'nullable|mimes:jpg,png,jpeg|max:2000',
            'level' => 'required',
            'is_active' => 'required',
        ]);

        try {
            $data = $request->except(['photo']);

            if ($request->has('password') && !empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            // check if user upload new photo
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $file_name = time() . "_" . $admin->id . "." . $file->extension();
                $file->move(public_path('img/admin'), $file_name);
                $data['photo'] = $file_name;

                // delete old photo if exist
                $old_photo = public_path('img/admin/' . $admin->photo);
                if (file_exists($old_photo) && !empty($admin->photo)) {
                    unlink($old_photo);
                }
            }
            $admin->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect('admin')->with('flash-success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        // check old photo if exist
        $old_photo = public_path('img/admin/' . $admin->photo);
        if (file_exists($old_photo) && !empty($admin->photo)) {
            unlink($old_photo);
        }
        $admin->delete();

        return redirect('admin')->with('flash-danger', 'Data berhasil dihapus!');
    }
}
