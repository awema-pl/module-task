<?php
return [
    // this resources has been auto load to layout
    'dist' => [
        'js/main.js',
        'js/main.legacy.js',
        'css/main.css',
    ],
    'routes' => [

        // all routes is active
        'active' => true,

        // Administrator section.
        'admin' => [
            // section installations
            'installation' => [
                'active' => true,
                'prefix' => '/installation/task',
                'name_prefix' => 'task.admin.installation.',
                // this routes has beed except for installation module
                'expect' => [
                    'module-assets.assets',
                    'task.admin.installation.index',
                    'task.admin.installation.store',
                ]
            ],
            'setting' => [
                'active' => true,
                'prefix' => '/admin/task/settings',
                'name_prefix' => 'task.admin.setting.',
                'middleware' => [
                    'web',
                    'auth',
                    'can:manage_task_settings'
                ]
            ],
        ],

        // User section
        'user' => [
            'status' => [
                'active' => true,
                'prefix' => '/task/statuses',
                'name_prefix' => 'task.user.status.',
                'middleware' => [
                    'web',
                    'auth',
                    'verified'
                ]
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Use permissions in application.
    |--------------------------------------------------------------------------
    |
    | This permission has been insert to database with migrations
    | of module permission.
    |
    */
    'permissions' =>[
        'install_packages', 'manage_task_settings',
    ],

    /*
    |--------------------------------------------------------------------------
    | Can merge permissions to module permission
    |--------------------------------------------------------------------------
    */
    'merge_permissions' => true,

    'installation' => [
        'auto_redirect' => [
            // user with this permission has been automation redirect to
            // installation package
            'permission' => 'install_packages'
        ]
    ],

    'database' => [
        'tables' => [
            'users' => 'users',
            'task_settings' => 'task_settings',
            'task_statuses' =>'task_statuses',
        ]
    ],

];
