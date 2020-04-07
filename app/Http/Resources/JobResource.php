<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CompanyResourse;

class JobResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'timer' => $this->timer,
            // 'company' => new CompanyResourse($this->company),
         ];
    }

}
