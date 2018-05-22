<?php
/**
 * Created by IntelliJ IDEA.
 * User: xrain
 * Date: 2018/5/21
 * Time: 04:21
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\GateSite;
use App\Models\Role;
use App\Models\Upstream;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class GateController extends Controller
{
    public function roles()
    {
        return view('admin.gate.role', [
            'list' => Role::all()
        ]);
    }


    public function addRole(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|unique:roles',
        ]);
        $role = new Role;
        $role->name = $r->input('name');
        if ($role->save()) {
            return redirect()->back();
        } else {
            return back()->with(['alert' => 'Add Role Failed']);
        }
    }

    public function delRole(Request $r)
    {
        $this->validate($r, [
            'id' => 'required|exists:roles'
        ]);
        $role = Role::find($r->input('id'));
        $role->users()->detach();
        $role->delete();
        return redirect('/admin/roles');
    }

    public function detailRole(Request $r)
    {
        $this->validate($r, [
            'id' => 'required|exists:roles'
        ]);
        $role = Role::find($r->input('id'));
        $has_host = [];
        foreach ($role->acls as $ra) {
            $has_host[] = $ra->site;
        }
        return view('admin.gate.detail', [
            'role' => $role,
            'users' => User::all()->diff($role->users),
            'hosts' => GateSite::all()->diff($has_host)
        ]);
    }

    public function detailRoleAddHost(Request $r)
    {
        $this->validate($r, [
            'rid' => 'required|exists:roles,id',
            'hid' => 'required|exists:gate_sites,id'
        ]);
        $role = Role::find($r->input('rid'));
        $role->hosts()->attach(GateSite::find($r->input('hid')));
        return redirect()->back();
    }

    public function detailRoleDelHost(Request $r)
    {
        $this->validate($r, [
            'rid' => 'required|exists:roles,id',
            'hid' => 'required|exists:gate_sites,id'
        ]);
        $role = Role::find($r->input('rid'));
        $role->hosts()->detach(GateSite::find($r->input('hid')));
        return redirect()->back();
    }

    public function detailRoleAddUser(Request $r)
    {
        $this->validate($r, [
            'rid' => 'required|exists:roles,id',
            'uid' => 'required|exists:users,id'
        ]);
        $role = Role::find($r->input('rid'));
        $role->users()->attach(User::find($r->input('uid')));
        return redirect()->back();
    }

    public function detailRoleDelUser(Request $r)
    {
        $this->validate($r, [
            'rid' => 'required|exists:roles,id',
            'uid' => 'required|exists:users,id'
        ]);
        $role = Role::find($r->input('rid'));
        $role->users()->detach(User::find($r->input('uid')));
        return redirect()->back();
    }

    public function config()
    {
        return view('admin.gate.config');
    }

    public function saveConfig(Request $r)
    {
        Redis::set('swg_gate_url', $r->input('config_token_url'));
        Redis::set('swg_gate_expire', $r->input('config_token_expire'));
        Redis::set('swg_gate_mode', $r->input('config_token_mode'));
        return back();
    }

    public function sites()
    {
        return view('admin.gate.site', [
            'list' => GateSite::all(),
            'hosts' => Upstream::all()
        ]);
    }

    public function addSite(Request $r)
    {
        $this->validate($r, [
            'name' => 'required',
            'domain' => 'required|unique:gate_sites,domain|unique:web_sites,domain',
            'upstream' => 'required|exists:upstreams,id',
        ]);
        $h = new GateSite;
        $h->name = $r->input('name');
        $h->domain = $r->input('domain');
        $h->upstream_id = $r->upstream;
        if ($h->save()) {
            return back();
        }
    }

    public function delSite(Request $r)
    {
        $this->validate($r, [
            'id' => 'required|exists:gate_sites,id'
        ]);
        $h = GateSite::find($r->input('id'));
        $h->acls()->delete();
        $h->delete();
        return back();
    }
}