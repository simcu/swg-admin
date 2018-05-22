<?php

namespace App\Models;

class BackendHost extends BaseModel
{
    public function backend()
    {
        return $this->belongsTo(Backend::class);
    }
}
