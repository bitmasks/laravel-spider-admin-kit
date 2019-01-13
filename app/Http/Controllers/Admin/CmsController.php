<?php
/**
 * Created by PhpStorm.
 * Author: tao <304550409@qq.com>
 * Date: 18-10-26下午1:23
 * Desc: 管理员
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;

class CmsController extends Controller
{
    /**
     * 分类列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categoryList() {

        $list = DB::table('cms_category')
            ->orderBy('sort', 'DESC')
            ->get();

        $list = asArray($list);


        $list = $this->tree($list);


        return view('admin.category', ['list' => json_encode($list, JSON_UNESCAPED_UNICODE)]);
    }


    public function tree(&$collection, $parentId = '0', &$item = null, $name = 'children') {

        $tree = [];
        foreach ($collection as $key => $value) {
            if ($value['pid'] == $parentId) {

                $this->unset($collection, $value, $key);
                if ($item) $item[$name][] = $value;
                else $tree[] = $value;
            }
        };
        return $tree;
    }


    public function unset(&$collection, &$value, $key) {
        unset($collection[$key]);
        $this->tree($collection, $value['id'], $value);
    }


    /**
     * @Desc: 添加
     * @Author: woann <304550409@qq.com>
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function categoryAdd(Request $request) {
        if ($request->isMethod('post')) {

            $name = $request->input('name');
            if (!count($name)) {
                return $this->json(500, '未输入名称');
            }
            $data["name"] = $name;

            $data["short_name"] = $request->input('short_name', '');

            $pid = $request->input('pid', 0);
            $data["pid"] = $pid;
            $checkP = DB::table('cms_category')->where('id', '=', $pid)->first();
            $data["level"] = $checkP->pid+1;

            $data["icon"] = $request->input('icon', '');
            $data["sort"] = $request->input('sort', 0);


            $data["created_at"] = date("Y-m-d H:i:s");
            $data["updated_at"] = date("Y-m-d H:i:s");
            $category_id = DB::table('cms_category')->insertGetId($data);
            if (!$category_id) {
                return $this->json(500, '添加失败');
            }
            return $this->json(200, '添加成功');
        } else {

            $p = DB::table('cms_category')->get();

            return view('admin.category_add', ['p' => $p]);
        }
    }

    /**
     * @Desc: 修改菜单
     * @Author: woann <304550409@qq.com>
     * @param Request $request
     * @param $id
     * @return \Illuminate\View\View
     */
    public function categoryUpdate(Request $request, $id = 0) {

        if ($request->isMethod("POST")) {

            $name = $request->post('name');
            if (!count($name)) {
                return $this->json(500, '未输入名称');
            }
            $data["name"] = $name;


            $data["short_name"] = $request->input('short_name', '');

            $pid = $request->input('pid', 0);
            $data["pid"] = $pid;
            $checkP = DB::table('cms_category')->where('id', '=', $pid)->first();
            $data["level"] = ($checkP->level)+1;


            $data["icon"] = $request->input('icon', '');
            $data["sort"] = $request->input('sort', 0);


            $data["created_at"] = date("Y-m-d H:i:s");
            $data["updated_at"] = date("Y-m-d H:i:s");
            $category_id = DB::table('cms_category')->insertGetId($data);
            if (!$category_id) {
                return $this->json(500, '添加失败');
            }
            return $this->json(200, '添加成功');

        } else {

            $info = DB::table('cms_category')->where('id', '=', $id)->first();
            $p = DB::table('cms_category')->get();
            return view('admin.category_update', ['info' => $info, 'p' => $p]);
        }
    }

    /**
     * @Desc: 删除菜单
     * @Author: woann <304550409@qq.com>
     * @param $id
     * @return mixed
     */
    public function categoryDel($id) {
        $res = DB::table('cms_category')->delete($id);
        if (!$res) {
            return $this->json(500, '删除失败');
        }
        DB::table('cms_category')->where('pid', $id)->delete();
        return $this->json(200, '删除成功');
    }


    /**
     * 文章列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public
    function articleList() {
        $list = DB::table('cms_article')->orderBy('sort', 'DESC')->paginate(10);
        return view('admin.article', ['list' => $list]);
    }

    /**
     * @Desc: 添加角色
     * @Author: woann <304550409@qq.com>
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function articleAdd(Request $request) {
        if ($request->isMethod("POST")) {
            $param = $request->post();
            $data = [];
            $data["name"] = $param['name'];
            $data["des"] = $param['des'];
            $data["created_at"] = date("Y-m-d H:i:s");
            $data["updated_at"] = date("Y-m-d H:i:s");
            $role_id = DB::table('admin_role')->insertGetId($data);
            if (!$role_id) {
                return $this->json(500, "添加失败");
            }
            $data = [];
            foreach ($param["permission"] as $k => $v) {
                $data[$k]["role_id"] = $role_id;
                $data[$k]["permission_id"] = $v;
            }
            $res = DB::table('admin_role_permission')->insert($data);
            if (!$res) {
                DB::table('admin_role')->delete($role_id);
                return $this->json(500, "添加失败");
            }
            return $this->json(200, "添加成功");
        } else {
            $permission_list = DB::table('admin_permission')->get();
            return view('admin.role_add', ['permission_list' => $permission_list]);
        }
    }

    /**
     * @Desc: 修改角色
     * @Author: woann <304550409@qq.com>
     * @param Request $request
     * @param $id
     * @return \Illuminate\View\View
     */
    public
    function articleUpdate(Request $request, $id) {
        if ($request->isMethod("POST")) {
            $param = $request->post();
            $data = [];
            $data["name"] = $param['name'];
            $data["des"] = $param['des'];
            $data["updated_at"] = date("Y-m-d H:i:s");
            DB::table('admin_role')->where('id', $id)->update($data);
            $data = [];
            foreach ($param["permission"] as $k => $v) {
                $data[$k]["role_id"] = $id;
                $data[$k]["permission_id"] = $v;
            }
            DB::table('admin_role_permission')->where('role_id', $id)->delete();
            $res = DB::table('admin_role_permission')->insert($data);
            if (!$res) {
                return $this->json(500, "修改失败");
            }
            return $this->json(200, "修改成功");
        } else {
            $res = DB::table('admin_role')->find($id);
            $my_permission = DB::table('admin_role_permission')->select('permission_id')->where('role_id', $id)->get();
            $permission_list = DB::table('admin_permission')->get();
            $my_permission_ids = [];
            foreach ($my_permission as $k => $v) {
                $my_permission_ids[] = $v->permission_id;
            }
            foreach ($permission_list as $k => $v) {
                if (in_array($v->id, $my_permission_ids)) {
                    $permission_list[$k]->checked = true;
                } else {
                    $permission_list[$k]->checked = false;
                }
            }
            return view('admin.role_update', ['res' => $res, 'permission_list' => $permission_list]);
        }
    }

    /**
     * @Desc: 删除角色
     * @Author: woann <304550409@qq.com>
     * @param $id
     * @return mixed
     */
    public function articleDel($id) {
        if ($id == 1) {
            return $this->json(500, '超级管理员不可删除');
        }
        $res = DB::table('admin_role')->delete($id);
        if (!$res) {
            //删除该角色和权限的关联
            DB::table('admin_role_permission')->where('role_id', $id)->delete();
            //删除角色和管理员的关联
            DB::table('admin_user_role')->where('role_id', $id)->delete();
            return $this->json(500, '删除失败');
        }
        return $this->json(200, '删除成功');
    }


}
