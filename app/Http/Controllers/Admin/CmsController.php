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
     * 文章分类列表
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


    /**
     * 树状结构获取
     * @param $collection
     * @param string $parentId
     * @param null $item
     * @param string $name
     * @return array
     */
    private function tree(&$collection, $parentId = '0', &$item = null, $name = 'children') {

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


    /**
     * 树状结构2
     * @param $collection
     * @param $value
     * @param $key
     */
    private function unset(&$collection, &$value, $key) {
        unset($collection[$key]);
        $this->tree($collection, $value['id'], $value);
    }


    /**
     * @Desc: 分类添加
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
            $data["level"] = $checkP->pid + 1;

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
     * @Desc: 修改分类
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
            $data["level"] = 1;
            if ($pid) {
                $checkP = DB::table('cms_category')->where('id', '=', $pid)->first();
                $data["level"] = ($checkP->level) + 1;
            }
            $data["icon"] = $request->input('icon', '');
            $data["sort"] = $request->input('sort', 0);

            $data["updated_at"] = date("Y-m-d H:i:s");
            $category_id = DB::table('cms_category')->where('id', $id)->update($data);
            if (!$category_id) {
                return $this->json(500, '修改失败');
            }
            return $this->json(200, '修改成功');

        } else {

            $info = DB::table('cms_category')->where('id', '=', $id)->first();
            $p = DB::table('cms_category')->get();
            return view('admin.category_update', ['info' => $info, 'p' => $p]);
        }
    }

    /**
     * @Desc: 删除分类
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
     * 根据最后一级分类获取最顶级分类
     * @param $cid
     * @return mixed
     */
    private function getCategoryParentId($cid) {
        $info = DB::table('cms_category')->where('id', '=', $cid)->first();

        if ($info->level == 1) {
            return $info->id;
        }
        return $this->getCategoryParentId($info->pid);

    }

    /**
     * 文章列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articleList() {
        $list = DB::table('cms_article')->orderBy('sort', 'DESC')->paginate(10);
        return view('admin.article', ['list' => $list]);
    }

    /**
     * @Desc: 添加文章
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function articleAdd(Request $request) {
        if ($request->isMethod("POST")) {
            $param = $request->post();

            if (!isset($param['category_id']) || !$param['category_id']) {
                return $this->json(500, "所属分类不能为空");
            }

            if (!isset($param['title']) || !$param['title']) {
                return $this->json(500, "标题不能为空");
            }

            $data["category1_id"] = $this->getCategoryParentId($param['category_id']);

            if (!$data["category1_id"]) {
                return $this->json(500, "所选分类不可用");
            }

            $data["category2_id"] = $param['category_id'];
            $data["title"] = $param['title'];
            $data["cover"] = $request->post('cover', '');
            $data["desc"] = $request->post('desc', '');
            $data["author"] = $request->post('author', '');
            $data["content"] = $request->post('content', '');
            $data["sort"] = $request->post('sort', 0);
            $data["advertising"] = $request->post('advertising', '') ? 1 : 0;
            $data["recommend"] = $request->post('recommend', '') ? 1 : 0;
            $data["created_at"] = date("Y-m-d H:i:s");
            $data["updated_at"] = date("Y-m-d H:i:s");

            $res = DB::table('cms_article')->insert($data);
            if (!$res) {
                return $this->json(500, "添加失败");
            }
            return $this->json(200, "添加成功");
        } else {
            $c = DB::table('cms_category')->get();
            return view('admin.article_add', ['c' => $c]);
        }
    }


    /**
     * @Desc: 修改文章
     * @param Request $request
     * @param $id
     * @return \Illuminate\View\View
     */
    public function articleUpdate(Request $request, $id) {
        if ($request->isMethod("POST")) {
            $param = $request->post();


            if (!isset($param['id']) || !$param['id']) {
                return $this->json(500, "参数错误");
            }

            if (!isset($param['category_id']) || !$param['category_id']) {
                return $this->json(500, "所属分类不能为空");
            }

            if (!isset($param['title']) || !$param['title']) {
                return $this->json(500, "标题不能为空");
            }

            $data["category1_id"] = $this->getCategoryParentId($param['category_id']);

            if (!$data["category1_id"]) {
                return $this->json(500, "所选分类不可用");
            }

            $data["category2_id"] = $param['category_id'];
            $data["title"] = $param['title'];
            $data["cover"] = $request->post('cover', '');
            $data["desc"] = $request->post('desc', '');
            $data["author"] = $request->post('author', '');
            $data["content"] = $request->post('content', '');
            $data["sort"] = $request->post('sort', 0);
            $data["advertising"] = $request->post('advertising', '') ? 1 : 0;
            $data["recommend"] = $request->post('recommend', '') ? 1 : 0;
            $data["created_at"] = date("Y-m-d H:i:s");
            $data["updated_at"] = date("Y-m-d H:i:s");

            $res = DB::table('cms_article')->where('id', $id)->update($data);
            if (!$res) {
                return $this->json(500, "修改失败");
            }
            return $this->json(200, "修改成功");
        } else {
            $info = DB::table('cms_article')->where('id', $id)->first();
            $c = DB::table('cms_category')->get();
            return view('admin.article_update', ['info' => $info, 'c' => $c]);
        }
    }

    /**
     * @Desc: 删除文章
     * @param $id
     * @return mixed
     */
    public function articleDel($id) {
        $res = DB::table('cms_article')->delete($id);
        if (!$res) {
            return $this->json(500, '删除失败');
        }
        return $this->json(200, '删除成功');
    }


}
