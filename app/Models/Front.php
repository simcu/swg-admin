<?php

namespace App\Models;

class Front extends BaseModel
{
    public function backend()
    {
        return $this->belongsTo(Backend::class);
    }
}
