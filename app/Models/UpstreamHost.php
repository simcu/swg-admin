<?php

namespace App\Models;

class UpstreamHost extends BaseModel
{
    public function upstream()
    {
        return $this->belongsTo(Upstream::class);
    }
}
