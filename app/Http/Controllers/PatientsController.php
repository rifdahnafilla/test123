<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;

class PatientsController extends Controller
{
    # membuat metod index
    function index()
    {
        # menggunakan model Patients untuk select data
        $patients = Patients::all();

     if (count($patients)){
         $data = [
            'message'=> "Get All Resource",
            'data'=> $patients
         ];
        return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Data is empty"
            ];
            return response()->json($data, 200);
        }
    }
    # membuat method store
    function store(Request $request)
    {
        # menangkap dan memvalidasi request
        $validateData = $request->validate([
            'name' => 'required',
            'phone' =>  'numeric|required' ,
            'address' => 'required',
            'status' => 'required',
            'in_date_at' => ' date | required ',
            'out_date_at' => 'nullable'
        ]);

        #menggunakan model Patients untuk insert data
        $patients = Patients::create($validateData);
        $data = [
            'message' => 'Resource is added successfully',
            'data' => $patients
        ];

        # mengembalikan data (json) dan kode 201
        return response()->json($data, 201);
    }

    # membuat method show
    function show($id)
    {
        # cari id patient yang ingin ditampilkan
        $patients = Patients::find($id);

        if ($patients) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $patients
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method update
    function update($id, Request $request)
    {
        # mencari id patient yang ingin diupdate
        $patients = Patients::find($id);

        if ($patients) {
            # menangkap data request
            $input = [
                'name' => $request->name ?? $patients->name,
                'phone' => $request->phone ?? $patients->phone,
                'address' => $request->address ?? $patients->address,
                'status' => $request->status ?? $patients->status,
                'in_date_at' => $request->in_date_at ?? $patients->in_date_at,
                'out_date_at' => $request->out_date_at ?? $patients->out_date_at
            ];

            # melakukan update data
            $patients->update($input);

            $data = [
                'message' => 'Resource is update successfully',
                'data' => $patients
            ];

            # mengembalikan data (json) dan kode 200
            return response()->json($data, 201);
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan kode 404
            return response()->json($data, 404);
        }
    }

    # membuat method destroy
    function destroy($id)
    {
        # mencari id patient yang ingin dihapus
        $patients =  Patients::find($id);

        if ($patients) {
            # hapus patient tersebut
            $patients->delete();

            $data = [
                'message' => "Resource is delete successfully"
            ];

            # mengembalikan pesan dan kode 200
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => "Resource not found"
            ];

            # mengembalikan pesan dan kode 404
            return response()->json($data, 404);
        }

        //postive
        function positive(){
            $patients = Patients::where('status', 'positive')->get();
            $data = [
                'message' => "Get postive resource",
                'total' => count($patients),
                'data'=> $patients
            ];
            return response()->json($data, 200);
        }

        //recovered
        function recovered(){
            $patient = Patients::where('status', 'recovered')->get();
            $data = [
                'message' => "Get recovered resource",
                'total' => (count($patient)),
                'data'=> $patient
            ];
            return response()->json($data, 200);
        }
        //recovered
        function dead($status){
            $patient = Patients::where($status);
            $data = [
                'message' => "Get dead resource",
                'total' => (count($patient)),
                'data'=> $patient
            ];
            return response()->json($data, 200);
        }
    }
}
