<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\payment_type;
use App\Models\payment_plan;

class PaymentResource extends JsonResource
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
            'date' =>$this->payment_date,
            'plan' => payment_plan::find($this->payment_plan_id)->name,
            'payment_method'=> payment_type::find($this->payment_type_id)->name,
            'amount' =>$this->amount_paid,
            'status' => $this->status
        ];
    }
}
