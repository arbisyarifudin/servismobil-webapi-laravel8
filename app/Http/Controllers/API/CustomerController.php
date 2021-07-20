<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customes = Customer::with('vehicles')->get();

        $response = [
            'success' => true,
            'message' => 'Customer list',
            'data' => $customes,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|confirmed|min:6',
            'gender' => 'required',
            'phone' => 'required|digits_between:7,15',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'code' => 422,
                    'success' => false,
                    'message' => 'Invalid input.',
                    'errors' => $validator->errors()
                ],
                422
            );
        } else {

            $username = str_replace(" ", "", strtolower($request->input('name')));
            $cek_username = Customer::where('username', $username)->count();
            if ($cek_username > 0) {
                $username = $username . ($cek_username + 1);
            }

            $customer = Customer::create([
                'name' => $request->input('name'),
                'username' => $username,
                'email' => $request->input('email'),
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'photo' => 'ava-default.jpg',
                'password' => Hash::make($request->input('address')),
            ]);

            $accessToken = $customer->createToken('customer_token')->accessToken;
            $user = Customer::with('vehicles')->find($customer->id);

            $msg = [
                'success' => true,
                'message' => 'Customer registered successfully!',
                'data' => [
                    'user' =>  $user,
                    'token' => $accessToken,
                ],
            ];

            return response()->json($msg, 201);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $check = Customer::where('email', $request->email);

        if ($check->count() == 0) {
            return response()->json(
                [
                    'code' => 403,
                    'success' => false,
                    'message' => 'Akun tidak ada.',
                ],
                403
            );
        }

        $customer = $check->with('vehicles')->first();
        $hash_check = Hash::check($request->password, $customer->password);

        if ($hash_check) {
            $accessToken = $customer->createToken('customer_token')->accessToken;

            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'message' => 'Login success',
                    'data' => [
                        'user' =>  $customer,
                        'token' => $accessToken,
                    ],
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => 403,
                    'success' => false,
                    'message' => 'Email / password salah.',
                ],
                403
            );
        }
    }

    public function profile(Request $request)
    {
        $user = auth()->user();
        $user = Customer::with('vehicles')->find($user->id);
        if (!$user) {
            return response()->json(
                [
                    'code' => 401,
                    'success' => false,
                    'message' => 'Unauthorized.',
                ],
                401
            );
        } else {
            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'message' => 'My profile.',
                    'data' => $user
                ],
                200
            );
        }
       
    }

    public function logout(Request $request)
    {
        $logout = auth()->user()->token()->revoke();
        if ($logout) {
            return response()->json(
                [
                    'code' => 200,
                    'success' => true,
                    'message' => 'Logout success',
                ],
                200
            );
        }
    }

}
