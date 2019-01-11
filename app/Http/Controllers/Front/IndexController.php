<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index() {

        $admin = session('admin');
        $user_role = DB::table('admin_user_role')->where('admin_user_id', $admin->id)->first();
        $role_id = $user_role->role_id;
        $menu_list = DB::table('admin_role_menu as rm')
            ->leftJoin('admin_menu as m', 'm.id', '=', 'rm.menu_id')
            ->where('rm.role_id', $role_id)
            ->where('m.pid', 0)
            ->select('m.*')
            ->orderBy('m.sort', 'DESC')
            ->get();
        foreach ($menu_list as $k => $v) {
            $menu_list[$k]->child = DB::table('admin_role_menu as rm')
                ->leftJoin('admin_menu as m', 'm.id', '=', 'rm.menu_id')
                ->where('rm.role_id', $role_id)
                ->where('m.pid', $v->id)
                ->select('m.*')
                ->orderBy('m.sort', 'DESC')
                ->get();
            if (count($menu_list[$k]->child)) {
                $menu_list[$k]->has_child = true;
            } else {
                $menu_list[$k]->has_child = false;
            }
        }
        return view('front.index', ['menu' => $menu_list]);
    }

}
