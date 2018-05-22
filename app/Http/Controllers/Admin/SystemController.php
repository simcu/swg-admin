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
use App\Models\Front;
use App\Models\GateSite;
use App\Models\Ssl;
use App\Models\Upstream;
use App\Models\User;
use App\Models\WebSite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SystemController extends Controller
{
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

    public function sync()
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
        $config['swg_web_upstream'] = $conf->get();
        $conf->clear();
        //website
        foreach (WebSite::all() as $item) {
            if ($item->ssl_id) {
                $conf->addLine("server {");
                $conf->addLine("    listen 443 ssl;");
                $conf->addLine("    server_name " . $item->domain . ";");
                $conf->addLine("    ssl_certificate /home/config/ssl/" . $item->ssl->name . ".crt;");
                $conf->addLine("    ssl_certificate_key /home/config/ssl/" . $item->ssl->name . ".key;");
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
                $conf->addLine("        proxy_set_header Connection \"upgrade\";");
                $conf->addLine("    }");
                $conf->addLine("}");
            }
        }
        $config['swg_web_config'] = $conf->get();

//HA Backend
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
        $config['swg_tcp_backend'] = $conf->get();
//HA Front
        $conf->clear();
        foreach (Front::all() as $item) {
            $name = str_replace(".", "_", str_replace(":", "_", $item->ip . ":" . $item->port));
            $name = str_replace('*', '0_0_0_0', $name);
            $conf->addLine('frontend ' . $name);
            $conf->addLine('    bind ' . $item->ip . ":" . $item->port);
            $conf->addLine('    default_backend ' . $item->backend->name);
        }
        $config['swg_tcp_frontend'] = $conf->get();

//开始同步规则
        foreach ($config as $k => $v) {
            Redis::set($k, $v);
        }
        echo "同步规则完成 .... <a href='/admin'>返回</a>";
        dd($config);
    }
}