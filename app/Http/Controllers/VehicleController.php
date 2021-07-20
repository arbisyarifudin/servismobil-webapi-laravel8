<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
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
        $data['customers'] = Customer::all();

        if (request()->query('ref_customer') && !empty(request()->query('ref_customer'))) {
            $data['customer'] = Customer::find(request()->query('ref_customer'));
        }

        return view('vehicle.create', $data);
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
            'brand' => 'required',
            'year' => 'required|numeric',
            'plate_number' => 'required|unique:vehicles,plate_number',
            'chassis_number' => 'required|numeric|unique:vehicles,chassis_number',
            'customer_id' => 'required',
        ]);

        try {
            $data = $request->except('_token');
            $data['plate_number'] = strtoupper($request->plate_number);
            Vehicle::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        $redirect = "vehicle";
        // if ($request->has('ref') && !empty($request->get('ref'))) {
        //     $redirect = $request->get('ref');
        // }
        if ($request->has('ref_customer') && !empty($request->get('ref_customer'))) {
            $redirect = "customer/" . $request->get('ref_customer');
        }

        return redirect($redirect)->with('flash-success', 'Data berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        $data['customers'] = Customer::all();

        if (request()->query('ref_customer') && !empty(request()->query('ref_customer'))) {
            $data['customer'] = Customer::find(request()->query('ref_customer'));
        }
        $data['vehicle'] = $vehicle;
        return view('vehicle.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $uniqPlate = "";
        $uniqChassis = "";
        if ($vehicle->plate_number != $request->plate_number) {
            $uniqPlate = "|unique:vehicles,plate_number";
        }

        if ($vehicle->chassis_number != $request->chassis_number) {
            $uniqChassis = "|unique:vehicles,chassis_number";
        }

        $request->validate([
            'name' => 'required|min:3',
            'brand' => 'required',
            'year' => 'required|numeric',
            'plate_number' => 'required' . $uniqPlate,
            'chassis_number' => 'required|numeric' . $uniqChassis,
            'customer_id' => 'required',
        ]);

        $vehicle->update($request->except('_token'));

        return redirect()->back()->with('flash-success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle, Request $request)
    {
        $vehicle->delete();

        if ($request->has('ref')) {
            $redirect = $request->get('ref');
        } else {
            $redirect = 'vehicle';
        }

        // echo $redirect;
        // die;

        return redirect($redirect)->with('flash-danger', 'Data berhasil dihapus!');
    }
}
