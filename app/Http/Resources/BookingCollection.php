<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\appointment_type;

class BookingCollection extends JsonResource
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
            'date' =>$this->appointment_date,
            'time' =>$this->appointment_time,
            'type'=> appointment_type::find($this->appointment_type_id)->name,
            'location' =>$this->contact_address,
            'complaint' => $this->complaint,
            'status' => $this->status,
            'href' => [
                'link'=> route("appointments.show", $this->id),
            ]
        ];
    }
}
