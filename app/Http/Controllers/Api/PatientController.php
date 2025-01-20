<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends BaseController
{
    public function index(): JsonResponse
    {
        $patients = Patient::orderBy('updated_at', 'desc')->get();
        return $this->sendResponse('Berhasil ambil data pasien.', ['patients' => $patients]);
    }

    public function today(): JsonResponse
    {
        $patients = Patient::whereDate('created_at', Carbon::today())->orWhereDate('created_at', Carbon::yesterday())->orderBy('updated_at', 'desc')->get();
        return $this->sendResponse('Berhasil ambil data pasien.', ['patients' => $patients]);
    }

    public function pending(): JsonResponse
    {
        $patients = Patient::whereDate('created_at', Carbon::today())->orderBy('updated_at', 'desc')->get();
        return $this->sendResponse('Berhasil ambil data pasien.', ['patients' => $patients]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'rm' => ['required', 'string'],
            'episode' => ['required', 'string'],
            'name' => ['required', 'string'],
            'guarantor_code' => ['required', 'exists:guarantors,code']
        ]);

        if ($validator->fails()) return $this->sendErrorValidation($validator->errors());

        $patientGuarantor = Patient::where("rm", $request->rm)->where("episode", $request->episode)->where('guarantor_code', $request->guarantor_code)->where("status", 0)->first();
        if ($patientGuarantor) return $this->sendError('Gagal tambah data pasien.', ['error' => 'Data yang sama sudah ditambahkan sebelumnya.']);

        $patients = Patient::where("rm", $request->rm)->where("episode", $request->episode)->where("status", 0);

        if ($patients->get()->count() > 0) $patients->update(["status" => 1, "notes" => "automatic status updates"]);

        $validateData = $validator->valid();
        $validateData["ip_address"] = $request->ip();
        $patient = Patient::create($validateData);
        $success['patient'] = $patient->fresh();
        if ($patient) {
            return $this->sendResponse('Berhasil tambah data pasien.', $success);
        }
        return $this->sendFail();
    }

    public function statusUpdate(Request $request, $id): JsonResponse
    {
        $patient = Patient::find($id);
        if ($patient) {
            $patient->update(["status" => 1, "notes" => $request->ip()]);
            $success['patient'] = $patient->fresh();
            return $this->sendResponse('Berhasil ubah status pasien.', $success);
        } else {
            return $this->sendError('Gagal ubah status.', ['error' => 'Pasien tidak ditemukan.']);
        }
        return $this->sendFail();
    }
}
