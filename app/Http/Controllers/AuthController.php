<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Session;
use Cache;
use Redis;

class AuthController extends Controller
{
    public function login(Request $r)
    {
        if (session('logined', false)) {
            return $this->redirectUrl($r);
        } else {
            return view('login');
        }
    }

    public function doLogin(Request $r)
    {
        $u = User::where('username', $r->input('username'))->where('status', 1)->first();
        if ($u and Hash::check($r->input('password'), $u->password)) {
            $sess = [
                'user' => $u,
                'login_time' => time(),
                'last_url' => $r->input('ref')
            ];
            session(['logined' => $sess]);
            return $this->redirectUrl($r);
        } else {
            return redirect('/login')->with('msg', '登录失败，请重试');
        }
    }

    public function logout()
    {
        Session::forget('logined');
        return redirect('/login');
    }

    public function index(Request $r)
    {
        if ($r->input('ref')) {
            Session(['logined.last_url' => $r->input('ref')]);
            $token = md5(time() . rand(1, 2832837) . $r->input('ref') . session('logined.login_time'));
            $exp = Carbon::now()->addSeconds(Cache::get('config_token_expire', 600));
            Cache::put('token_' . $token, session('logined.user.id'), $exp);
            $bkurl = $r->input('ref');
            return redirect($bkurl . ((strpos($bkurl, '?') !== false) ? '&' : '?') . 'swg_token=' . $token);
        } else {
            return view('home');
        }
    }

    private function redirectUrl($r)
    {
        if ($r->input('ref')) {
            return redirect('/?ref=' . $r->input('ref'));
        } else {
            return redirect('/');
        }
    }
}