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
            'type' => ['required']
        ]);

        if ($validator->fails()) return $this->sendErrorValidation($validator->errors());

        $ip = IpAddress::where('name', $request->name)->where('type', $request->type)->first();

        if ($ip) return $this->sendError('Gagal tambah data IP Address.', ['error' => 'IP Address sudah ada.']);

        $validateData = $validator->valid();
        $patient = IpAddress::create($validateData);
        $success['IP Address'] = $patient->fresh();
        if ($patient) {
            return $this->sendResponse('Berhasil tambah data IP Address.', $success);
        }
        return $this->sendFail();
    }

    public function authorization(Request $request): JsonResponse
    {
        return $this->sendResponse('Authorized', ['IP_Address' => $request->ip()]);
    }

    public function ipCheck(Request $request): JsonResponse
    {
        return $this->sendResponse('Berhasil ambil IP Address', ['IP_Address' => $request->header('X-Forwarded-For') ?? $request->getClientIp(), 'IP_Address_ip' => $request->ip(),]);
    }
}
