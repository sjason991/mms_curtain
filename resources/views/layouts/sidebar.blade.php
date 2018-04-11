<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            @hasanyrole('管理员')
            <li>
                <a href="{{url('order/create')}}"><i class="fa  fa-mail-forward fa-fw"></i> 新建订单 <i class="fa fa-mail-reply fa-fw"></i></a>
            </li>
            @else
            @endhasanyrole
            <li>
                <a href="#"><i class="fa  fa-file-text fa-fw"></i> 订单管理<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @hasanyrole('管理员|用户')
                    <li>
                        <a href="{{url('order')}}">订单一览</a>
                    </li>
                    @else
                    @endhasrole
                    @role('管理员')
                    <li>
                        <a href="#">已完结订单</a>
                    </li>
                    <li>
                        <a href="#">已删除订单</a>
                    </li>
                    @else
                    @endrole
                </ul>
                <!-- /.nav-second-level -->
            </li>
            @hasanyrole('管理员')
            <li>
                <a href="#"><i class="fa fa-user fa-fw"></i> 客户管理</a>
            </li>
            @else
            @endhasanyrole
            @hasanyrole('管理员')
            <li>
                <a href="#"><i class="fa fa-th-large fa-fw"></i> 系统管理<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{url('system/goodscate')}}">商品类型</a>
                    </li>
                    <li>
                        <a href="{{url('system/goodsmodel')}}">商品型号</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            @else
            @endhasanyrole
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>