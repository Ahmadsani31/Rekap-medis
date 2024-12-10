<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RekapMedisRequest;
use App\Models\MedicalRecord;
use App\Models\Obat;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapMedisController extends Controller
{
    protected $data;
    public function get()
    {
        try {
            $docter = Pasien::paginate(5);
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

    public function laporan()
    {
        try {
            $search = request('search');
            $medik = MedicalRecord::query()
                // ->when($search, function ($query, $search) {
                //     return $query->whereHas('getDocter', function ($query) use ($search) {
                //         $query->where('name', 'like', '%' . $search . '%');
                //     });
                // })
                // ->when($search, function ($query, $search) {
                //     return $query->whereHas('getPasien', function ($query1) use ($search) {
                //         $query1->where('/name', 'like', '%' . $search . '%');
                //     });
                // })
                ->orWhereExists(function ($query) use ($search) {
                    // Subquery to check if there exists a post with the given title
                    $query->select(DB::raw(1))  // Just selects a constant (e.g., 1), because we're only interested in existence
                        ->from('docter')
                        ->whereColumn('docter.id', 'medical_record.docter_id')  // Join condition
                        ->where('docter.name', 'like', '%' . $search . '%');
                })
                ->orWhereExists(function ($query) use ($search) {
                    // Subquery to check if there exists a post with the given title
                    $query->select(DB::raw(1))  // Just selects a constant (e.g., 1), because we're only interested in existence
                        ->from('pasien')
                        ->whereColumn('pasien.id', 'medical_record.pasien_id')  // Join condition
                        ->where('pasien.name', 'like', '%' . $search . '%');
                })
                ->paginate(10);  // 10 items per page

            // Transform the collection of users
            $medik->getCollection()->transform(function ($med) {
                $med->pasien_id = $med->getPasien->name;
                $med->docter_id = $med->getDocter->name;
                $med->ruang_id = $med->getRuangan->name;
                $med->tanggal =  Carbon::parse($med->created_at)->format('d-M-Y H:i:s');
                foreach (explode(",", $med->obat_id) as $va) {
                    $ob = Obat::find($va);
                    $obat[] =  $ob->name;
                }
                $med->obat_id = implode(", ", $obat);
                return $med;
            });

            return response()->json([
                'status' => true,
                'message' => 'Successfully',
                'data' => $medik
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => false,
                'message' => 'Data empty',
                'errors' => $err->getMessage()
            ], 422);
        }
    }

    public function store(RekapMedisRequest $request)
    {
        try {
            $docter = MedicalRecord::create([
                'pasien_id' => $request->pasien_id,
                'docter_id' => $request->docter_id,
                'ruang_id' => $request->ruang_id,
                'obat_id' => implode(",", $request->obat_id),
                'keluhan' => $request->keluhan,
                'diagnosa' => $request->diagnosa,
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

    public function dataMedis()
    {
        try {

            $this->data['pasien'] = DB::table('pasien')
                ->select('name as label', 'id as value')->get();
            $this->data['docter'] = DB::table('docter')
                ->select('name as label', 'id as value')->get();
            $this->data['obat'] = DB::table('obat')
                ->select('name as label', 'id as value')->get();
            $this->data['ruangan'] = DB::table('ruangan')
                ->select('name as label', 'id as value')->get();

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

    public function edit($id)
    {
        try {
            $docter = Pasien::findOrFail($id);
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

    // public function update(PasienRequest $request, $id)
    // {
    //     try {
    //         $docter = Pasien::findOrFail($id);
    //         $docter->update($request->all());

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Updated successfully',
    //             'data' => $docter
    //         ], 200);
    //     } catch (\Throwable $err) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Update data failed',
    //             'errors' => $err->getMessage()
    //         ], 422);
    //     }
    // }

    public function destroy($id)
    {
        try {
            $docter = MedicalRecord::findOrFail($id);
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
