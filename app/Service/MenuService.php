<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;

class MenuService
{
    public static function getAuthorizedMenus()
    {
        $user = Auth::user();

        if (!$user) {
            return [];
        }

        $menus = [
            [
                'title' => 'Dashboard',
                'icon' => 'home',
                'route' => 'dashboard',
                'permissions' => ['dashboard-view'],
                'children' => []
            ],
            [
                'title' => 'Production Reports',
                'icon' => 'settings',
                'route' => null,
                'permissions' => ['production-view'],
                'children' => [
                    [
                        'title' => 'Report',
                        'icon' => 'play',
                        'route' => 'startups.index',
                        'permissions' => ['startup-list']
                    ],
                ]
            ],
            [
                'title' => 'Settings',
                'icon' => 'settings',
                'route' => null,
                'permissions' => ['production-view'],
                'children' => [
                    [
                        'title' => 'Shifts',
                        'icon' => 'clock',
                        'route' => 'shifts.index',
                        'permissions' => ['shift-list']
                    ],
                    [
                        'title' => 'Devices',
                        'icon' => 'device-desktop',
                        'route' => 'devices.index',
                        'permissions' => ['device-list']
                    ],
                    [
                        'title' => 'Product Message',
                        'icon' => 'package',
                        'route' => 'device-products.index',
                        'permissions' => ['device-list']
                    ],
                ]
            ],
            [
                'title' => 'User Management',
                'icon' => 'users',
                'route' => null,
                'permissions' => ['user-list', 'user-create', 'user-edit', 'user-delete', 'manage-users'],
                'children' => [
                    [
                        'title' => 'Users',
                        'icon' => 'user',
                        'route' => 'users.index',
                        'permissions' => ['user-list']
                    ],
                    [
                        'title' => 'Roles',
                        'icon' => 'shield',
                        'route' => 'roles.index',
                        'permissions' => ['role-list']
                    ],
                    [
                        'title' => 'Permissions',
                        'icon' => 'key',
                        'route' => 'permissions.index',
                        'permissions' => ['permission-list']
                    ]
                ]
            ],
        ];

        return self::filterMenusByPermissions($menus, $user);
    }

    private static function filterMenusByPermissions($menus, $user)
    {
        $filteredMenus = [];

        foreach ($menus as $menu) {
            // Check if user has any of the required permissions
            $hasPermission = false;

            if (empty($menu['permissions'])) {
                $hasPermission = true;
            } else {
                foreach ($menu['permissions'] as $permission) {
                    if ($user->can($permission)) {
                        $hasPermission = true;
                        break;
                    }
                }
            }

            if ($hasPermission) {
                // Filter children if they exist
                if (!empty($menu['children'])) {
                    $menu['children'] = self::filterMenusByPermissions($menu['children'], $user);
                    // Only show parent menu if it has visible children or a route
                    if (!empty($menu['children']) || $menu['route']) {
                        $filteredMenus[] = $menu;
                    }
                } else {
                    $filteredMenus[] = $menu;
                }
            }
        }

        return $filteredMenus;
    }
}
