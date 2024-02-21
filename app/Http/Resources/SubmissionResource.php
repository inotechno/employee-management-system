<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
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
            'title'                     => $this->title,
            'nominal'                   => $this->nominal,
            'note'                      => $this->note,
            'validation_director'       => $this->validation_director,
            'validation_finance'        => $this->validation_finance,
            'receipt_image'             => $this->receipt_image,
            'status'                    => $this->status,
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
        ];
    }
}
