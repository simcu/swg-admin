<?php

namespace App\Models;

class Role extends BaseModel
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role_relations', 'role_id', 'user_id');
    }

    public function acls()
    {
        return $this->hasMany(Acl::class, 'role_id', 'id');
    }

    public function hosts()
    {
        return $this->belongsToMany(GateSite::class, 'acls', 'role_id', 'site_id');
    }
}
