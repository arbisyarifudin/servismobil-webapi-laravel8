<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = auth()->user();
        // $data['notifications'] = Notification::select(['*', 'notifications.id as id', 'customers.name as customer_name', 'notifications.created_at as created_at'])
        //     ->join('reservations', 'reservations.id', '=', 'notifications.sender_id')
        //     ->join('customers', 'customers.id', '=', 'reservations.customer_id')
        //     // ->where('notifications.recipient_id', $admin->id)
        //     ->orderBy('notifications.created_at', 'DESC')
        //     ->get();

        $data['notifications'] = Notification::with(['reservation', 'customer'])->orderBy('notifications.created_at', 'desc')->get();

        // dd($data);

        return view('notification.index', $data);
    }

    public function open($id)
    {
        $updated = tap(Notification::with(['reservation', 'customer'])->where('id', $id))->update(['is_read' => 1])->first();

        if ($updated) {
            if ($updated->type == 'reservations') {
                return redirect('reservation/' . $updated->reservation->id);
            } elseif ($updated->type == 'customers') {
                return redirect('customer/' . $updated->customer->id);
            }
        } else {
            return redirect()->back();
        }
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
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
