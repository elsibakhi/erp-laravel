<?php

return [

    'default_role' => 'Employee',

    'roles' => [
        'landlord-api' => [
            'Super Admin',
        ],
        'tenant-api' => [
            'Admin',
            'HR Manager',
            'Accountant',
            'Department Manager',
            'Employee',
        ],
    ],

    'permissions' => [
        'landlord-api' => [
            'view tenants',
            'store tenants',
            'update tenants',
            'destroy tenants',
            'view roles',
            'store roles',
            'update roles',
            'destroy roles',
            'view permissions',
            'store permissions',
            'update permissions',
            'destroy permissions',
        ],
        'tenant-api' => [
            'view employees',
            'store employees',
            'update employees',
            'destroy employees',
            'view departments',
            'store departments',
            'update departments',
            'destroy departments',
            'view expenses',
            'store expenses',
            'update expenses',
            'destroy expenses',
            'view invoices',
            'store invoices',
            'update invoices',
            'destroy invoices',
            'change invoices status',
            'view all leave requests',
            'view employee leave requests',
            'store leave requests',
            'update leave requests',
            'destroy leave requests',
            'change leave requests status',
            'view projects',
            'store projects',
            'update projects',
            'destroy projects',
            'view tasks',
            'store tasks',
            'update tasks',
            'destroy tasks',
            'store users',
            'destroy users',
            'assign permissions to users',
            'assign roles to users',
        ],
    ],

    'roles-has-permissions' => [
        'landlord-api' => [
            'Super Admin' => [
                // landlord-api
                'view tenants', 'store tenants', 'update tenants', 'destroy tenants',
                'view roles', 'store roles', 'update roles', 'destroy roles',
                'view permissions', 'store permissions', 'update permissions', 'destroy permissions',

            ],
        ],
        'tenant-api' => [

            'Admin' => [

                'view employees', 'store employees', 'update employees', 'destroy employees',
                'view departments', 'store departments', 'update departments', 'destroy departments',
                'view expenses', 'store expenses', 'update expenses', 'destroy expenses',
                'view invoices', 'store invoices', 'update invoices', 'destroy invoices', 'change invoices status',
                'view all leave requests', 'change leave requests status',
                'view projects', 'store projects', 'update projects', 'destroy projects',
                'view tasks', 'store tasks', 'update tasks', 'destroy tasks',
                'store users', 'assign permissions to users', 'assign roles to users', 'destroy users',
            ],

            'HR Manager' => [
                'view employees', 'store employees', 'update employees', 'destroy employees',
                'view departments',
                'view all leave requests', 'change leave requests status',
            ],

            'Accountant' => [
                'view expenses', 'store expenses', 'update expenses', 'destroy expenses',
                'view invoices', 'store invoices', 'update invoices', 'destroy invoices', 'change invoices status',
            ],

            'Department Manager' => [
                'view employees',
                'view employee leave requests', 'change leave requests status',
                'view projects', 'store tasks', 'update tasks',
            ],

            'Employee' => [

                'store leave requests', 'view employee leave requests',
                'view projects', 'view tasks', 'update tasks',
            ],
        ],
    ],

];
