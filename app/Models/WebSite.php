<?php

namespace App\Models;

class WebSite extends BaseModel
{
    public function ssl()
    {
        return $this->belongsTo(Ssl::class);
    }

    public function upstream()
    {
        return $this->belongsTo(Upstream::class);
    }
}
