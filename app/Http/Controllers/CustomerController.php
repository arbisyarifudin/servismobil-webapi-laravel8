<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['customer'] = Customer::with('vehicles')->paginate(5);
        // dd($data);
        return view('customer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
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
            'email' => 'required|email|unique:customers,email',
            'gender' => 'required',
            'phone' => 'required|digits_between:7,20|unique:customers,phone',
            'address' => 'nullable|min:5',
            'photo' => 'nullable|mimes:jpg,png,jpeg|max:2000',
        ]);

        try {
            $data = $request->except(['photo']);

            // create username from name
            $username = strtolower(str_replace(" ", "", $request->name));
            // username availablity, if not available, add number increment
            $check = Customer::where('username', $username)->count();

            if ($check > 0) {
                $username = $username . ($check + 1);
            }

            $data['username'] = $username;
            $data['password'] = Hash::make(123456);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $file_name = time() . '.' . $file->extension();
                $file->move(public_path('img/customer'), $file_name);
                $data['photo'] = $file_name;
            }
            Customer::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect('customer')->with('flash-success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $data['customer'] = $customer;
        $data['vehicles'] = Vehicle::where('customer_id', $customer->id)->get();
        return view('customer.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $data['customer'] = $customer;
        return view('customer.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $uniqEmail = "";
        $uniqPhone = "";
        if ($customer->email != $request->email) {
            $uniqEmail = "|unique:customers,email";
        }

        if ($customer->phone != $request->phone) {
            $uniqPhone = "|unique:customers,phone";
        }

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email' . $uniqEmail,
            'gender' => 'required',
            'phone' => 'required|digits_between:7,20' . $uniqPhone,
            'address' => 'nullable|min:5',
            'photo' => 'nullable|mimes:jpg,png,jpeg|max:2000',
        ]);

        try {
            $data = $request->except(['photo', 'password']);


            if ($request->has('password') && !empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            // check if user upload new photo
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $file_name = time() . "_" . $customer->id . "." . $file->extension();
                $file->move(public_path('img/customer'), $file_name);
                $data['photo'] = $file_name;

                // delete old photo if exist
                $old_photo = public_path('img/customer/' . $customer->photo);
                if (file_exists($old_photo) && !empty($customer->photo)) {
                    unlink($old_photo);
                }
            }
            $customer->update($data);
        } catch (\Throwable $th) {
            throw $th;
        }


        return redirect()->back()->with('flash-success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        // check old photo if exist
        $old_photo = public_path('img/customer/' . $customer->photo);
        if (file_exists($old_photo) && !empty($customer->photo)) {
            unlink($old_photo);
        }
        $customer->delete();

        return redirect('customer')->with('flash-danger', 'Data berhasil dihapus!');
    }
}
