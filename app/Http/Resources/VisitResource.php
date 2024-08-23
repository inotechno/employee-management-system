<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
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
            'site_name'         => $this->site->name ?? '',
            'site_qr_code'      => $this->site->qr_code ?? '',
            'site_longitude'    => $this->site->longitude ?? '',
            'site_latitude'     => $this->site->latitude ?? '',
            'site_foto'         => $this->site->foto ?? '',
            'employee_id'       => $this->employee_id,
            'name'              => $this->employee->user->name,
            'longitude'         => $this->longitude,
            'latitude'          => $this->latitude,
            'keterangan'        => $this->keterangan,
            'visit_category_id' => $this->visit_category_id,
            'category'          => $this->category,
            'file'              => $this->file,
            'status'            => $this->status,
            'created_at'        => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at'        => date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
