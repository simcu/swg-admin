<?php

namespace App\Models;

class User extends BaseModel
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role_relations', 'user_id', 'role_id');
    }
}
