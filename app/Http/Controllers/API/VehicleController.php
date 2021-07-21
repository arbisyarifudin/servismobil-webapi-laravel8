<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Vehicle::orderBy('created_at', 'desc')->get();

        $response = [
            'success' => true,
            'message' => 'Vehicle list',
            'data' => $reservations,
        ];

        return response()->json($response, 200);
    }

    public function mine()
    {
        $customer = auth()->user();

        $vehicles = Vehicle::where('customer_id', $customer->id)
        ->orderBy('created_at', 'desc')->get();

        $response = [
            'success' => true,
            'message' => 'My Vehicle list',
            'data' => $vehicles,
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
            'name' => 'required',
            'brand' => 'required',
            'plate_number' => 'required',
        ]);

        $data = $request->except('_token');

        DB::beginTransaction();
        try {
            $vehicle = Vehicle::create($data);
            $response = [
                'code' => 200,
                'success' => true,
                'message' => 'Kendaraan berhasil dibuat!',
                'data' => $vehicle,
            ];
            DB::commit();
        } catch (\Throwable $th) {
           $response = [
            'code' => 500,
            'success' => false,
            'message' => 'Kendaraan gagal dibuat!',
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
        $vehicle = Vehicle::where('id',$id)->first();

       $response = [
            'code' => 200,
            'success' => true,
            'message' => 'Detail Kendaraan',
            'data' => $vehicle,
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
         $request->validate([
            // 'customer_id' => 'required',
            'name' => 'required',
            'brand' => 'required',
            'plate_number' => 'required',
        ]);

        $data = $request->except('_token');

        DB::beginTransaction();
        try {
            $vehicle = Vehicle::find($id)->update($data);
            $response = [
                'code' => 200,
                'success' => true,
                'message' => 'Kendaraan berhasil diperbarui!',
                'data' => $vehicle,
            ];
            DB::commit();
        } catch (\Throwable $th) {
        throw $th;
            $response = [
                'code' => 500,
                'success' => false,
                'message' => 'Kendaraan gagal diperbarui!',
            ];
            DB::rollBack();
        }


        return response()->json($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);

        if($vehicle) {

            // cari relasi ke tb reservasi
            $cek = Reservation::where('vehicle_id', $id)->count();

            if ($cek > 0) {
                return response()->json(
                    [
                        'code' => 403,
                        'success' => false,
                        'message' => 'Data kendaraan yang sudah terdaftar di reservasi dan servis tidak dapat dihapus!',
                    ], 403);
            }

            $vehicle->delete();
            $response = [
                'code' => 200,
                'success' => true,
                'message' => 'Kendaraan berhasil dihapus!',
            ];
        } else {
            $response = [
                'code' => 404,
                'success' => false,
                'message' => 'Kendaraan gagal dihapus!',
            ];
        }

        return response()->json($response, $response['code']);

    }
}
