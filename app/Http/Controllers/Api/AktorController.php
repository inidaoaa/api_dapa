<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aktor;
use Illuminate\Http\Request;
use Validator;

class AktorController extends Controller
{
    public function index(){
        $aktor = Aktor::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data aktor',
            'data' => $aktor,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required|unique:aktors',
            'bio' => 'required|unique:aktors',
        ], [
            'nama_aktor.required' => 'Masukkan aktor',
            'bio.required' => 'Masukkan bio aktor',
            'nama_aktor.unique' => 'aktor Sudah Digunakan!',
            'bio.unique' => 'bio Sudah Digunakan!',
        ]);

        // application/json {Api error middleware}
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = new Aktor;
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->bio = $request->bio;
            $aktor->save();
        }

        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'data behasil disimpan',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data gagal disimpan',
            ], 400);
        }
    }
    public function show($id){
        $aktor = Aktor::find($id);

        if($aktor){
            return response()->json([
                'success' => true,
                'message' => 'Detail aktor',
                'data' => $aktor,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'aktor tidak ditemukan',
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required',
            'bio' => 'required',
        ], [
            'nama_aktor.required' => 'Masukkan aktor',
            'bio.required' => 'Masukkan bio aktor',
        ]);

        // application/json {Api error middleware}
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = Aktor::find($id);
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->bio = $request->bio;
            $aktor->save();
        }

        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'data behasil disimpan',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data gagal disimpan',
            ], 400);
        }
    }
    public function destroy($id)
    {
        $aktor = Aktor::find($id);
        if ($aktor) {
            $aktor->delete();
            return response()->json([
                'success' => true,
                'message' => 'data ' . $aktor->nama_aktor . ' berhasil dihapus',
            ], 200);
        } else {
            return response()->json([
            'success' => true,
            'message' => 'Data Tidak Ditemukan',
        ], 404);

        }
    }
}
