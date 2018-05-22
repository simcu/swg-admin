<?php

namespace App\Models;

class Acl extends BaseModel
{
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function site()
    {
        return $this->belongsTo(GateSite::class, 'site_id', 'id');
    }

}
