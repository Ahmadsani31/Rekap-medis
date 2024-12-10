<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Docter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $data;
    public function get()
    {
        try {
            $this->data['docter'] = Docter::count();
            $this->data['pasien'] = Pasien::count();
            $this->data['obat'] = Obat::count();
            $this->data['ruangan'] = Ruangan::count();
            $this->data['user'] = User::count();

            return response()->json([
                'status' => true,
                'message' => 'Successfully',
                'data' => $this->data
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
