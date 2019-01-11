<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'rbac'], function () use($router) {
    //框架
    $router->get('/','Admin\IndexController@index');
    //控制台
    $router->get('/console','Admin\IndexController@console');
    //403无访问权限
    $router->get('/403','Admin\IndexController@noPermission');
    $router->group(['prefix' => 'admin'], function () use($router) {
        //菜单管理
        $router->get('/menu/list', 'Admin\AdministratorController@menuList');
        $router->any('/menu/add', 'Admin\AdministratorController@menuAdd');
        $router->any('/menu/update/{id}', 'Admin\AdministratorController@menuUpdate');
        $router->post('/menu/del/{id}', 'Admin\AdministratorController@menuDel');
        //角色管理
        $router->get('/role/list', 'Admin\AdministratorController@roleList');
        $router->any('/role/add', 'Admin\AdministratorController@roleAdd');
        $router->any('/role/update/{id}', 'Admin\AdministratorController@roleUpdate');
        $router->post('/role/del/{id}', 'Admin\AdministratorController@roleDel');
        //权限管理
        $router->get('/permission/list','Admin\AdministratorController@permissionList');
        $router->any('/permission/add','Admin\AdministratorController@permissionAdd');
        $router->any('/permission/update/{id}','Admin\AdministratorController@permissionUpdate');
        $router->post('/permission/del/{id}','Admin\AdministratorController@permissionDel');
        //管理员管理
        $router->get('/administrator/list','Admin\AdministratorController@administratorList');
        $router->any('/administrator/add','Admin\AdministratorController@administratorAdd');
        $router->any('/administrator/update/{id}','Admin\AdministratorController@administratorUpdate');
        $router->post('/administrator/del/{id}','Admin\AdministratorController@administratorDel');
        //配置管理
        $router->get('/config/list','Admin\ConfigController@configList');
        $router->any('/config/add','Admin\ConfigController@configAdd');
        $router->any('/config/update/{id}','Admin\ConfigController@configUpdate');
        $router->post('/config/del/{id}','Admin\ConfigController@configDel');
        //图片上传
        $router->post('/upload','Admin\IndexController@upload');
        $router->post('/wangeditor/upload','Admin\IndexController@wangeditorUpload');
    });
    //修改个人信息
    $router->any('/edit/info/{id}','Admin\AdministratorController@editInfo');
    //退出登录
    $router->get('/logout','Admin\AdministratorController@logout');

});
$router->any('/login','Admin\AdministratorController@login');
$router->get('/icon', function(){
    return view('admin.icon');
});


