<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocterRequest;
use App\Http\Requests\DocterUpdateRequest;
use App\Http\Resources\DocterResource;
use App\Models\Docter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocterController extends Controller
{

    public function get()
    {
        try {

            $docter = Docter::query()
                ->when(request('search'), function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10);  // 10 items per page

            // Transform the collection of users
            $docter->getCollection()->transform(function ($dok) {
                // Example: Add a full name attribute to each user
                $dok->profil  = Storage::url($dok->profil);
                return $dok;
            });

            return response()->json([
                'status' => true,
                'message' => 'Successfully',
                'data' => $docter
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Data empty',
                'errors' => $err->getMessage()
            ], 422);
        }
    }

    public function store(DocterRequest $request)
    {
        try {
            if ($request->hasFile('profil')) {
                $img_path = $request->file('profil')->store('docter', 'public');
            }
            $docter = Docter::create([
                'name' => $request->name,
                'email' =>  $request->email,
                'no_handphone' =>  $request->no_handphone,
                'alamat' =>  $request->alamat,
                'spesialis' =>  $request->spesialis,
                'jenis_kelamin' =>  $request->jenis_kelamin,
                'profil' => $img_path ?? null
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Created successfully',
                'data' => $docter
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $err->getMessage()
            ], 422);
        }
    }

    public function edit($id)
    {
        try {
            $docter = new DocterResource(Docter::findOrFail($id));
            return response()->json([
                'status' => true,
                'message' => 'Successfully',
                'data' => $docter
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
                'errors' => $err->getMessage()
            ], 422);
        }
    }

    public function update(DocterUpdateRequest $request)
    {
        // dd($request->input());
        // try {
        $docter = Docter::findOrFail($request->id);

        if ($request->hasFile('profil')) {

            $request->validate([
                'profil' => 'image|mimes:png,jpg,jpeg'
            ]);
            Storage::delete($docter->profil);
            $img_path = $request->file('profil')->store('docter', 'public');
        }

        $docter->update([
            'name' => $request->name,
            'email' =>  $request->email,
            'no_handphone' =>  $request->no_handphone,
            'alamat' =>  $request->alamat,
            'spesialis' =>  $request->spesialis,
            'jenis_kelamin' =>  $request->jenis_kelamin,
            'profil' => $img_path ?? $docter->profil
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Updated successfully',
            'data' => $docter
        ], 200);
        // } catch (\Throwable $err) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Update data failed',
        //         'errors' => $err->getMessage()
        //     ], 422);
        // }
    }

    public function destroy($id)
    {
        try {
            $docter = Docter::findOrFail($id);
            Storage::delete($docter->profil);
            $docter->delete();
            return response()->json([
                'status' => true,
                'message' => 'Deleted successfully'
            ], 204);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Delete data failed',
                'errors' => $err->getMessage()
            ], 422);
        }
    }
}
