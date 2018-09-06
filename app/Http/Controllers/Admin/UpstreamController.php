<?php
/**
 * Created by IntelliJ IDEA.
 * User: xrain
 * Date: 2018/5/21
 * Time: 05:25
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\GateSite;
use App\Models\Upstream;
use App\Models\UpstreamHost;
use App\Models\WebSite;
use Illuminate\Http\Request;

class UpstreamController extends Controller
{
    public function all()
    {
        return view('admin.balance.upstream', [
            'list' => Upstream::all()
        ]);
    }

    public function add(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|alpha_dash',
            'type' => 'required|in:weight,ip_hash',
            'schema' => 'required|in:http,https'
        ]);
        $up = new Upstream();
        $up->name = $r->name;
        $up->type = $r->type;
        $up->schema = $r->schema;
        if ($up->save()) {
            return back();
        }
    }

    public function del(Request $r)
    {
        Upstream::find($r->id)->delete();
        UpstreamHost::where('upstream_id', $r->id)->delete();
        GateSite::where('upstream_id', $r->id)->delete();
        WebSite::where('upstream_id', $r->id)->delete();
        return back();
    }

    public function detail(Request $r)
    {
        $this->validate($r, [
            'id' => 'required|exists:upstreams,id'
        ]);
        $up = Upstream::find($r->id);
        return view('admin.balance.updetail', [
            'detail' => $up,
            'list' => $up->hosts
        ]);
    }

    public function addHost(Request $r)
    {
        $this->validate($r, [
            'upid' => 'required|exists:upstreams,id',
            'ip' => 'required|ipv4',
            'port' => 'required|integer|min:1|max:65535',
            'weight' => 'integer',
            'max_fails' => 'integer',
            'fail_timeout' => 'integer',
            'backup' => 'required|in:0,1'
        ]);
        $uh = new UpstreamHost();
        $uh->upstream_id = $r->upid;
        $uh->ip = $r->ip;
        $uh->port = $r->port;
        $uh->weight = $r->weight;
        $uh->max_fails = $r->max_fails;
        $uh->fail_timeout = $r->fail_timeout;
        $uh->backup = $r->backup;
        if ($uh->save()) {
            return back();
        }
    }

    public function delHost(Request $r)
    {
        UpstreamHost::find($r->id)->delete();
        return back();
    }
}