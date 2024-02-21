<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'user_id' => $this->user_id,
            'position_id' => $this->position_id,
            'card_number' => $this->card_number,
            'tanggal_lahir' => $this->tanggal_lahir,
            'tempat_lahir' => $this->tempat_lahir,
            'bpjs_kesehatan' => $this->bpjs_kesehatan,
            'bpjs_ketenagakerjaan' => $this->bpjs_ketenagakerjaan,
            'status' => $this->status,
            'jumlah_cuti' => $this->jumlah_cuti,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
