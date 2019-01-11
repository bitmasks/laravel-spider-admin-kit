

<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item nav-profile">
                <a href="#" class="nav-link">
                    <div class="nav-profile-image">
                        <img src="{{ session('admin')->avatar }}" alt="profile">
                        <span class="login-status online"></span>
                    </div>
                    <div class="nav-profile-text d-flex flex-column">
                        <span class="font-weight-bold mb-2">{{ session('admin')->account }}</span>
                        <span class="text-secondary text-small">{{ session('admin')->nickname }}</span>
                    </div>
                    <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/admin">
                    <span class="menu-title">控制台</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>
            @if(session('admin')->id == 1 )
                <li class="nav-item">
                    <a class="nav-link" target="main" href="/admin/config/list">
                        <span class="menu-title">配置项</span>
                        <i class="mdi mdi-settings-box menu-icon"></i>
                    </a>
                </li>
            @endif
            @foreach($menu as $k=>$v)
                @if($v->has_child)
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#system-pages-{{$v->id}}" aria-expanded="false"
                           aria-controls="general-pages">
                            <span class="menu-title">{{ $v->name }}</span>
                            <i class="menu-arrow"></i>
                            <i class="{{ $v->icon }} menu-icon"></i>
                        </a>
                        <div class="collapse" id="system-pages-{{$v->id}}">
                            <ul class="nav flex-column sub-menu">
                                @foreach($v->child as $key=>$val)
                                    <li class="nav-item"><a class="nav-link" target="main"
                                                            href="{{ $val->url }}">{{ $val->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" target="main" href="{{ $v->url }}">
                            <span class="menu-title">{{ $v->name }}</span>
                            <i class="{{ $v->icon }} menu-icon"></i>
                        </a>
                    </li>
                @endif

            @endforeach
            @if(session('admin')->id == 1 )
                <li class="nav-item">
                    <a class="nav-link" data-toggle="collapse" href="#system-pages" aria-expanded="false"
                       aria-controls="general-pages">
                        <span class="menu-title">系统设置</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-settings menu-icon"></i>
                    </a>
                    <div class="collapse" id="system-pages">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" target="main" href="/admin/menu/list">菜单</a></li>
                            <li class="nav-item"><a class="nav-link" target="main" href="/admin/permission/list">权限</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" target="main" href="/admin/role/list">角色</a></li>
                            <li class="nav-item"><a class="nav-link" target="main"
                                                    href="/admin/administrator/list">管理员</a></li>
                        </ul>
                    </div>
                </li>
            @endif

            {{--<li class="nav-item sidebar-actions">--}}
            {{--<span class="nav-link">--}}
            {{--<div class="border-bottom">--}}
            {{--<h6 class="font-weight-normal mb-3">Projects</h6>                --}}
            {{--</div>--}}
            {{--<button class="btn btn-block btn-lg btn-gradient-primary mt-4">+ Add a project</button>--}}
            {{--<div class="mt-4">--}}
            {{--<div class="border-bottom">--}}
            {{--<p class="text-secondary">Categories</p>                  --}}
            {{--</div>--}}
            {{--<ul class="gradient-bullet-list mt-4">--}}
            {{--<li>Free</li>--}}
            {{--<li>Pro</li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--</span>--}}
            {{--</li>--}}
        </ul>
    </nav>


    <!-- main-panel ends -->
</div>


