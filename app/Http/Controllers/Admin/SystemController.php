<?php
/**
 * Created by IntelliJ IDEA.
 * User: xrain
 * Date: 2018/5/21
 * Time: 04:21
 */

namespace App\Http\Controllers\Admin;

use App\Helpsers\Conf;
use App\Http\Controllers\Controller;
use App\Models\Backend;
use App\Models\BackendHost;
use App\Models\Front;
use App\Models\GateSite;
use App\Models\Ssl;
use App\Models\Upstream;
use App\Models\UpstreamHost;
use App\Models\User;
use App\Models\WebSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SystemController extends Controller
{
    public function fastAddTcp(Request $r)
    {
        $this->validate($r, [
            'tcp_ip' => 'required|ipv4',
            'tcp_port' => 'required|integer|min:1|max:65535',
            'tcp_target_ip' => 'required|ipv4',
            'tcp_target_port' => 'required|integer|min:1|max:65535'
        ]);

        //添加backend
        $b = new Backend();
        $b->name = str_replace('.', '_', $r->tcp_ip) . '_' . $r->tcp_port . '_to_'
            . str_replace('.', '_', $r->tcp_target_ip) . '_' . $r->tcp_target_port . '_backend';
        $b->type = 'roundrobin';
        $b->save();
        //添加backend host
        $bh = new BackendHost();
        $bh->backend_id = $b->id;
        $bh->ip = $r->tcp_target_ip;
        $bh->port = $r->tcp_target_port;
        $bh->check = 1;
        $bh->inter = 3000;
        $bh->rise = 3;
        $bh->fall = 3;
        $bh->weight = 10;
        $bh->save();
        //添加front
        $f = new Front();
        $f->name = str_replace('.', '_', $r->tcp_ip) . '_' . $r->tcp_port . '_to_'
            . str_replace('.', '_', $r->tcp_target_ip) . '_' . $r->tcp_target_port . '_front';
        $f->ip = $r->tcp_ip;
        $f->port = $r->tcp_port;
        $f->backend_id = $b->id;
        $f->enable = 1;
        $f->save();
        return back();
    }

    public function fastAddGate(Request $r)
    {
        $this->validate($r, [
            'gate_name' => 'required',
            'gate_domain' => 'required|unique:gate_sites,domain|unique:web_sites,domain|alpha_dash',
            'gate_schema' => 'required|in:http,https',
            'gate_target' => 'required'
        ]);
        //添加upstream
        $up = new Upstream();
        $up->name = str_replace('.', '_', $r->gate_domain) . '_fast_add';
        $up->type = 'weight';
        $up->schema = $r->gate_schema;
        $up->save();

        //添加 up host
        $uh = new UpstreamHost();
        $uh->upstream_id = $up->id;
        $tmp = explode(':', $r->gate_target);
        $uh->ip = $tmp[0];
        $uh->port = $tmp[1];
        $uh->weight = 10;
        $uh->max_fails = 3;
        $uh->fail_timeout = 120;
        $uh->backup = 0;
        $uh->save();

        //添加 site
        $gs = new GateSite();
        $gs->name = $r->gate_name;
        $gs->domain = $r->gate_domain;
        $gs->upstream_id = $up->id;
        $gs->save();
        return back();
    }

    public function fastAddHttp(Request $r)
    {
        $this->validate($r, [
            'http_domain' => 'required|unique:gate_sites,domain|unique:web_sites,domain|alpha_dash',
            'http_schema' => 'required|in:http,https',
            'http_target' => 'required'
        ]);

        //添加upstream
        $up = new Upstream();
        $up->name = str_replace('.', '_', $r->http_domain) . '_fast_add';
        $up->type = 'weight';
        $up->schema = $r->http_schema;
        $up->save();

        //添加 up host
        $uh = new UpstreamHost();
        $uh->upstream_id = $up->id;
        $tmp = explode(':', $r->http_target);
        $uh->ip = $tmp[0];
        $uh->port = $tmp[1];
        $uh->weight = 10;
        $uh->max_fails = 3;
        $uh->fail_timeout = 120;
        $uh->backup = 0;
        $uh->save();

        $w = new WebSite();
        $w->schema = 'http';
        $w->ssl_id = 0;
        $w->force_https = 0;
        $w->domain = $r->http_domain;
        $w->upstream_id = $up->id;
        $w->save();
        return back();
    }

    public function fastAddHttps(Request $r)
    {
        $this->validate($r, [
            'https_domain' => 'required|unique:gate_sites,domain|unique:web_sites,domain|alpha_dash',
            'https_crt' => 'required',
            'https_key' => 'required',
            'https_schema' => 'required|in:http,https',
            'https_target' => 'required'
        ]);

        //添加证书
        $s = new Ssl();
        $s->name = $r->https_domain . '_fast_add';
        $s->cert = $r->https_crt;
        $s->key = $r->https_key;
        $s->save();

        //添加upstream
        $up = new Upstream();
        $up->name = str_replace('.', '_', $r->https_domain) . '_fast_add';
        $up->type = 'weight';
        $up->schema = $r->https_schema;
        $up->save();

        //添加 up host
        $uh = new UpstreamHost();
        $uh->upstream_id = $up->id;
        $tmp = explode(':', $r->https_target);
        $uh->ip = $tmp[0];
        $uh->port = $tmp[1];
        $uh->weight = 10;
        $uh->max_fails = 3;
        $uh->fail_timeout = 120;
        $uh->backup = 0;
        $uh->save();

        $w = new WebSite();
        $w->schema = 'https';
        $w->ssl_id = $s->id;
        $w->force_https = 1;
        $w->domain = $r->https_domain;
        $w->upstream_id = $up->id;
        $w->save();
        return back();
    }

    public function users()
    {
        return view('admin.system.user', [
            'list' => User::all()
        ]);
    }

    public function addUser(Request $r)
    {
        $this->validate($r, [
            'username' => 'required|unique:users',
            'password' => 'required|min:8'
        ]);
        $u = new User;
        $u->username = $r->input('username');
        $u->password = bcrypt($r->input('password'));
        if ($u->save()) {
            return redirect()->back();
        } else {
            return back()->with(['alert' => 'Add User Failed']);
        }
    }

    public function delUser(Request $r)
    {
        $this->validate($r, [
            'id' => 'required|exists:users'
        ]);
        $u = User::find($r->input('id'));
        $u->roles()->detach();
        $u->delete();
        return redirect()->back();
    }

    public function eyes()
    {
        return view('admin.system.eyes');
    }

    public function sync(Request $r)
    {
        $conf = new Conf();
        //网关配置
        $config = [
            'swg_gate_expire' => cache('swg_gate_expire', 600),
            'swg_gate_mode' => cache('swg_gate_mode', 1),
            'swg_gate_url' => Redis::get('swg_gate_url'),
            'swg_version' => time()
        ];

        //网关代理列表
        $hosts = GateSite::all();
        foreach ($hosts as $h) {
            $config['swg_gate_' . $h->domain] = $h->upstream->schema . '://' . $h->upstream->name;
        }

        //用户权限列表
        $users = User::all();
        foreach ($users as $user) {
            $acl_hosts[$user->id] = [];
            if ($user->roles()->where('role_id', 1)->first()) {
                foreach (GateSite::all() as $h) {
                    $config['swg_gate_' . $h->domain . '_' . $user->id] = 1;
                }
            } else {
                foreach ($user->roles as $ur) {
                    foreach ($ur->hosts as $h) {
                        $config['swg_gate_' . $h->domain . '_' . $user->id] = 1;
                    }
                }
            }
        }

        //证书
        foreach (Ssl::all() as $item) {
            $config["swg_ssl_" . $item->id . "_name"] = $item->name;
            $config["swg_ssl_" . $item->id . "_cert"] = $item->cert;
            $config["swg_ssl_" . $item->id . "_key"] = $item->key;
        }

        //Upstream
        $conf->clear();
        foreach (Upstream::all() as $item) {
            $conf->addLine("upstream " . $item->name . " {");
            if ($item->type != "weight") {
                $conf->addLine("    " . $item['type'] . ";");
            }

            foreach ($item->hosts as $sh) {
                $str = 'server ' . $sh->ip . ':' . $sh->port . " weight=" . $sh->weight;
                if ($sh->max_fails) {
                    $str .= ' max_fails=' . $sh->max_fails;
                }
                if ($sh->fail_timeout) {
                    $str .= ' fail_timeout=' . $sh->fail_timeout;
                }
                if ($sh->backup and $item->type != "ip_hash") {
                    $str .= ' backup';
                }
                $conf->addLine("    " . $str . ";");
            }
            $conf->addLine("}");
            $conf->addLine();
        }
        //website
        foreach (WebSite::all() as $item) {
            if ($item->ssl_id) {
                $conf->addLine("server {");
                $conf->addLine("    listen 443 ssl;");
                $conf->addLine("    server_name " . $item->domain . ";");
                $conf->addLine("    ssl_certificate " . $item->ssl->name . ".crt;");
                $conf->addLine("    ssl_certificate_key " . $item->ssl->name . ".key;");
                $conf->addLine("    location / {");
                $conf->addLine("        proxy_pass " . $item->upstream->schema . "://" . $item->upstream->name . ";");
                $conf->addLine("        client_max_body_size  1000m;");
                $conf->addLine("        proxy_set_header Host \$host;");
                $conf->addLine("        proxy_set_header X-Real-IP \$remote_addr;");
                $conf->addLine("        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;");
                $conf->addLine("        proxy_http_version 1.1;");
                $conf->addLine("        proxy_set_header Upgrade \$http_upgrade;");
                $conf->addLine("        proxy_set_header Connection \"upgrade\";");
                $conf->addLine("    }");
                $conf->addLine("}");
                if ($item->force_https) {
                    $conf->addLine("server {");
                    $conf->addLine("    listen 80;");
                    $conf->addLine("    server_name " . $item->domain . ";");
                    $conf->addLine("    rewrite ^(.*)$  https://\$host\$1 permanent;");
                    $conf->addLine("}");
                }
            } else {
                $conf->addLine("server {");
                $conf->addLine("    listen 80;");
                $conf->addLine("    server_name " . $item->domain . ";");
                $conf->addLine("    location / {");
                $conf->addLine("        proxy_pass " . $item->upstream->schema . "://" . $item->upstream->name . ";");
                $conf->addLine("        client_max_body_size  1000m;");
                $conf->addLine("        proxy_set_header Host \$host;");
                $conf->addLine("        proxy_set_header X-Real-IP \$remote_addr;");
                $conf->addLine("        proxy_set_header X-Forwarded-For \$proxy_add_x_forwarded_for;");
                $conf->addLine("        proxy_http_version 1.1;");
                $conf->addLine("        proxy_set_header Upgrade \$http_upgrade;");
                $conf->addLine("        proxy_set_header Connection keep-alive;");
                $conf->addLine("    }");
                $conf->addLine("}");
            }
        }
        $config['swg_web_config'] = $conf->get();

        $conf->clear();
        foreach (Backend::all() as $item) {
            $conf->addLine("backend " . $item['name']);
            $conf->addLine("    mode tcp");
            $conf->addLine("    balance " . $item['type']);
            foreach ($item->hosts as $h) {
                $str = "server " . $item->name . '-' . str_replace(".", "-", $h->ip) . '-' . $h->port . ' ' . $h->ip . ':' . $h->port;
                if ($h->check) {
                    $str .= " check inter " . $h->inter . " rise " . $h->rise . " fall " . $h->fall;
                }
                if ($item->type == 'roundrobin') {
                    $str .= " weight " . $h->weight;
                }
                $conf->addLine("    " . $str);
            }
        }
        foreach (Front::all() as $item) {
            $name = str_replace(".", "_", str_replace(":", "_", $item->ip . ":" . $item->port));
            $name = str_replace('*', '0_0_0_0', $name);
            $conf->addLine('frontend ' . $name);
            $conf->addLine('    bind ' . $item->ip . ":" . $item->port);
            $conf->addLine('    default_backend ' . $item->backend->name);
        }
        $config['swg_tcp_config'] = $conf->get();

        if ($r->doit == 1) {
            foreach ($config as $k => $v) {
                Redis::set($k, $v);
            }
            return back();
        } else {
            return view('admin.system.sync', ['config' => $config]);
        }
    }
}