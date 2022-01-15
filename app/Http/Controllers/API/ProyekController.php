<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProyekResource;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     * php artisan make:controller API/ProyekController --api --model=Proyek
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyeks = Proyek::all();
        return response([
            'proyeks'   => ProyekResource::collection($proyeks),
            'message'   => 'Success Read Data Proyek!'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name'          => 'required|max:255',
            'price'  => 'required',
        ]);

        if($validator->fails){
            return response([
                'errors' => $validator
            ]);
        }

        $proyek = Proyek::create($data);

        return response([
            'proyek'    => new ProyekResource($proyek),
            'message'   => 'Data Proyek Success Added!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function show(Proyek $proyek)
    {
        return response([
            'proyek'    => new ProyekResource($proyek),
            'message'   => 'Data Proyek Success Read!'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyek $proyek)
    {
        $proyek->update($request->all());

        return response([
            'proyek'    => new ProyekResource($proyek),
            'message'   => 'Data Proyek Success Updated!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyek  $proyek
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyek $proyek)
    {
        $proyek->delete();
        return response([
            'message'   => 'Data Proyek Success Deleted!'
        ], 200);
    }
}
