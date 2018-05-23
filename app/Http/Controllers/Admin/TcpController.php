<?php
/**
 * Created by IntelliJ IDEA.
 * User: xrain
 * Date: 2018/5/21
 * Time: 04:22
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Backend;
use App\Models\BackendHost;
use App\Models\Front;
use Illuminate\Http\Request;

class TcpController extends Controller
{
    public function fronts()
    {
        return view('admin.tcp.front', [
            'backends' => Backend::all(),
            'list' => Front::all()
        ]);
    }

    public function add(Request $r)
    {
        $this->validate($r, [
            'name' => 'required',
            'ip' => 'required|ipv4',
            'port' => 'required|integer|min:1|max:65535',
            'backend' => 'required|exists:backends,id',
        ]);
        $f = new Front();
        $f->name = $r->name;
        $f->ip = $r->ip;
        $f->port = $r->port;
        $f->backend_id = $r->backend;
        $f->enable = true;
        if ($f->save()) {
            return back();
        }
    }

    public function del(Request $r)
    {
        Front::find($r->id)->delete();
        return back();
    }

    public function backends()
    {
        return view('admin.tcp.backend', [
            'list' => Backend::all()
        ]);
    }

    public function addBackend(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|alpha_dash',
            'type' => 'required|in:source,roundrobin'
        ]);
        $b = new Backend();
        $b->name = $r->name;
        $b->type = $r->type;
        if ($b->save()) {
            return back();
        }
    }

    public function delBackend(Request $r)
    {
        Backend::find($r->id)->delete();
        BackendHost::where('backend_id', $r->id)->delete();
        Front::where('backend_id', $r->id)->delete();
        return back();
    }

    public function backendDetail(Request $r)
    {
        $this->validate($r, [
            'id' => 'required|exists:backends'
        ]);
        return view('admin.tcp.detail', [
            'detail' => Backend::find($r->id),
            'list' => BackendHost::where('backend_id', $r->id)->get()
        ]);
    }

    public function addBackendDetail(Request $r)
    {
        $this->validate($r, [
            'bid' => 'required|exists:backends,id',
            'ip' => 'required|ipv4',
            'port' => 'required|integer|min:1|max:65535',
            'check' => 'required|in:0,1',
            'inter' => 'required|integer',
            'rise' => 'required|integer',
            'fall' => 'required|integer',
            'weight' => 'required|integer'
        ]);
        $bh = new BackendHost();
        $bh->backend_id = $r->bid;
        $bh->ip = $r->ip;
        $bh->port = $r->port;
        $bh->check = $r->check;
        $bh->inter = $r->inter;
        $bh->rise = $r->rise;
        $bh->fall = $r->fall;
        $bh->weight = $r->weight;
        if ($bh->save()) {
            return back();
        }
    }
}