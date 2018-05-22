<?php
/**
 * Created by IntelliJ IDEA.
 * User: xrain
 * Date: 2018/5/21
 * Time: 04:21
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Ssl;
use App\Models\Upstream;
use App\Models\WebSite;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function all()
    {
        return view('admin.web.web', [
            'list' => WebSite::all(),
            'hosts' => Upstream::all(),
            'ssls' => Ssl::all()
        ]);
    }

    public function ssl()
    {
        return view('admin.web.ssl', [
            'list' => Ssl::all()
        ]);
    }

    public function add(Request $r)
    {
        $this->validate($r, [
            'domain' => 'required|unique:gate_sites,domain|unique:web_sites,domain',
            'ssl' => 'required',
            'force' => 'required|in:0,1',
            'upstream' => 'required|exists:upstreams,id',
        ]);
        $site = new WebSite();
        $site->domain = $r->domain;
        $site->ssl_id = $r->ssl;
        if ($r->ssl) {
            $site->schema = "https";
        } else {
            $site->schema = "http";
        }
        $site->force_https = $r->force;
        $site->upstream_id = $r->upstream;
        if ($site->save()) {
            return back();
        }

    }

    public function del(Request $r)
    {
        WebSite::find($r->id)->delete();
        return back();
    }

    public function addSsl(Request $r)
    {
        $this->validate($r, [
            'name' => 'required',
            'cert' => 'required',
            'key' => 'required'
        ]);
        $ssl = new Ssl();
        $ssl->name = $r->name;
        $ssl->cert = $r->cert;
        $ssl->key = $r->key;
        if ($ssl->save()) {
            return back();
        }
    }

    public function delSsl(Request $r)
    {
        Ssl::find($r->id)->delete();
        return back();
    }

}