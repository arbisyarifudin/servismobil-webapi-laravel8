<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
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
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        // dd($request->all());

        $data = $request->except('_token');
        if ($request->status != 'Pending') {
            $data['service_date'] = date("Y-m-d");
        }
        $update = $service->update($data);
        $redirect = "service";
        if ($update) {
            if ($request->has('ref')) {
                $redirect = $request->ref;
            }
            return redirect($redirect)->with('flash-success', 'Data berhasil diperbarui');
        } else {
            return redirect($redirect)->with('flash-error', 'Data gagal diperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }

    // additional

    public function update_status(Request $request, Service $service)
    {
        $data['status'] = $request->status;
        if ($request->status != 'Pending') {
            $data['service_date'] = date("Y-m-d");
        }
        $update = $service->update($data);
        if ($update) {
            return redirect($request->ref)->with('flash-success', 'Data berhasil diperbarui');
        } else {
            return redirect($request->ref)->with('flash-error', 'Data gagal diperbarui');
        }
    }
}
