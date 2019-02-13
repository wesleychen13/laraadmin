<?php
$user = \Auth::guard('admin')->user();
$menus = $user->getMenus();
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold"> {{ $user->username }}</strong>
                            </span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="/admin/changePassword" class="J_menuItem">修改密码</a></li>
                        <li><a href="/admin/logout">安全退出</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            @if(isset($menus))
                @foreach($menus as $key => $val)
                    <li>
                        <a @if($val['path'] == '#') href="#" @else href="{{ U("{$val['path']}") }}" class="J_menuItem" @endif>
                            <i class="fa {{$val['ico']}}"></i>
                            <span class="nav-label">{{$val['name']}}</span> </a>
                        @if(isset($val['_child']))
                            <ul class="nav nav-second-level">
                                @foreach($val['_child'] as $key2 => $val2)
                                    <li>
                                        <a class="J_menuItem" href="@if($val2['path'] == '#') # @else {{ U("{$val2['path']}") }} @endif" data-index="0">{{$val2['name']}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endif
        </ul>

    </div>
</nav>
