<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="8ML9uORRL3kvQV6mQzD52gDXOwMn4LJuMBCpIq31"/>
    <title>管理控制台</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" type="text/css" href="/assets/wangEditor/dist/css/wangEditor.min.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/assets/images/favicon.png"/>

    <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>

    <link rel="stylesheet" id=cal_style type="text/css" href="/assets/datetimer/dist/flatpickr.min.css">
    <script src="/assets/datetimer/src/flatpickr.js"></script>
    <script src="/assets/datetimer/src/flatpickr.l10n.zh.js"></script>
    <style>
        /*定义滚动条高宽及背景 高宽分别对应横竖滚动条的尺寸*/
        ::-webkit-scrollbar {
            width: 5px;
            height: 20px;
            background-color: #F5F5F5;
        }

        /*定义滚动条轨道 内阴影+圆角*/
        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        /*定义滑块 内阴影+圆角*/
        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #b66dff;
        }
    </style>
</head>
<body>
<script src="/assets/layer/layer.js"></script>
<script src="/assets/wangEditor/dist/js/wangEditor.min.js"></script>
<!-- 内容区域 -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi mdi-wrench"></i>
                    </span>
                分类
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">cms</a></li>
                    <li class="breadcrumb-item active" aria-current="page">分类列表</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">列表</h4>
                        <p class="card-description">
                            <button type="button" class="btn btn-sm btn-gradient-success btn-icon-text" onclick="add()">
                                <i class="mdi mdi-plus btn-icon-prepend"></i>
                                添加
                            </button>
                        </p>
                        <div>

                            <style>

                                .TreeGrid {
                                    /*border-collapse: collapse;*/
                                    /*font-size: 11px;*/
                                    /*border: 1px solid #789*/
                                }

                                .TreeGrid .header {
                                    /*background-color: #87ceeb;*/
                                    /*font-size: 11px;*/
                                    font-weight: 600
                                }

                                .TreeGrid td {
                                   /* border: 1px solid #e6e6fa;
                                    padding: 4px 3px 2px*/
                                }

                                .TreeGrid a {
                                   /* text-decoration: underline;
                                    color: #000*/
                                }

                                .TreeGrid a:hover {
                                    color: blue
                                }

                                .TreeGrid .image_hand {
                                    border: 0;
                                    cursor: hand;
                                    align: absmiddle
                                }

                                .TreeGrid .image_nohand {
                                    border: 0;
                                    align: absmiddle
                                }

                                .TreeGrid .row_hover {
                                    background-color: #e6e6fa
                                }

                                .TreeGrid .row_active {
                                    background-color: #e0ffff
                                }
                            </style>


                            <script>
                                /**
                                 * @author 陈举民
                                 * @version 1.0
                                 * @link http://chenjumin.javaeye.com
                                 */
                                TreeGrid = function (_config) {
                                    debugger;
                                    _config = _config || {};

                                    var s = "";
                                    var rownum = 0;
                                    var __root;

                                    var __selectedData = null;
                                    var __selectedId = null;
                                    var __selectedIndex = null;

                                    var folderOpenIcon = (_config.folderOpenIcon || TreeGrid.FOLDER_OPEN_ICON);
                                    var folderCloseIcon = (_config.folderCloseIcon || TreeGrid.FOLDER_CLOSE_ICON);
                                    var defaultLeafIcon = (_config.defaultLeafIcon || TreeGrid.DEFAULT_LEAF_ICON);

                                    //显示表头行
                                    drowHeader = function () {
                                        debugger;
                                        s += "<tr class='header' height='" + (_config.headerHeight || "25") + "'>";
                                        var cols = _config.columns;
                                        for (i = 0; i < cols.length; i++) {
                                            var col = cols[i];
                                            if (col.hidden)
                                                s += "<td style='display:none' align='" + (col.headerAlign || _config.headerAlign || "center") + "' width='" + (col.width || "") + "'>" + (col.headerText || "") + "</td>";
                                            else
                                                s += "<td align='" + (col.headerAlign || _config.headerAlign || "center") + "' width='" + (col.width || "") + "'>" + (col.headerText || "") + "</td>";
                                        }
                                        s += "</tr>";
                                    }

                                    //递归显示数据行
                                    drowData = function () {
                                        var rows = _config.data;
                                        var cols = _config.columns;
                                        drowRowData(rows, cols, 1, "");
                                    }

                                    //局部变量i、j必须要用 var 来声明，否则，后续的数据无法正常显示
                                    drowRowData = function (_rows, _cols, _level, _pid) {

                                        var folderColumnIndex = (_config.folderColumnIndex || 0);

                                        for (var i = 0; i < _rows.length; i++) {
                                            var id = _pid + "_" + i; //行id
                                            var row = _rows[i];

                                            s += "<tr id='TR" + id + "' pid='" + ((_pid == "") ? "" : ("TR" + _pid)) + "' open='Y' data=\"" + TreeGrid.json2str(row) + "\" rowIndex='" + rownum++ + "'>";
                                            for (var j = 0; j < _cols.length; j++) {
                                                var col = _cols[j];
                                                if (col.hidden) {
                                                    s += "<td style='display:none' align='" + (col.dataAlign || _config.dataAlign || "left") + "'";
                                                } else {

                                                    s += "<td align='" + (col.dataAlign || _config.dataAlign || "left") + "'";
                                                }


                                                //层次缩进
                                                if (j == folderColumnIndex) {
                                                    s += " style='text-indent:" + (parseInt((_config.indentation || "20")) * (_level - 1)) + "px;'> ";
                                                } else {
                                                    s += ">";
                                                }

                                                //节点图标
                                                if (j == folderColumnIndex) {
                                                    if (row.children) { //有下级数据
                                                        s += "<img folder='Y' trid='TR" + id + "' src='" + folderOpenIcon + "' class='image_hand'>";
                                                    } else {
                                                        s += "<img src='" + defaultLeafIcon + "' class='image_nohand'>";
                                                    }
                                                }

                                                //单元格内容
                                                if (col.handler) {
                                                    s += (eval(col.handler + ".call(new Object(), row, col)") || "") + "</td>";
                                                } else {
                                                    s += (row[col.dataField] || "") + "</td>";
                                                }
                                            }
                                            s += "</tr>";

                                            //递归显示下级数据
                                            if (row.children) {
                                                drowRowData(row.children, _cols, _level + 1, id);
                                            }
                                        }
                                    }

                                    //主函数
                                    this.show = function () {
                                        this.id = _config.id || ("TreeGrid" + TreeGrid.COUNT++);

                                        s += "<table id='" + this.id + "' cellspacing=0 cellpadding=0 width='" + (_config.width || "100%") + "' class='TreeGrid table table-bordered'>";
                                        drowHeader();
                                        drowData();
                                        s += "</table>";

                                        __root = jQuery("#" + _config.renderTo);
                                        __root.append(s);

                                        //初始化动作
                                        init();
                                    }

                                    init = function () {
                                        //以新背景色标识鼠标所指行
                                        if ((_config.hoverRowBackground || "false") == "true") {
                                            __root.find("tr").hover(
                                                function () {
                                                    if (jQuery(this).attr("class") && jQuery(this).attr("class") == "header") return;
                                                    jQuery(this).addClass("row_hover");
                                                },
                                                function () {
                                                    jQuery(this).removeClass("row_hover");
                                                }
                                            );
                                        }

                                        //将单击事件绑定到tr标签
                                        __root.find("tr").bind("click", function () {
                                            __root.find("tr").removeClass("row_active");
                                            jQuery(this).addClass("row_active");

                                            //获取当前行的数据
                                            __selectedData = this.data || this.getAttribute("data");
                                            __selectedId = this.id || this.getAttribute("id");
                                            __selectedIndex = this.rownum || this.getAttribute("rowIndex");

                                            //行记录单击后触发的事件
                                            if (_config.itemClick) {
                                                eval(_config.itemClick + "(__selectedId, __selectedIndex, TreeGrid.str2json(__selectedData))");
                                            }
                                        });

                                        //展开、关闭下级节点
                                        __root.find("img[folder='Y']").bind("click", function () {
                                            debugger;
                                            var trid = this.trid || this.getAttribute("trid");
                                            var dom = __root.find("#" + trid)[0];
                                            var isOpen = dom.getAttribute("open");
                                            isOpen = (isOpen == "Y") ? "N" : "Y";
                                            dom.setAttribute("open", isOpen);
                                            showHiddenNode(trid, isOpen);
//			var trid = this.trid || this.getAttribute("trid");
//			var isOpen = __root.find("#" + trid).attr("open");
//			isOpen = (isOpen == "Y") ? "N" : "Y";
//			__root.find("#" + trid).attr("open", isOpen);
//			showHiddenNode(trid, isOpen);
                                        });
                                    }

                                    //显示或隐藏子节点数据
                                    showHiddenNode = function (_trid, _open) {
                                        debugger;
                                        if (_open == "N") { //隐藏子节点
                                            __root.find("#" + _trid).find("img[folder='Y']").attr("src", folderCloseIcon);
                                            __root.find("tr[id^=" + _trid + "_]").css("display", "none");
                                        } else { //显示子节点
                                            __root.find("#" + _trid).find("img[folder='Y']").attr("src", folderOpenIcon);
                                            showSubs(_trid);
                                        }
                                    }

                                    //递归检查下一级节点是否需要显示
                                    showSubs = function (_trid) {
                                        debugger;
                                        //	var isOpen = __root.find("#" + _trid).attr("open");
                                        var isOpen = __root.find("#" + _trid)[0].getAttribute("open");
                                        if (isOpen == "Y") {
                                            var trs = __root.find("tr[pid=" + _trid + "]");
                                            trs.css("display", "");

                                            for (var i = 0; i < trs.length; i++) {
                                                showSubs(trs[i].id);
                                            }
                                        }
                                    }

                                    //展开或收起所有节点
                                    this.expandAll = function (isOpen) {
                                        var trs = __root.find("tr[pid='']");
                                        for (var i = 0; i < trs.length; i++) {
                                            var trid = trs[i].id || trs[i].getAttribute("id");
                                            showHiddenNode(trid, isOpen);
                                        }
                                    }

                                    //取得当前选中的行记录
                                    this.getSelectedItem = function () {
                                        return new TreeGridItem(__root, __selectedId, __selectedIndex, TreeGrid.str2json(__selectedData));
                                    }

                                };

                                //公共静态变量
                                TreeGrid.FOLDER_OPEN_ICON = "images/folderOpen.gif";
                                TreeGrid.FOLDER_CLOSE_ICON = "images/folderClose.gif";
                                TreeGrid.DEFAULT_LEAF_ICON = "images/defaultLeaf.gif";
                                TreeGrid.COUNT = 1;

                                //将json对象转换成字符串
                                TreeGrid.json2str = function (obj) {
                                    var arr = [];

                                    var fmt = function (s) {
                                        if (typeof s == 'object' && s != null) {
                                            if (s.length) {
                                                var _substr = "";
                                                for (var x = 0; x < s.length; x++) {
                                                    if (x > 0) _substr += ", ";
                                                    _substr += TreeGrid.json2str(s[x]);
                                                }
                                                return "[" + _substr + "]";
                                            } else {
                                                return TreeGrid.json2str(s);
                                            }
                                        }
                                        return /^(string|number)$/.test(typeof s) ? "'" + s + "'" : s;
                                    }

                                    for (var i in obj) {
                                        if (typeof obj[i] != 'object') { //暂时不包括子数据
                                            arr.push(i + ":" + fmt(obj[i]));
                                        }
                                    }

                                    return '{' + arr.join(', ') + '}';
                                }

                                TreeGrid.str2json = function (s) {
                                    debugger;
                                    var json = null;
                                    var explorer = navigator.userAgent;
                                    if (explorer.indexOf("MSIE") >= 0) {
                                        json = eval("(" + s + ")");
                                    } else {
                                        json = new Function("return " + s)();
                                    }
                                    return json;
//	if(jQuery.browser.msie){
//		json = eval("(" + s + ")");
//	}else{
//		json = new Function("return " + s)();
//	}
//	return json;
                                }

                                //数据行对象
                                function TreeGridItem(_root, _rowId, _rowIndex, _rowData) {
                                    var __root = _root;

                                    this.id = _rowId;
                                    this.index = _rowIndex;
                                    this.data = _rowData;

                                    this.getParent = function () {
                                        var pid = jQuery("#" + this.id).attr("pid");
                                        if (pid != "") {
                                            var rowIndex = jQuery("#" + pid).attr("rowIndex");
                                            var data = jQuery("#" + pid).attr("data");
                                            return new TreeGridItem(_root, pid, rowIndex, TreeGrid.str2json(data));
                                        }
                                        return null;
                                    }

                                    this.getChildren = function () {
                                        var arr = [];
                                        var trs = jQuery(__root).find("tr[pid='" + this.id + "']");
                                        for (var i = 0; i < trs.length; i++) {
                                            var tr = trs[i];
                                            arr.push(new TreeGridItem(__root, tr.id, tr.rowIndex, TreeGrid.str2json(tr.data)));
                                        }
                                        return arr;
                                    }
                                };


                                /*

                                            单击数据行后触发该事件

                                            id：行的id

                                            index：行的索引。

                                            data：json格式的行数据对象。

                                        */

                                function itemClickEvent(id, index, data) {

                                    jQuery("#currentRow").val(id + ", " + index + ", " + TreeGrid.json2str(data));

                                }


                                /*

                                    通过指定的方法来自定义栏数据

                                */

                                function customCheckBox(row, col) {

                                    return "<input type='checkbox'>";

                                }


                                function customOrgName(row, col) {

                                    var name = row[col.dataField] || "";

                                    return name;

                                }


                                function customLook(row, col) {

                                    return "<a href='javascript:(0)' style='color:blue;'>查看</a> | <a href='javascript:(0)' style='color:blue;'>删除</a>";

                                }

                                /*

                                    展开、关闭所有节点。

                                    isOpen=Y表示展开，isOpen=N表示关闭

                                */

                                function expandAll(isOpen) {

                                    treeGrid.expandAll(isOpen);

                                }


                                /*

                                    取得当前选中的行，方法返回TreeGridItem对象

                                */

                                function selectedItem() {

                                    var treeGridItem = treeGrid.getSelectedItem();

                                    if (treeGridItem != null) {

                                        //获取数据行属性值

                                        //alert(treeGridItem.id + ", " + treeGridItem.index + ", " + treeGridItem.data.name);


                                        //获取父数据行

                                        var parent = treeGridItem.getParent();

                                        if (parent != null) {

                                            //jQuery("#currentRow").val(parent.data.name);

                                        }


                                        //获取子数据行集
                                        var children = treeGridItem.getChildren();

                                        if (children != null && children.length > 0) {

                                            jQuery("#currentRow").val(children[0].data.name);

                                        }

                                    }

                                }
                            </script>

                            <script>
                                window.onload = function () {
                                    var config = {
                                        id: "tg1",
                                        width: "800",
                                        renderTo: "div1",
                                        headerAlign: "left",
                                        headerHeight: "30",
                                        dataAlign: "left",
                                        indentation: "20",
                                        folderOpenIcon: "http://www.jq22.com/demo/TreeGrid20161024/images/folderOpen.png",
                                        folderCloseIcon: "http://www.jq22.com/demo/TreeGrid20161024/images/folderClose.png",
                                        defaultLeafIcon: "http://www.jq22.com/demo/TreeGrid20161024/images/defaultLeaf.gif",
                                        hoverRowBackground: "false",
                                        folderColumnIndex: "1",
                                        itemClick: "itemClickEvent",
                                        columns: [{
                                            headerText: "ID",
                                            headerAlign: "center",
                                            dataAlign: "center",
                                            width: "40"
                                        },
                                            {
                                                headerText: "名称",
                                                dataField: "name",
                                                headerAlign: "center",
                                                /*width: "100",*/
                                                handler: "customOrgName"
                                            },
                                            {
                                                headerText: "图标",
                                                dataField: "code",
                                                headerAlign: "center",
                                                dataAlign: "center",
                                                width: "300",
                                                hidden: false
                                            },
                                            {
                                                headerText: "级别",
                                                dataField: "assignee",
                                                headerAlign: "center",
                                                dataAlign: "center",
                                                width: "100"
                                            },
                                            {
                                                headerText: "查看",
                                                headerAlign: "center",
                                                dataAlign: "center",
                                                width: "150",
                                                handler: "customLook"
                                            }],
                                        data: [
                                            {
                                                name: "城区分公司",
                                                code: "CQ",
                                                assignee: "",
                                                children: [{
                                                    name: "城区卡品分销中心"
                                                },
                                                    {
                                                        name: "先锋服务厅",
                                                        children: [{
                                                            name: "chlid1"
                                                        },
                                                            {
                                                                name: "chlid2"
                                                            },
                                                            {
                                                                name: "chlid3",
                                                                children: [{
                                                                    name: "chlid3-1"
                                                                },
                                                                    {
                                                                        name: "chlid3-2"
                                                                    },
                                                                    {
                                                                        name: "chlid3-3"
                                                                    },
                                                                    {
                                                                        name: "chlid3-4"
                                                                    }]
                                                            }]
                                                    },
                                                    {
                                                        name: "半环服务厅"
                                                    }]
                                            },
                                            {
                                                name: "清新分公司",
                                                code: "QX",
                                                assignee: "",
                                                children: []
                                            },
                                            {
                                                name: "英德分公司",
                                                code: "YD",
                                                assignee: "",
                                                children: []
                                            },
                                            {
                                                name: "佛冈分公司",
                                                code: "FG",
                                                assignee: "",
                                                children: []
                                            }]
                                    };
                                    debugger;
                                    var treeGrid = new TreeGrid(config);
                                    treeGrid.show()
                                }
                            </script>
                            <div id="div1"></div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function add() {
        var page = layer.open({
            type: 2,
            title: '添加',
            shadeClose: true,
            shade: 0.8,
            area: ['70%', '90%'],
            content: '/admin/cms/category/add'
        });
    }

    function update(id) {
        var page = layer.open({
            type: 2,
            title: '修改',
            shadeClose: true,
            shade: 0.8,
            area: ['70%', '90%'],
            content: '/admin/cms/category/update/' + id
        });
    }

    function del(id) {
        myConfirm("删除操作不可逆,是否继续?", function () {
            myRequest("/admin/cms/category/del/" + id, "post", {}, function (res) {
                layer.msg(res.msg)
                setTimeout(function () {
                    window.location.reload();
                }, 1500)
            });
        });
    }

    $('.menu-switch').click(function () {
        id = $(this).attr('id');
        state = $(this).attr('state');
        console.log(id)
        console.log(state)
        if (state == "on") {
            $('.pid-' + id).hide();
            $(this).attr("state", "off")
            $(this).removeClass('mdi-menu-down').addClass('mdi-menu-right');
        } else {
            $('.pid-' + id).show();
            $(this).attr("state", "on")
            $(this).removeClass('mdi-menu-right').addClass('mdi-menu-down');
        }
    })
</script>
<!-- plugins:js -->
<script src="/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="/assets/vendors/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="/assets/js/off-canvas.js"></script>
<script src="/assets/js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="/assets/js/dashboard.js"></script>
<script src="/assets/js/common.js"></script>
<!-- End custom js for this page-->
</body>

</html>
