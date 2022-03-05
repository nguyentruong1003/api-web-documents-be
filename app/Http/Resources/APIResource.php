<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class APIResource extends JsonResource
{

    public function withMessage($message)
    {
        $this->additional([
            'message' => $message
        ]);
        return $this;
    }
}
