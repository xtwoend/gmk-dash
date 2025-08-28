@php
    use App\Service\MenuService;
    $menus = MenuService::getAuthorizedMenus();
@endphp

@foreach($menus as $menu)
    @if(empty($menu['children']))
        <!-- Single Menu Item -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs($menu['route']) ? 'active' : '' }}" 
               href="{{ $menu['route'] ? route($menu['route']) : '#' }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-{{ $menu['icon'] }}"></i>
                </span>
                <span class="nav-link-title">{{ $menu['title'] }}</span>
            </a>
        </li>
    @else
        <!-- Dropdown Menu -->
        <li class="nav-item dropdown {{ collect($menu['children'])->pluck('route')->contains(function($route) { return request()->routeIs($route); }) ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" 
               data-bs-auto-close="outside" role="button" aria-expanded="false">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <i class="ti ti-{{ $menu['icon'] }}"></i>
                </span>
                <span class="nav-link-title">{{ $menu['title'] }}</span>
            </a>
            <div class="dropdown-menu">
                <div class="dropdown-menu-columns">
                    <div class="dropdown-menu-column">
                        @foreach($menu['children'] as $child)
                            <a class="dropdown-item {{ request()->routeIs($child['route']) ? 'active' : '' }}" 
                               href="{{ $child['route'] ? route($child['route']) : '#' }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-{{ $child['icon'] }}"></i>
                                </span>
                                {{ $child['title'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </li>
    @endif
@endforeach
