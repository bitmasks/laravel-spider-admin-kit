@extends('base.base')
@section('base')
    <!-- 内容区域 -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">请填写</h4>
                            {{--<p class="card-description">--}}
                            {{--Basic form elements--}}
                            {{--</p>--}}
                            <form class="forms-sample" id="form">

                                <input type="hidden" name="id" value="{{ $info->id  }}">

                                <div class="form-group">
                                    <label>* 名称</label>
                                    <input type="text" class="form-control required" name="name"
                                           value="{{ $info->name  }}">
                                </div>


                                <div class="form-group">
                                    <label>简称</label>
                                    <input type="text" class="form-control" name="short_name"
                                           value="{{ $info->short_name  }}">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputPassword4">选择上一级</label>
                                    <select class="form-control" name="pid">
                                        <option value="0" @if($info->pid == 0) selected @endif >无</option>

                                        @foreach($p as $k=>$v)
                                            <option value="{{ $v->id }}"
                                                    @if($info->id == $v->id) disabled @endif
                                                    @if($info->pid == $v->id) selected @endif >
                                                @if($v->level == 2) --
                                                @elseif($v->level == 3) ---
                                                @endif
                                                {{ $v->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail3">菜单图标</label>
                                    <input type="text" class="form-control" name="icon"
                                           placeholder="菜单图标对应class值,二级菜单留空即可" value="{{ $info->icon  }}">
                                    <p class="card-description">
                                        点击查看<a href="/admin/icon" target="_blank">图标库</a>
                                    </p>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail3">权重</label>
                                    <input type="text" class="form-control" name="sort"
                                           placeholder="权重 数字越大,排名越靠前" value="{{ $info->sort  }}">
                                </div>

                                <button type="button" onclick="commit()"
                                        class="btn btn-sm btn-gradient-primary btn-icon-text">
                                    <i class="mdi mdi-file-check btn-icon-prepend"></i>
                                    提交
                                </button>
                                <button type="button" onclick="cancel()"
                                        class="btn btn-sm btn-gradient-warning btn-icon-text">
                                    <i class="mdi mdi-reload btn-icon-prepend"></i>
                                    取消
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>


        function commit() {
            if (!checkForm()) {
                return false;
            }
            var data = $("#form").serializeObject();
            myRequest("/admin/cms/category/update/", "post", data, function (res) {
                layer.msg(res.msg);
                if (res.code === 200) {
                    setTimeout(function () {
                        parent.location.reload();
                    }, 1500)
                }

            });
        }

        function cancel() {
            parent.location.reload();
        }
    </script>
@endsection