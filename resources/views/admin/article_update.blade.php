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
                                    <label for="exampleInputPassword4">选择分类</label>
                                    <select class="form-control" type="number" name="category_id">
                                        <option value="0" @if($info->category2_id === 0 )  selected @endif >无</option>
                                        @foreach($c as $k=>$v)
                                            <option value="{{ $v->id }}"
                                                    @if($info->category2_id === $v->id ) selected @endif >
                                                @if($v->level == 2) --
                                                @elseif($v->level == 3) ---
                                                @endif
                                                {{ $v->name }}
                                            </option>
                                        @endforeach


                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>* 标题</label>
                                    <input type="text" class="form-control required" name="title"
                                           value="{{ $info->title  }}">
                                </div>


                                <div class="form-group" id="cover">
                                    <label>* 封面图</label>
                                    <input type="file" class="file-upload-default img-file" value="{{ $info->cover  }}">
                                    <input type="hidden" class="image-path value-input" name="cover"
                                           value="{{ $info->cover  }}">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                               value="{{ $info->cover  }}">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-gradient-primary"
                                                    onclick="upload($(this))" type="button">上传</button>
                                        </span>
                                    </div>
                                    <div class="img-yl">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>介绍</label>
                                    <textarea class="form-control" name="desc" rows="4">{{ $info->desc }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>作者</label>
                                    <input type="text" class="form-control" name="author" value="{{ $info->author  }}">
                                </div>

                                <div class="form-group">
                                    <label>内容</label>
                                    <textarea placeholder="请在此处编辑内容" name="content" id="editor"
                                              style="height:400px;max-height:400px;overflow: hidden"> {!! $info->content !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail3">权重</label>
                                    <input type="text" class="form-control" name="sort"
                                           placeholder="权重 数字越大,排名越靠前" value="{{ $info->sort  }}">
                                </div>


                                <div class="form-group">
                                    <div class="form-check col-md-1 col-sm-1" style="display: inline-block;">
                                        <label class="form-check-label" style="margin-left: 0">
                                            推荐
                                            <i class="input-helper"></i></label>
                                    </div>

                                    <div class="form-check col-md-2 col-sm-2" style="display: inline-block;">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="advertising"
                                                   @if($info->advertising) checked @endif>
                                            轮播图
                                            <i class="input-helper"></i>
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>
                                    <div class="form-check col-md-2 col-sm-2" style="display: inline-block;">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="recommend"
                                                   @if($info->recommend) checked @endif>
                                            推荐阅读
                                            <i class="input-helper"></i>
                                            <i class="input-helper"></i>
                                        </label>
                                    </div>

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

        var editor = new wangEditor('editor');
        // 上传图片（举例）
        editor.config.uploadImgUrl = "/admin/wangeditor/upload";
        // 隐藏掉插入网络图片功能。该配置，只有在你正确配置了图片上传功能之后才可用。
        editor.config.hideLinkImg = false;
        editor.create();

        function commit() {
            if (!checkForm()) {
                return false;
            }
            var data = $("#form").serializeObject();
            myRequest("/admin/cms/article/update", "post", data, function (res) {
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