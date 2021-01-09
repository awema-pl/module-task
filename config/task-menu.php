<?php

return [
    'merge_to_navigation' => true,

    'navs' => [
        'sidebar' =>[
            [
                'name' => 'Tasks',
                'link' => '/task/statuses',
                'icon' => 'speed',
                'key' => 'task::menus.tasks',
                'children_top' => [
                    [
                        'name' => 'Statuses',
                        'link' => '/task/statuses',
                        'key' => 'task::menus.statuses',
                    ],
                ],
                'children' => [
                    [
                        'name' => 'Statuses',
                        'link' => '/task/statuses',
                        'key' => 'task::menus.statuses',
                    ],
                ],
            ]
        ],
        'adminSidebar' =>[
            [
                'name' => 'Settings',
                'link' => '/admin/task/settings',
                'icon' => 'speed',
                'permissions' => 'manage_task_settings',
                'key' => 'task::menus.task',
                'children_top' => [
                    [
                        'name' => 'Settings',
                        'link' => '/admin/task/settings',
                        'key' => 'task::menus.settings',
                    ],
                ],
                'children' => [
                    [
                        'name' => 'Settings',
                        'link' => '/admin/task/settings',
                        'key' => 'task::menus.settings',
                    ],
                ],
            ]
        ]
    ]
];
