<?php

namespace App\Models;

class Backend extends BaseModel
{
    public function hosts()
    {
        return $this->hasMany(BackendHost::class);
    }

    public function front()
    {
        return $this->hasMany(Front::class);
    }
}
