<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\IpAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IpController extends BaseController
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
        ]);

        if ($validator->fails()) return $this->sendErrorValidation($validator->errors());

        $ip = IpAddress::where('name', $request->name)->first();

        if ($ip) return $this->sendError('Gagal tambah data IP Address.', ['error' => 'IP Address sudah ada.']);

        $validateData = $validator->valid();
        $patient = IpAddress::create($validateData);
        $success['IP Address'] = $patient->fresh();
        if ($patient) {
            return $this->sendResponse('Berhasil tambah data IP Address.', $success);
        }
        return $this->sendFail();
    }

    public function authorization(): JsonResponse
    {
        $response = [
            'code'    => 200,
            'success' => true,
            'message' => "Authorized",
        ];
        return response()->json($response, 200);
    }

    public function ipCheck(Request $request): JsonResponse
    {
        $data['IP_Address'] =  $request->ip();
        $response = [
            'code'    => 200,
            'success' => true,
            'message' => "Berhasil ambil IP Address",
            'data'    => $data
        ];

        return response()->json($response, 200);
    }
}
