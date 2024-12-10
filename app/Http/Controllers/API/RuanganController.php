<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RuangRequest;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function get()
    {
        try {
            $ruang = Ruangan::query()
                ->when(request('search'), function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Successfully',
                'data' => $ruang
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Data docter empty',
                'errors' => $err->getMessage()
            ], 422);
        }
    }

    public function store(RuangRequest $request)
    {
        try {
            $docter = Ruangan::create($request->all());
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

            $ruang = Ruangan::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Successfully',
                'data' => $ruang
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
                'errors' => $err->getMessage()
            ], 422);
        }
    }

    public function update(RuangRequest $request, $id)
    {
        try {
            $docter = Ruangan::findOrFail($id);
            $docter->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Updated successfully',
                'data' => $docter
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Update data failed',
                'errors' => $err->getMessage()
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $docter = Ruangan::findOrFail($id);
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
