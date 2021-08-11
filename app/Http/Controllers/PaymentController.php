<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['payments'] = Payment::with(['service', 'admin'])->paginate(10);
        return view('payment.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->all());

        $data['services'] = Service::all();

        if ($request->has('reservation_id')) {
            $data['reservation'] = Reservation::where('id', $request->reservation_id)->with(['customer', 'service', 'package'])->first();

            if ($data['reservation']->service->status != 'Finish') {
                $update['service_date'] = date("Y-m-d");
                $update['mechanic_id'] = $request->mechanic_id;
                $update['fee'] = $request->service_fee;
                $update['note'] = $request->note;
                $update['next_service_date'] = $request->next_service_date;
                $updated = Service::where('reservation_id', $request->reservation_id)->update($update);
                if ($updated) {
                    $data['reservation'] = Reservation::where('id', $request->reservation_id)->with(['customer', 'service', 'package'])->first();
                }
            }

            if ($data['reservation']) {
                $data['vehicle'] = Vehicle::where('id', $data['reservation']->vehicle_id)->first();
            } else {
                return redirect('home');
            }
        }

        return view('payment.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'service_id' => 'required',
            'pay' => 'required',
            'method' => 'required',
        ]);
        $data = $request->except('_token');
        $data['admin_id'] = $request->user()->id;
        $data['note'] = "-";
        // dd($data);

        $redirect = 'payment';
        DB::beginTransaction();
        try {
            Payment::create($data);
            if ($request->has('service_id')) {
                Service::where('id', $request->service_id)->update(['status' => 'Finish']);
                $redirect = 'reservation';
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return redirect($redirect)->with('flash-success', 'Pembayaran berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Payment $payment)
    {
        $data['payment'] = Payment::where('id', $payment->id)->with(['service.reservation.customer', 'service.reservation.vehicle', 'admin'])->first();

        // dd($data['payment']->toArray());

        return view('payment.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
