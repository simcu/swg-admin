<?php

namespace App\Models;

class GateSite extends BaseModel
{
    public function acls()
    {
        return $this->hasMany(Acl::class, 'site_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'acls', 'site_id', 'role_id');
    }

    public function upstream()
    {
        return $this->belongsTo(Upstream::class);
    }
}
