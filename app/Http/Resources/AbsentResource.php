<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsentResource extends JsonResource
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
            'date'                      => $this->date,
            'description'               => $this->description,
            'validation_at'             => $this->validation_at,
            'validation_by'             => $this->validation_by,
            'validation_user'           => $this->validation_user,
            'created_at'                => $this->created_at,
            'updated_at'                => $this->updated_at,
        ];
    }
}
