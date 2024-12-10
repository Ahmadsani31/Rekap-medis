<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get()
    {
        try {
            $user = User::query()
                ->when(request('search'), function ($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10);
            return response()->json([
                'status' => true,
                'message' => 'Successfully',
                'data' => $user
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Data empty',
                'errors' => $err->getMessage()
            ], 422);
        }
    }
}
