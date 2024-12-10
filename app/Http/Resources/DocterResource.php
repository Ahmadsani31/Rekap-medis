<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DocterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'no_handphone' => $this->no_handphone,
            'alamat' => $this->alamat,
            'spesialis' => $this->spesialis,
            'jenis_kelamin' => $this->jenis_kelamin,
            'profil' => $this->profil ? Storage::url($this->profil) : null,
            'created_at' => Carbon::parse($this->created_at)->format('d-M-Y H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d-M-Y H:i:s'),
        ];
    }
}
