<div class="sidebar-user">
    <div class="row">
        <div class="col-md-3 ms-4">
            <div class="profile-icon" style="height: 100%">
                {{-- <i class="iconly-boldShow bi bi-person-circle" style="margin-right: 12%;margin-bottom: 12%"></i> --}}
                <img src="{{ url(Storage::disk('local')->url(auth()->user()->path_image)) }}"
                    class="rounded mx-auto d-block" width="80px" height="80px" alt="Profil">
            </div>
        </div>
        <div class="col-md-7 ms-2">
            <div class="fw-bold-custom">Selamat Datang,</div>
            <div>
                <small>{{ ucwords(auth()->user()->name) }}</small>
            </div>
            <div class="">
                {{-- <small class="font-extrabold">{{ auth()->user()->access->nama_role }}</small> --}}
                <a href="{{ route('logout') }}" class="text-danger" title="Logout / Keluar">
                    <i class="bi bi-power"> </i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        {{-- @dd($role->menu) --}}
        @foreach ($role->menu as $menu)
            @if (count($menu->sub_menu))
                <li
                    class="sidebar-item has-sub {{ request()->is($menu->menu_detail?->active . '*') ? 'active' : '' }} ">
                    <a href="#" class='sidebar-link'>
                        <i class="{{ $menu->menu_detail->icon }}"></i>
                        <span> {{ ucwords($menu->menu_detail->menu) }}</span>
                    </a>

                    <ul class="submenu ">
                        @foreach ($menu->sub_menu as $sub_menu)
                            <li class="submenu-item ">
                                <a href="{{ route($sub_menu->sub_menu_detail?->url) }}">
                                    {{ ucwords($sub_menu->sub_menu_detail?->sub_menu) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @else
                @if ($menu->select == 'true')
                    {{-- @dd(route($menu->menu_detail?->url)) --}}
                    <li class="sidebar-item {{ request()->is($menu->menu_detail->active) ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class='sidebar-link'>
                            <i class="{!! $menu->menu_detail->icon !!}"></i>
                            <span>{{ $menu->menu_detail->menu }}</span>
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</div>
