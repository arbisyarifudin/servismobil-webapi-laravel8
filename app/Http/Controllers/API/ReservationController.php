<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::orderBy('reservations.reservation_date', 'desc')
        ->orderBy('reservations.reservation_time', 'desc')->get();

        foreach ($reservations as $key => $item) {
              if (!isset($reservations[$key]->package_price)) {
                       $reservations[$key]->package_price = 0;
                   }
                if ($item->package) {
                    foreach ($item->package->products as $key2 => $package) {
                         $reservations[$key]->package_price += $package->price;
                   }
               } else {
                $reservations[$key]->package_price = 0;
            }

        }


        $response = [
            'success' => true,
            'message' => 'Reservation list',
            'data' => $reservations,
        ];

        return response()->json($response, 200);
    }

    public function mine()
    {
        $customer = auth()->user();

        $reservations = Reservation::with([
            'customer', 'package.products.category', 'service.mechanic', 'service.payment', 'vehicle'
        ])->where('customer_id', $customer->id)
        ->orderBy('reservations.reservation_date', 'desc')
        ->orderBy('reservations.reservation_time', 'desc')
        ->get();

        foreach ($reservations as $key => $item) {
              if (!isset($reservations[$key]->package_price)) {
                       $reservations[$key]->package_price = 0;
                   }
                if ($item->package) {
                    foreach ($item->package->products as $key2 => $package) {
                         $reservations[$key]->package_price += $package->price;
                   }
               } else {
                $reservations[$key]->package_price = 0;
            }

        }

        $response = [
            'code' => 200,
            'success' => true,
            'message' => 'My Reservation list',
            'data' => $reservations,
        ];

        return response()->json($response, 200);
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

        // echo "<pre>";
        // print_r ($request->products);
        // echo "</pre>";

        $data = $request->except('_token');
        $data['package_detail'] = json_encode($request->products);

        DB::beginTransaction();
        try {
            $reservation = Reservation::create($data);
            $servis['reservation_id'] = $reservation->id;
            Service::create($servis);
            $response = [
                'code' => 200,
                'success' => true,
                'message' => 'Reservasi berhasil dibuat!',
                'data' => $reservation,
            ];
            DB::commit();
        } catch (\Throwable $th) {
           $response = [
            'code' => 500,
            'success' => false,
            'message' => 'Reservasi gagal dibuat!',
        ];
        throw $th;
        DB::rollBack();
    }


    return response()->json($response, $response['code']);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $reservation = Reservation::with([
        'customer', 'package.products.category', 'service.payment', 'vehicle'
        ])->where('id', $id)->first();

       if ($reservation->package) {
            foreach ($reservation->package->products as $key2 => $package) {
                if (!isset($reservation->package_price)) {
                   $reservation->package_price = 0;
                   $reservation->package_price += $package->price;
               }  else {
                   $reservation->package_price += $package->price;
               }
           }
       } else {
        $reservation->package_price = 0;
    }

           $response = [
            'code' => 200,
            'success' => true,
            'message' => 'Detail Reservasi',
            'data' => $reservation,
        ];


        return response()->json($response, $response['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
