<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaidLeaveResource extends JsonResource
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
            'id'                        => $this->id,
            'employee_id'               => $this->employee->id,
            'name'                      => $this->employee->user->name,
            'tanggal_mulai'             => $this->tanggal_mulai,
            'tanggal_akhir'             => $this->tanggal_akhir,
            'description'               => $this->description,
            'validation_hrd'            => $this->validation_hrd,
            'validation_director'       => $this->validation_director,
            'status'                    => $this->status,
            'total_cuti'                => $this->total_cuti,
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
        ];
    }
}
