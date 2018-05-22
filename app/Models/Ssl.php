<?php

namespace App\Models;

class Ssl extends BaseModel
{
    public function sites()
    {
        return $this->hasMany(WebSite::class);
    }
}
