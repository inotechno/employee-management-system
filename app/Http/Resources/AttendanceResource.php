<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'id'            => $this->id,
            'employee_id'   => $this->employee->id,
            'name'          => $this->employee->user->name,
            'state'         => $this->state,
            'event'         => $this->event_id,
            'event_name'    => $this->event->name,
            'site_id'       => $this->site_id,
            'site_name'     => $this->site->name,
            'timestamp'     => $this->timestamp,
            'type'          => $this->type,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
