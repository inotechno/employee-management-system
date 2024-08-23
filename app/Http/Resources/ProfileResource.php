<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'foto' => $this->foto,
            'position_id' => $this->employee->position->name,
            'tanggal_lahir' => $this->employee->tanggal_lahir,
            'tempat_lahir' => $this->employee->tempat_lahir,
            'bpjs_kesehatan' => $this->employee->bpjs_kesehatan,
            'bpjs_ketenagakerjaan' => $this->employee->bpjs_ketenagakerjaan,
            'nama_rekening'   => $this->employee->nama_rekening,
            'no_rekening'   => $this->employee->no_rekening,
            'pemilik_rekening'  => $this->employee->pemilik_rekening,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
