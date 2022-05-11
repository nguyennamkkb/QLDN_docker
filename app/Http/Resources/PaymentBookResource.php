<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'customer' =>  $this->customer,
            'totalmoney' =>  $this->totalmoney,
            'prepay' => $this->prepay,
            'paid' => $this->paid,
            'data' => json_decode($this->data),
            
        ];
    }
}
