<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RekapMedisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pasien_id' => 'required|numeric',
            'docter_id' => 'required|numeric',
            'ruang_id' => 'required|numeric',
            'obat_id' => 'required',
            'keluhan' => 'required|string',
            'diagnosa' => 'required|string',
        ];
    }
}
