<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Signature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class SignatureController extends BaseController
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'rm' => ['required', 'string'],
            'name' => ['required', 'string'],
            'image' => ['required', 'string'],
        ]);

        if ($validator->fails()) return $this->sendErrorValidation($validator->errors());

        $base64Image = $request->input('image');
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
        }
        $imageData = base64_decode($base64Image);
        $fileName = $request->rm . '.png';
        $path = Storage::disk('public')->put('images/signature/' . $fileName, $imageData);

        if ($path) {
            $validateData = $validator->valid();
            $validateData['image'] = $fileName;

            $signatureCheck = Signature::where('rm', $request->rm);
            if ($signatureCheck->first()) {
                $signatureCheck->update($validateData);
                $success['signature'] = $signatureCheck->first();
                if ($signatureCheck) return $this->sendResponse('Berhasil tambah data tanda tangan.', $success);
            } else {
                $signature = Signature::create($validateData);
                $success['signature'] = $signature;
                if ($signature) return $this->sendResponse('Berhasil tambah data tanda tangan.', $success);
            }
            return $this->sendFail();
        }
        return $this->sendFail();
    }

    public function show($rm): JsonResponse
    {
        $signature = Signature::where('rm', $rm)->first();
        if ($signature) {
            return $this->sendResponse('Berhasil ambil data tanda tangan.', ['signature' => $signature]);
        } else {
            return $this->sendError('Gagal menampilkan data tanda tangan.', ['signature' => 'Tanda tangan tidak ditemukan.']);
        }
    }
}
