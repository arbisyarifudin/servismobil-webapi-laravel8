<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mechanic;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['reservation'] = Reservation::with([
            'customer', 'package.products', 'service.mechanic', 'service.payment', 'vehicle'
        ])->paginate(5);
        // dd($data['reservation']);
        return view('reservation.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['mechanics'] = Mechanic::all();
        $data['packages'] = Package::all();
        $data['customers'] = Customer::all();

        return view('reservation.create', $data);
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
            'customer_id' => 'required',
            'package_id' => 'required',
            'vehicle_id' => 'required',
            'vehicle_complaint' => 'required',
            'reservation_date' => 'required',
            'reservation_time' => 'required',
            'reservation_origin' => 'required',
        ]);

        // $package_products = json_decode($request->products, true);

        $data = $request->except('_token');
        $data['package_detail'] = $request->products;

        DB::beginTransaction();
        try {
            $reservation = Reservation::create($data);
            $servis['reservation_id'] = $reservation->id;
            Service::create($servis);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect('reservation')->with('flash-success', 'Reservasi berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $data['reservation'] = Reservation::with([
            'customer', 'package.products', 'service', 'vehicle'
        ])->where('id', $reservation->id)->first();

        // dd($data['reservation']->toArray());

        $data['mechanics'] = Mechanic::all();

        return view('reservation.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
