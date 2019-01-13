## 项目简介
基于yamecent-admin二次开发的管理后台：

* RABC权限管理模块1.0版本
* 落地MYSQL的配置
* CMS系统：分类管理（  全称，简称，无限级） ，内容管理（指定两级分类 ，加入广告图推荐 ，加入到推荐阅读） 

1. 创建模型
    php artisan make:model Models/Category
2. 创建迁移文件
    php artisan make:migration create_categories_table
3. 创建填充文件
    php artisan make:seeder CategoriesSeeder
4. 创建后端控制器
    php artisan admin:make CategoryController --model=App\Models\Category
5. 创建后端路由
    app/admin/routes.php ： $router->resource('/web/categories',Admin/CategoryController::class);
6. 添加后端菜单
    /web/categories：菜单路径
7. 其他定义及编辑定制