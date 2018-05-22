<?php

namespace App\Models;

class Upstream extends BaseModel
{
    public function hosts()
    {
        return $this->hasMany(UpstreamHost::class);
    }
}
