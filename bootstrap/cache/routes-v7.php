<?php

/*
|--------------------------------------------------------------------------
| Load The Cached Routes
|--------------------------------------------------------------------------
|
| Here we will decode and unserialize the RouteCollection instance that
| holds all of the route information for an application. This allows
| us to instantaneously load the entire route map into the router.
|
*/

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/health-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.healthCheck',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/execute-solution' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.executeSolution',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/update-config' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.updateConfig',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AWbex1iaj0rAWch8',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/get-recording-count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2tD6RfNWWXYVEi68',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/sync-recording' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9XoDP0mTa3QxMFfV',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::S8NWOGIrneKMlXTP',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/redirect' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::psGYPZhiAsOQgtjd',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/crmlogin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'crmlogin',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/crm-tasks' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.crm.tasks',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/project-updates' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/project-updates/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'profile.edit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'profile.update',
          ),
          1 => NULL,
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'profile.destroy',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/check-password-change-required' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.check.required',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/change-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.change',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/logs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logs.api',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/logs/read-all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logs.read-all',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/logs/activity' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logs.activity',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/logs/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logs.stats',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/logs/realtime' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logs.realtime',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::H5R1Ynrismu3fpKb',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login.post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reset-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/profile-splash' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'profile.splash',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/verify-email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.notice',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/verification-notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/confirm-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.confirm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kmj379OgFWwAN7xn',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/profile/edit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.profile.edit',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/profile/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.profile.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/change/password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.change.password',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/update/change/password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'update.change.password',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoices' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoices/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eiF0i7QYZH0kfxFo',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-pdf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Y3ekWPqCH4P8rmH2',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-email-attachment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rZMwIwmgLq2G2g9u',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employees' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employees.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'employees.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employees/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employees.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employees/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employees.verify',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employees/verify-otp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employees.verify-otp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employees/resend-otp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employees.resend-otp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customers' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customers.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'customers.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customers/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customers.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customers/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customers.verify',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customers/verify-otp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customers.verify-otp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customers/resend-otp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customers.resend-otp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee-report' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee-report.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee-report/generate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee-report.generate',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'POST' => 1,
            'HEAD' => 2,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee-report/email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee-report.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee-report/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee-report.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/approval-status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/approval-status/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gTusRj848vkQ4oFT',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'categories.redirect',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.category',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'category.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/sub/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.subcategory',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/sub/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'subcategory.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'subcategory.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/sub/sub/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.subsubcategory',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/sub/sub/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'subsubcategory.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/category/sub/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'subsubcategory.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reminder/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.reminder',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reminder/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reminder.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reminder/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'add-reminder',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/generate-id' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0UjwP9mqywR02ORv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.customer',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'add-customer',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Employee/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.Employee',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Employee/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Employee.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/Employee/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'add-Employee',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sales/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.sales',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sales/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sales/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'add-sales',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ITEmployee/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.ITEmployee',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ITEmployee/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ITEmployee.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ITEmployee/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'add-ITEmployee',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/brand/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.brand',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/brand/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'brand.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/brand/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'brand.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/system_type/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.system_type',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/system_type/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'system_type.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/system_type/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'system_type.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/service_category/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.service_category',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/service_category/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service_category.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/service_category/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service_category.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/operating_system/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.operating_system',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/operating_system/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'operating_system.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/operating_system/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'operating_system.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/Department/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.Department',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/Department/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Department.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/Department/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Department.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/Action/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.Action',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/Action/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Action.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/Action/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Action.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/ticket_status/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.Ticket_status',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/ticket_status/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Ticket_status.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/ticket_status/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Ticket_status.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/Group/view' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'all.Group',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/Group/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Group.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/control/Group/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Group.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sales-department' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales.department',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/sales-department/invoice-statuses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.sales-department.invoice-statuses',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/accounts/invoice-statuses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'api.accounts.invoice-statuses',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/invoices/api/statuses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.api.statuses',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/refresh-csrf' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VXV9IZKrAQny1g56',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/useraddticket' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'add-productuser',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/projects/get-by-system-type' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'projects.get_by_system_type',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/add' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'add-product',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/showForm' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'showForm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product-store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/userdatastore' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product-storeuser',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/manage' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'manage-product',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/Mymanage' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'my-manage-product',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/data/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/userassignupdate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'userassignupdate',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/image/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'update-product-image',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/thambnail/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'update-product-thambnail',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/timer/ajax' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::19KcCOZ4dLDmH309',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/product/data/updateemp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.updateemp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/export-user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'export-user',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/import-user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'import.user',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'leads.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement/create-new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.create.new',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement/store-new' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.store.new',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement/upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.upload',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'leads.upload.excel',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement/direct-upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.direct.upload',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement/process-excel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.process.excel',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement/save-direct-upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.save.direct.upload',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement/template' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.template',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leadsmanagement/leads/send-email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.send.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/duedate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'duedate.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/duedate/send-bulk-reminders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'duedate.send.bulk.reminders',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/google-sheets' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/google-sheets/test-connection' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets.test-connection',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/google-sheets/preview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets.preview',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/google-sheets/import' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets.import',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/google-sheets/sync' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets.sync',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/google-sheets/configuration' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets.configuration',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets.configuration.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/google-sheets/statistics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets.statistics',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/googlesheet' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets-management.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/googlesheet/sync' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets-management.sync',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/googlesheet/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google-sheets.export',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/googlesheets/test-connection' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::RF27jp7wF2ekp4t6',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/googlesheets/new-entries' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EtSxRKqlCSz5OwG5',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/googlesheets/column-data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3NNcBWsoIJqLSVLj',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/googlesheets/sync' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CBHYcfx7IXMrSzkU',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/googlesheets/export' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::BKwRSmeni05weoH1',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapplogin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.login.post',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapplogout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/sync' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.sync',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingappleads' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.add-leads',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.store-lead',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/employees' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.employees',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/employees-debug' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.employees-debug',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingappleads/debug' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.debug-manual-leads',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/manual-leads' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.manual-leads',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/add-employee' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.add-employee',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/save-call-details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.save-call-details',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/test-connection' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.test-connection',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/mywhatsapp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'whatsapp.main',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/whatsapp' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'whatsapp.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/whatsapp/send' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'whatsapp.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/whatsapp/bulk-send' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'whatsapp.bulk.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/whatsapp/templates' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'whatsapp.templates',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/whatsapp/status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'whatsapp.status',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/callhistory' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.callhistory',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callhistory' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callhistory.direct',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/call-details-by-lead' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.get-call-details-by-lead',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/callingapp/today-followup-count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.today-followup-count',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/automated-sync/auto-sync' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'automated-sync.auto-sync',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/automated-sync/check-notifications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'automated-sync.check-notifications',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/automated-sync/status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'automated-sync.status',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/followup' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'followup.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/followup/entries' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'followup.entries',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/external-sync' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'external-sync.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/external-sync/sync' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'external-sync.sync',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/external-sync/generate-sql' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'external-sync.generate-sql',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/external-sync/status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'external-sync.status',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/external-sync/create-trigger' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'external-sync.create-trigger',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/external-sync/test-connection' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'external-sync.test-connection',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/staprio/statuses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'staprio.statuses',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/staprio/priorities' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'staprio.priorities',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/staprio' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'staprio.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reactions-system' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reactions-system.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'reactions-system.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reactions-system/send/test' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reactions.send.test',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reactions-system/send/pending' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reactions.send.pending',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/lead-notifications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'lead-notifications.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/lead-notifications/count' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'lead-notifications.count',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/lead-notifications/read-all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'lead-notifications.read-all',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/lead-notifications/upcoming' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'lead-notifications.upcoming',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/services' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'services.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/services/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-route' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::v569Fsoh4yhRhDyJ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/accounts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/accounts/store-session-data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.store-session-data',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/quotations/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xx5oyfVAswZdm6tB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/home' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/mycusdashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.mycusdashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/customer/companies' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.companies.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/menu-controller' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu-controller.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'menu-controller.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/menu-controller/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu-controller.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/menu-controller/api/permissions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu-controller.api.permissions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'menu-controller.api.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee-menu-controller' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee-menu-controller.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee-menu-controller/api/employees' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee-menu-controller.api.employees',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee-menu-controller/api/permissions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee-menu-controller.api.permissions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'employee-menu-controller.api.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/activity-logs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'activity-logs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/activity-logs/api/logs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'activity-logs.api',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/activity-logs/api/logs/read-all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'activity-logs.read-all',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/debug-user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Mbk8PZLu0MEWmiTT',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dashboard-xray' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'xray.viewer',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/dashboard-xray/upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'xray.upload',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page-customization' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page-customization/users-for-role' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.users-for-role',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page-customization/analyze' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.analyze',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page-customization/get-customizations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.get-customizations',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page-customization/apply-customizations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.apply-customizations',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page-customization/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page-customization/update-single' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.update-single',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/page-customization/batch-update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.batch-update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/current-user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EehPhNhNEWPDoSSB',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/menu-controller-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TJ5JnLAJ53ErymUe',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/page-customizations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pQUvjHFeQJjYTnPE',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-post' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fBrhH4wNlUQnweAp',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/role-element-visibility/roles' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role-element-visibility.roles',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/role-element-visibility/get' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role-element-visibility.get',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/role-element-visibility/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role-element-visibility.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/role-element-visibility/bulk-update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role-element-visibility.bulk-update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/role-element-visibility/apply' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'role-element-visibility.apply',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/ai-helper' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ai-helper.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/report' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.report',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/check-in' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.check-in',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/check-out' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.check-out',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/mark' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.mark',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.data',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/check-status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.check-status',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/send-email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.send.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/attendance/clear-popup-session' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VMyJK7EXbrc7UwlU',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shifts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shifts.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'shifts.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/shifts/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shifts.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/users/toggle-status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'users.toggle-status',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/users/with-shifts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'users.with-shifts',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/users/bulk-assign-shift' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'users.bulk-assign-shift',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/users/get-users-by-department' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'users.get-users-by-department',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-leave' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uZc1Vh5ji4FGRkLu',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-controller' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::zpZyGaC99tHXemXt',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-calendar-no-auth' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fWrlMh2EO6gNHoXO',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leave' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leave.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'leave.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leave/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leave.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leave/calendar-leaves' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leave.calendar-leaves',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leave/calendar-leaves-data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leave.calendar-leaves-data',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/leave/leave-bucket' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leave.leave-bucket',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/off-time-login-notify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'off-time-login.notify',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/clear-off-time-modal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'off-time-login.clear',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/niremplogin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dRwYxyFUbyNrcg2p',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.register.show',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'employee.register',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/niremptask' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee/tasks/filter' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.tasks.filter',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee/task/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.task.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee/send-daily-tasks-email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.send.daily.tasks.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/test-mail' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::sIV8zD6iSj8SK6lV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee/sync-to-google-sheets' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.sync.google.sheets',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/employee/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/biometric/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'biometric.register',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/biometric/authenticate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'biometric.authenticate',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/biometric/challenge' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'biometric.challenge',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/biometric/delete' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'biometric.delete',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/tasks/filter' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tasks.filter',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/allrecordingcall' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'recordings.all',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/p(?|ro(?|ject\\-updates/(?|([^/]++)/completion\\-status(?|(*:64))|completion\\-status/([^/]++)(*:99)|([^/]++)(?|/update\\-progress(*:134)|(*:142))|update\\-status(*:165)|([^/]++)(*:181))|duct/(?|edit(?|/([^/]++)(*:214)|emp/([^/]++)(*:234))|multiimg/delete/([^/]++)(*:267)|inactive/([^/]++)(*:292)|active/([^/]++)(*:315)|delete/([^/]++)(*:338)|Ticket/ajax/([^/]++)(*:366)|preview_product/([^/]++)(*:398)))|ublic/attachments/([^/]++)(*:434)|a(?|yment\\-plan/([^/]++)(*:466)|ge\\-customization/(?|([^/]++)(*:503)|reset(*:516))))|/a(?|dmin/(?|crm\\-tasks/([^/]++)/details(*:567)|task/([^/]++)/(?|edit(*:596)|update(*:610)|delete(*:624)))|tt(?|achments/([^/]++)(?|(*:659)|/view(*:672))|endance/(?|show/([^/]++)(*:705)|edit/([^/]++)(*:726)))|p(?|i/logs/([^/]++)/read(*:760)|proval\\-status/(?|([^/]++)(?|(*:797)|/(?|approve(*:816)|reject(*:830)))|statistics(*:850)|leave(?|(*:866)|/([^/]++)(?|(*:886)|/(?|approve(*:905)|reject(*:919))))))|c(?|counts/(?|confirm\\-payment\\-plan/([^/]++)(*:977)|([^/]++)/(?|update\\-payment(*:1012)|toggle\\-customer\\-panel(*:1044))|lead/([^/]++)/toggle\\-customer\\-panel(*:1091)|move\\-(?|lead\\-to\\-quotation/([^/]++)(*:1137)|quotation\\-to\\-lead/([^/]++)/([^/]++)(*:1183))|generate\\-invoice/([^/]++)(*:1219)|create\\-invoice/([^/]++)(*:1252)|simple\\-save\\-invoice/([^/]++)(*:1291)|edit\\-quotation/([^/]++)(*:1324))|tivity\\-logs/api/logs/([^/]++)(?|/read(*:1372)|(*:1381))))|/re(?|set\\-password/([^/]++)(*:1421)|minder/(?|edit/([^/]++)(*:1453)|update/([^/]++)(*:1477)|delete/([^/]++)(*:1501))|actions\\-system/(?|([^/]++)(?|(*:1541)|/status(*:1557)|(*:1566))|status(*:1582)))|/verify\\-email/([^/]++)/([^/]++)(*:1625)|/invoice(?|s/(?|([^/]++)(?|(*:1661)|/(?|e(?|dit(*:1681)|xport/(?|pdf(*:1702)|word(*:1715)))|view(*:1730)|print(*:1744)|send\\-reminder(*:1767))|(*:1777))|management/([^/]++)(*:1806)|c(?|reate\\-installment/([^/]++)/([^/]++)(*:1855)|heck\\-approval\\-status/([^/]++)(*:1895))|s(?|ave\\-installment/([^/]++)/([^/]++)(*:1943)|end\\-approval\\-email(*:1972)|how/([^/]++)(*:1993))|test\\-email(*:2014)|delete/([^/]++)(*:2038))|/(?|approve/([^/]++)(*:2068)|reject/([^/]++)(*:2092)))|/s(?|imple\\-p(?|df\\-download/([^/]++)(*:2140)|rint/([^/]++)(*:2162))|ales(?|/(?|edit/([^/]++)(*:2196)|update/([^/]++)(*:2220)|delete/([^/]++)(*:2244))|\\-department/([^/]++)/(?|create\\-invoice(*:2294)|s(?|ave\\-invoice(*:2319)|end\\-approval\\-email(*:2348))|toggle\\-customer\\-panel(*:2381)))|taprio/([^/]++)(?|(*:2410))|ervices/([^/]++)(?|/edit(*:2444)|(*:2453))|hifts/(?|([^/]++)(?|/edit(*:2488)|(*:2497))|assign(*:2513)))|/e(?|mployee(?|s/([^/]++)(?|/edit(*:2557)|(*:2566))|/task/([^/]++)/(?|edit(*:2598)|update(*:2613)|delete(*:2628)))|xcalate/assign/([^/]++)(*:2662))|/c(?|ustomer(?|s/([^/]++)(?|/edit(*:2705)|(*:2714))|/(?|edit/([^/]++)(*:2741)|update/([^/]++)(*:2765)|delete/([^/]++)(*:2789)|companies/([^/]++)(?|(*:2819)|/(?|invoices(*:2840)|projects(*:2857)))|quotations/([^/]++)/pdf(*:2891)))|a(?|tegory/(?|edit/([^/]++)(*:2929)|update/([^/]++)(*:2953)|delete/([^/]++)(*:2977)|s(?|ub(?|/(?|edit/([^/]++)(*:3012)|delete/([^/]++)(*:3036)|sub/(?|edit/([^/]++)(*:3065)|delete/([^/]++)(*:3089)))|category/ajax/([^/]++)(*:3122)|\\-subcategory/ajax/([^/]++)(*:3158))|ervice_category/ajax/([^/]++)(*:3197)))|llingapp/(?|lead\\-d(?|etails/([^/]++)(*:3245)|ata/([^/]++)(*:3266))|call\\-details/([^/]++)(*:3298)|meeting\\-call\\-detail/([^/]++)(?|(*:3340))))|ontrol/(?|brand/(?|edit/([^/]++)(*:3384)|delete/([^/]++)(*:3408))|s(?|ystem_type/(?|edit/([^/]++)(*:3449)|delete/([^/]++)(*:3473))|ervice_category/(?|edit/([^/]++)(*:3515)|delete/([^/]++)(*:3539)))|operating_system/(?|edit/([^/]++)(*:3583)|delete/([^/]++)(*:3607))|Department/(?|edit/([^/]++)(*:3644)|delete/([^/]++)(*:3668))|Action/(?|edit/([^/]++)(*:3701)|delete/([^/]++)(*:3725))|ticket_status/(?|edit/([^/]++)(*:3765)|delete/([^/]++)(*:3789))|Group/(?|edit/([^/]++)(*:3821)|delete/([^/]++)(*:3845))))|/Employee/(?|edit/([^/]++)(*:3883)|update/([^/]++)(*:3907)|delete/([^/]++)(*:3931))|/ITEmployee/(?|edit/([^/]++)(*:3969)|update/([^/]++)(*:3993)|delete/([^/]++)(*:4017))|/lea(?|d(?|smanagement/(?|([^/]++)(?|/(?|edit(?|\\-new(*:4080)|(*:4089))|update\\-(?|new(*:4113)|field(*:4127)))|(*:4138))|send\\-email(*:4159)|test\\-email(*:4179)|([^/]++)/reaction(?|(*:4208))|users\\-by\\-department/([^/]++)(*:4248))|\\-notifications/([^/]++)/read(*:4287))|ve/([^/]++)(?|(*:4311)|/(?|approve(*:4331)|reject(*:4346)|cancel(*:4361))))|/d(?|uedate/send\\-reminder/([^/]++)(*:4408)|ashboard\\-xray/(?|view/([^/]++)(*:4448)|download/([^/]++)(*:4474)))|/whatsapp/history/([^/]++)(*:4511)|/test\\-task\\-status\\-email/([^/]++)(*:4555)|/quotations/(?|([^/]++)(?|(*:4590)|/(?|e(?|dit(*:4610)|mail\\-history(*:4632))|send(*:4646)|pdf(*:4658))|(*:4668))|approve/([^/]++)(*:4694)|reject/([^/]++)(*:4718))|/menu\\-controller/([^/]++)(?|/edit(*:4762)|(*:4771)))/?$}sDu',
    ),
    3 => 
    array (
      64 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.completion-status.create',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.completion-status.store',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      99 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.completion-status.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      134 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.progress.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      142 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      165 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.update-status',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      181 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'project-updates.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      214 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      234 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.editemp',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      267 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.multiimg.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      292 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.inactive',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      315 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.active',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      338 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      366 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1vUkRkIsbjrKztkU',
          ),
          1 => 
          array (
            0 => 'Department_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      398 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'product.preview',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      434 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attachments.public.download',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      466 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payment.plan',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      503 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      516 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page-customization.reset',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      567 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.crm.tasks.details',
          ),
          1 => 
          array (
            0 => 'taskId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      596 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.task.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      610 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.task.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      624 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.task.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      659 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attachments.download',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      672 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attachments.view',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      705 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.show',
          ),
          1 => 
          array (
            0 => 'attendance',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      726 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'attendance.edit',
          ),
          1 => 
          array (
            0 => 'attendance',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      760 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logs.read',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      797 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      816 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.approve',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      830 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.reject',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      850 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.statistics',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      866 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.leave.index',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      886 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.leave.show',
          ),
          1 => 
          array (
            0 => 'leave',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      905 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.leave.approve',
          ),
          1 => 
          array (
            0 => 'leave',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      919 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'approval-status.leave.reject',
          ),
          1 => 
          array (
            0 => 'leave',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      977 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.confirm-payment-plan',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1012 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.update-payment',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1044 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.toggle-customer-panel',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1091 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.lead.toggle-customer-panel',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1137 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.move-lead-to-quotation',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1183 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.move-quotation-to-lead',
          ),
          1 => 
          array (
            0 => 'quotation',
            1 => 'lead',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1219 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.generate-invoice',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1252 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.create-invoice',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1291 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.simple-save-invoice',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1324 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'accounts.edit-quotation',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1372 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'activity-logs.read',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1381 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'activity-logs.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1421 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1453 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reminder.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1477 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reminder.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1501 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reminder.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1541 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reactions-system.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1557 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reactions-system.updateStatus',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1566 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reactions-system.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1582 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'reactions.system.status',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1625 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.verify',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1661 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.show',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1681 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.edit',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1702 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.export.pdf',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1715 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.export.word',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1730 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.view',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1744 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.print',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1767 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.send.reminder',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1777 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.update',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.destroy',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1806 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.management',
          ),
          1 => 
          array (
            0 => 'quotationId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1855 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.create-installment',
          ),
          1 => 
          array (
            0 => 'quotation',
            1 => 'installmentLetter',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1895 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.check-approval-status',
          ),
          1 => 
          array (
            0 => 'invoiceId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1943 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.save-installment',
          ),
          1 => 
          array (
            0 => 'quotation',
            1 => 'installmentLetter',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1972 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.send-approval-email',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1993 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.management-show',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2014 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.test-email',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2038 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.delete',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2068 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoice.approve',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2092 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoice.reject',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2140 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.simple.pdf',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2162 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'invoices.simple.print',
          ),
          1 => 
          array (
            0 => 'invoice',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2196 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2220 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2244 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2294 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales.department.create-invoice',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2319 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales.department.save-invoice',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2348 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales.department.send-approval-email.backup',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2381 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sales.department.toggle-customer-panel',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2410 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'staprio.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'staprio.destroy',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2444 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.edit',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2453 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'services.update',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'services.destroy',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2488 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shifts.edit',
          ),
          1 => 
          array (
            0 => 'shift',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2497 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shifts.update',
          ),
          1 => 
          array (
            0 => 'shift',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'shifts.destroy',
          ),
          1 => 
          array (
            0 => 'shift',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2513 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'shifts.assign',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2557 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employees.edit',
          ),
          1 => 
          array (
            0 => 'employee',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2566 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employees.update',
          ),
          1 => 
          array (
            0 => 'employee',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'employees.destroy',
          ),
          1 => 
          array (
            0 => 'employee',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2598 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.task.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2613 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.task.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2628 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'employee.task.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2662 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'excalate.assign',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2705 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customers.edit',
          ),
          1 => 
          array (
            0 => 'customer',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2714 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customers.update',
          ),
          1 => 
          array (
            0 => 'customer',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'customers.destroy',
          ),
          1 => 
          array (
            0 => 'customer',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2741 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2765 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2789 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2819 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.companies.show',
          ),
          1 => 
          array (
            0 => 'companyName',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2840 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.companies.invoices',
          ),
          1 => 
          array (
            0 => 'companyName',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2857 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.companies.projects',
          ),
          1 => 
          array (
            0 => 'companyName',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2891 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'customer.quotations.pdf',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2929 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'category.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2953 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'category.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2977 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'category.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3012 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'subcategory.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3036 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'subcategory.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3065 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'subsubcategory.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3089 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'subsubcategory.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3122 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::oPXSts9xjAxTz0cK',
          ),
          1 => 
          array (
            0 => 'category_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3158 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ltAROSnBfetUgV4z',
          ),
          1 => 
          array (
            0 => 'subcategory_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3197 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nALCSCV1WKgyy7y2',
          ),
          1 => 
          array (
            0 => 'service_category_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3245 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.lead-details',
          ),
          1 => 
          array (
            0 => 'index',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3266 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.lead-data',
          ),
          1 => 
          array (
            0 => 'index',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3298 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.get-call-details',
          ),
          1 => 
          array (
            0 => 'email',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3340 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.get-meeting-call-detail',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'callingapp.update-meeting-call-detail',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3384 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'brand.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3408 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'brand.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3449 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'system_type.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3473 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'system_type.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3515 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service_category.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3539 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'service_category.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3583 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'operating_system.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3607 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'operating_system.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3644 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Department.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3668 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Department.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3701 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Action.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3725 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Action.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3765 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Ticket_status.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3789 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Ticket_status.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3821 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Group.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3845 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Group.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3883 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Employee.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3907 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Employee.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3931 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'Employee.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3969 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ITEmployee.edit',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      3993 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ITEmployee.update',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4017 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ITEmployee.delete',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4080 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.edit.new',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4089 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.edit',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4113 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.update.new',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4127 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.update.field',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'PATCH' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4138 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.show',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'leads.update',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'leads.destroy',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4159 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'send.email',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4179 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'test.email',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4208 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.reaction',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'leads.reaction.store',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4248 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leads.users.by.department',
          ),
          1 => 
          array (
            0 => 'department',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4287 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'lead-notifications.read',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4311 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leave.show',
          ),
          1 => 
          array (
            0 => 'leave',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4331 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leave.approve',
          ),
          1 => 
          array (
            0 => 'leave',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4346 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leave.reject',
          ),
          1 => 
          array (
            0 => 'leave',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4361 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'leave.cancel',
          ),
          1 => 
          array (
            0 => 'leave',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4408 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'duedate.send.reminder',
          ),
          1 => 
          array (
            0 => 'lead',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4448 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'xray.view',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4474 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'xray.download',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4511 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'whatsapp.history',
          ),
          1 => 
          array (
            0 => 'leadId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4555 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xoMCRE2RUu5kDXKy',
          ),
          1 => 
          array (
            0 => 'invoiceId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4590 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.show',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4610 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.edit',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4632 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.email-history',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4646 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.send',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4658 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.pdf',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4668 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.update',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.destroy',
          ),
          1 => 
          array (
            0 => 'quotation',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4694 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.approve',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4718 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'quotations.reject',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      4762 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu-controller.edit',
          ),
          1 => 
          array (
            0 => 'menu',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      4771 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'menu-controller.update',
          ),
          1 => 
          array (
            0 => 'menu',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'menu-controller.destroy',
          ),
          1 => 
          array (
            0 => 'menu',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.healthCheck' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/health-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController',
        'as' => 'ignition.healthCheck',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.executeSolution' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/execute-solution',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController',
        'as' => 'ignition.executeSolution',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.updateConfig' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/update-config',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController',
        'as' => 'ignition.updateConfig',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AWbex1iaj0rAWch8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:295:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:77:"function (\\Illuminate\\Http\\Request $request) {
    return $request->user();
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000057d0000000000000000";}";s:4:"hash";s:44:"46oxMnGj3Ns0uUZxDhjSA7Ytb56fkWf7Iv9CQ0tDU2w=";}}',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::AWbex1iaj0rAWch8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2tD6RfNWWXYVEi68' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/get-recording-count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:899:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:680:"function (\\Illuminate\\Http\\Request $request) {
    $totalRows = \\Illuminate\\Support\\Facades\\DB::table(\'call_recordings\')->count();
    
    // Safety check: Get latest row or null
    $latest = \\Illuminate\\Support\\Facades\\DB::table(\'call_recordings\')->orderBy(\'id\', \'desc\')->first();

    return \\response()->json([
        \'count\' => (int)$totalRows,
        \'status\' => \'success\',
        // Fixed: Added null checks to prevent 500 errors if table is empty
        \'last_employee\' => $latest ? $latest->employee_name : \'Team\',
        \'latest_name\'   => $latest ? $latest->customer_name : \'New Entry\',
        \'latest_phone\'  => $latest ? $latest->customer_phone : \'\',
    ]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000057c0000000000000000";}";s:4:"hash";s:44:"9RWbftK5c2YRKHTworyjYZC5uWoj82cTPdEnVk51WQI=";}}',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::2tD6RfNWWXYVEi68',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9XoDP0mTa3QxMFfV' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/sync-recording',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\RecordingController@sync',
        'controller' => 'App\\Http\\Controllers\\RecordingController@sync',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::9XoDP0mTa3QxMFfV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::S8NWOGIrneKMlXTP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:269:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:51:"function() {
    return \\redirect(\'/crmlogin\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000005820000000000000000";}";s:4:"hash";s:44:"VkxFd+O16liXDQeDL+I/5p3Cs9/uEWb3Qh5NrFEksd0=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::S8NWOGIrneKMlXTP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::psGYPZhiAsOQgtjd' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'redirect',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => '\\App\\Http\\Controllers\\Frontend\\HomeController@index',
        'controller' => '\\App\\Http\\Controllers\\Frontend\\HomeController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::psGYPZhiAsOQgtjd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.completion-status.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'project-updates/{id}/completion-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@createCompletionStatus',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@createCompletionStatus',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.completion-status.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.completion-status.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'project-updates/{id}/completion-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@storeCompletionStatus',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@storeCompletionStatus',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.completion-status.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.completion-status.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'project-updates/completion-status/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@updateCompletionStatus',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@updateCompletionStatus',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.completion-status.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.progress.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'project-updates/{id}/update-progress',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@updateProgress',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@updateProgress',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.progress.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'crmlogin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'crmlogin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:480:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:261:"function() {
    // Check if we need to clear the splash screen flag
    if (\\session(\'clear_splash\')) {
        // Flash the clear_splash flag to the view
        return \\view(\'crmlogin\')->with(\'clearSplash\', true);
    }
    return \\view(\'crmlogin\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000005890000000000000000";}";s:4:"hash";s:44:"0HJ58GZObN9kYG/fr9BtnoX7PLxy8dICQxn5RgBqefo=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'crmlogin',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminController@dashboard',
        'controller' => 'App\\Http\\Controllers\\AdminController@dashboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.crm.tasks' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/crm-tasks',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@adminCrmTasks',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@adminCrmTasks',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.crm.tasks',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.crm.tasks.details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/crm-tasks/{taskId}/details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@getTaskDetails',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@getTaskDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.crm.tasks.details',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attachments.public.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'public/attachments/{filename}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:426:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:207:"function($filename) {
    $path = \\storage_path(\'app/public/attachments/\' . $filename);
    
    if (!\\file_exists($path)) {
        \\abort(404);
    }
    
    return \\response()->download($path);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000058b0000000000000000";}";s:4:"hash";s:44:"Tih8orLTSJEqZiYZVf99xK13Gg7Y88ZoYkOE7mZqcaQ=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attachments.public.download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'project-updates',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@index',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'project-updates/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@projectDashboard',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@projectDashboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'project-updates/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@show',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'project-updates',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@store',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.update-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'project-updates/update-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@updateTaskStatus',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@updateTaskStatus',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.update-status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'project-updates.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'project-updates/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@destroy',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'project-updates.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'profile.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\ProfileController@edit',
        'controller' => 'App\\Http\\Controllers\\ProfileController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'profile.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'profile.update' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\ProfileController@update',
        'controller' => 'App\\Http\\Controllers\\ProfileController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'profile.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'profile.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\ProfileController@destroy',
        'controller' => 'App\\Http\\Controllers\\ProfileController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'profile.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.check.required' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'check-password-change-required',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerPasswordChangeController@checkPasswordChangeRequired',
        'controller' => 'App\\Http\\Controllers\\CustomerPasswordChangeController@checkPasswordChangeRequired',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.check.required',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.change' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'change-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerPasswordChangeController@changePassword',
        'controller' => 'App\\Http\\Controllers\\CustomerPasswordChangeController@changePassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.change',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attachments.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attachments/{filename}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:458:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:239:"function($filename) {
        $path = \\storage_path(\'app/public/attachments/\' . $filename);
        
        if (!\\file_exists($path)) {
            \\abort(404);
        }
        
        return \\response()->download($path);
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000059e0000000000000000";}";s:4:"hash";s:44:"PuUGEXixJkhyA14fgO78O/VvOzJzTEvVuwKGbwFLv9w=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attachments.download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attachments.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attachments/{filename}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:528:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:309:"function($filename) {
        $path = \\storage_path(\'app/public/attachments/\' . $filename);
        
        if (!\\file_exists($path)) {
            \\abort(404);
        }
        
        return \\response()->file($path, [\'Content-Disposition\' => \'inline; filename="\' . \\basename($path) . \'"\']);
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000005a00000000000000000";}";s:4:"hash";s:44:"dU1ZEOyDf52T9wmGTyzVVxTY0MaX39OsChRncq6hkjY=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'attachments.view',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logs.api' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@getLogs',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@getLogs',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logs.api',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logs.read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/logs/{id}/read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@markAsRead',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@markAsRead',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logs.read',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logs.read-all' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/logs/read-all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@markAllAsRead',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@markAllAsRead',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logs.read-all',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logs.activity' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/logs/activity',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@logActivity',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@logActivity',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logs.activity',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logs.stats' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/logs/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@getStats',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@getStats',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logs.stats',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logs.realtime' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/logs/realtime',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'require.password.change',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@getRealTimeActivities',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@getRealTimeActivities',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logs.realtime',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@create',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::H5R1Ynrismu3fpKb' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\RegisteredUserController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::H5R1Ynrismu3fpKb',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:259:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:41:"function() {
    return \\redirect(\'/\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000005ab0000000000000000";}";s:4:"hash";s:44:"THL+nPJS0AAIUyygLGGt3Phmf/tDxc0z0LV5q8Pswhk=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login.post',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\PasswordResetLinkController@create',
        'controller' => 'App\\Http\\Controllers\\Auth\\PasswordResetLinkController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\PasswordResetLinkController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\PasswordResetLinkController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reset-password/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\NewPasswordController@create',
        'controller' => 'App\\Http\\Controllers\\Auth\\NewPasswordController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\NewPasswordController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\NewPasswordController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'profile.splash' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'profile-splash',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:281:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:63:"function() {
        return \\view(\'auth.profile-splash\');
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000005b20000000000000000";}";s:4:"hash";s:44:"Zbts1PlXHZpEHhADlJYvkrg/GgQf0pnlVWjTuZaLyjo=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'profile.splash',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.notice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'verify-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\EmailVerificationPromptController@__invoke',
        'controller' => 'App\\Http\\Controllers\\Auth\\EmailVerificationPromptController@__invoke',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.notice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'verify-email/{id}/{hash}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'signed',
          3 => 'throttle:6,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\VerifyEmailController@__invoke',
        'controller' => 'App\\Http\\Controllers\\Auth\\VerifyEmailController@__invoke',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'email/verification-notification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'throttle:6,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\EmailVerificationNotificationController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\EmailVerificationNotificationController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.send',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'confirm-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ConfirmablePasswordController@show',
        'controller' => 'App\\Http\\Controllers\\Auth\\ConfirmablePasswordController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kmj379OgFWwAN7xn' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'confirm-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\ConfirmablePasswordController@store',
        'controller' => 'App\\Http\\Controllers\\Auth\\ConfirmablePasswordController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::kmj379OgFWwAN7xn',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\PasswordController@update',
        'controller' => 'App\\Http\\Controllers\\Auth\\PasswordController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@destroy',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@destroy',
        'controller' => 'App\\Http\\Controllers\\Auth\\AuthenticatedSessionController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminProfile',
        'controller' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminProfile',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.profile',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.profile.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/profile/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminProfileEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminProfileEdit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.profile.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.profile.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/profile/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminProfileStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminProfileStore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.profile.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.change.password' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/change/password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminChangePassword',
        'controller' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminChangePassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.change.password',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'update.change.password' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'update/change/password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminUpdateChangePassword',
        'controller' => 'App\\Http\\Controllers\\Backend\\AdminProfileController@AdminUpdateChangePassword',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'update.change.password',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'invoices.index',
        'uses' => 'App\\Http\\Controllers\\InvoiceController@index',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'invoices.create',
        'uses' => 'App\\Http\\Controllers\\InvoiceController@create',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'invoices.store',
        'uses' => 'App\\Http\\Controllers\\InvoiceController@store',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/{invoice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'invoices.show',
        'uses' => 'App\\Http\\Controllers\\InvoiceController@show',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/{invoice}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'invoices.edit',
        'uses' => 'App\\Http\\Controllers\\InvoiceController@edit',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'invoices/{invoice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'invoices.update',
        'uses' => 'App\\Http\\Controllers\\InvoiceController@update',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'invoices/{invoice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'invoices.destroy',
        'uses' => 'App\\Http\\Controllers\\InvoiceController@destroy',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/{invoice}/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@viewOnly',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@viewOnly',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.view',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.export.pdf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/{invoice}/export/pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@exportPDF',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@exportPDF',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.export.pdf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.export.word' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/{invoice}/export/word',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@exportWord',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@exportWord',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.export.word',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.print' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/{invoice}/print',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@printInvoice',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@printInvoice',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.print',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.send.reminder' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoices/{invoice}/send-reminder',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@sendPaymentReminder',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@sendPaymentReminder',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.send.reminder',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eiF0i7QYZH0kfxFo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:307:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:89:"function() {
    return \\response()->json([\'message\' => \'Email test route working\']);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008730000000000000000";}";s:4:"hash";s:44:"RfZFhnjeRnIRaEgg6bEnzpQWay1ji19YeAnt0I8C2A8=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::eiF0i7QYZH0kfxFo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Y3ekWPqCH4P8rmH2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:937:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:718:"function() {
    try {
        $html = \'<html><body><h1>Test PDF</h1><p>This is a test PDF generated at \' . \\date(\'Y-m-d H:i:s\') . \'</p></body></html>\';
        
        $pdf = new \\Dompdf\\Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper(\'A4\', \'portrait\');
        $pdf->render();
        
        $filename = \'test_pdf_\' . \\time() . \'.pdf\';
        
        return \\response($pdf->output())
            ->header(\'Content-Type\', \'application/pdf\')
            ->header(\'Content-Disposition\', \'attachment; filename="\' . $filename . \'"\');
            
    } catch (\\Exception $e) {
        return \\response()->json([\'error\' => \'PDF generation failed: \' . $e->getMessage()], 500);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008750000000000000000";}";s:4:"hash";s:44:"Y80Wm5JZE3hDHFoMFdFa0BFpeM5nY+PNbydWy4qXRzU=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Y3ekWPqCH4P8rmH2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.simple.pdf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'simple-pdf-download/{invoice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@simplePdfDownload',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@simplePdfDownload',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.simple.pdf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.simple.print' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'simple-print/{invoice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\InvoiceController@simplePrint',
        'controller' => 'App\\Http\\Controllers\\InvoiceController@simplePrint',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.simple.print',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rZMwIwmgLq2G2g9u' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-email-attachment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:1108:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:889:"function() {
    $testUpdate = new \\stdClass();
    $testUpdate->attachment = \'1778135396_1778074637_slider menu first 6 pages.png\';
    
    $attachmentPath = \\storage_path(\'app/public/\' . $testUpdate->attachment);
    
    $html = \'<h1>Email Attachment Test</h1>\';
    $html .= \'<p><strong>Attachment:</strong> \' . \\basename($testUpdate->attachment) . \'</p>\';
    $html .= \'<p><strong>File Path:</strong> \' . $attachmentPath . \'</p>\';
    $html .= \'<p><strong>File Exists:</strong> \' . (\\file_exists($attachmentPath) ? \'YES\' : \'NO\') . \'</p>\';
    $html .= \'<p><strong>Public Download URL:</strong> <a href="/public/attachments/\' . \\basename($testUpdate->attachment) . \'">Download Public</a></p>\';
    $html .= \'<p><strong>Authenticated Download URL:</strong> <a href="/attachments/\' . \\basename($testUpdate->attachment) . \'">Download Auth</a></p>\';
    
    return $html;
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008790000000000000000";}";s:4:"hash";s:44:"5nYvjQ+1WNLtyLZVv+nrbMfBr88UK3fzLCrorMA183s=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::rZMwIwmgLq2G2g9u',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employees.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employees',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employees.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employees.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employees/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@create',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employees.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employees.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employees',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@store',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employees.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employees.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employees/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@verify',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@verify',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employees.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employees.verify-otp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employees/verify-otp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@verifyOtp',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@verifyOtp',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employees.verify-otp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employees.resend-otp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employees/resend-otp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@resendOtp',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@resendOtp',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employees.resend-otp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employees.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employees/{employee}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@edit',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employees.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employees.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'employees/{employee}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@update',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employees.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employees.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'employees/{employee}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@destroy',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employees.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customers/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@create',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@create',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customers',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@store',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customers/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@verify',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@verify',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.verify-otp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customers/verify-otp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@verifyOtp',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@verifyOtp',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.verify-otp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.resend-otp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customers/resend-otp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@resendOtp',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@resendOtp',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.resend-otp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customers/{customer}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@edit',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@edit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'customers/{customer}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@update',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@update',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customers.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'customers/{customer}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@destroy',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@destroy',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customers.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee-report.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employee-report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@employeeReportIndex',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@employeeReportIndex',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee-report.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee-report.generate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'POST',
        2 => 'HEAD',
      ),
      'uri' => 'employee-report/generate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@generateEmployeeReport',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@generateEmployeeReport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee-report.generate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee-report.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employee-report/email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@sendEmployeeReportEmail',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@sendEmployeeReportEmail',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee-report.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee-report.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employee-report/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ProjectUpdateController@exportEmployeeReport',
        'controller' => 'App\\Http\\Controllers\\ProjectUpdateController@exportEmployeeReport',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee-report.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'approval-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@index',
        'namespace' => NULL,
        'prefix' => '/approval-status',
        'where' => 
        array (
        ),
        'as' => 'approval-status.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'approval-status/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@create',
        'controller' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@create',
        'namespace' => NULL,
        'prefix' => '/approval-status',
        'where' => 
        array (
        ),
        'as' => 'approval-status.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'approval-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@store',
        'controller' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@store',
        'namespace' => NULL,
        'prefix' => '/approval-status',
        'where' => 
        array (
        ),
        'as' => 'approval-status.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'approval-status/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@show',
        'controller' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@show',
        'namespace' => NULL,
        'prefix' => '/approval-status',
        'where' => 
        array (
        ),
        'as' => 'approval-status.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'approval-status/{id}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@approve',
        'controller' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@approve',
        'namespace' => NULL,
        'prefix' => '/approval-status',
        'where' => 
        array (
        ),
        'as' => 'approval-status.approve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'approval-status/{id}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@reject',
        'controller' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@reject',
        'namespace' => NULL,
        'prefix' => '/approval-status',
        'where' => 
        array (
        ),
        'as' => 'approval-status.reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.statistics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'approval-status/statistics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@statistics',
        'controller' => 'App\\Http\\Controllers\\Backend\\ApprovalStatusController@statistics',
        'namespace' => NULL,
        'prefix' => '/approval-status',
        'where' => 
        array (
        ),
        'as' => 'approval-status.statistics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gTusRj848vkQ4oFT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:406:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:187:"function() {
    $category = \\App\\Models\\Department::latest()->get();
    return "Found " . $category->count() . " departments. First: " . ($category->first()->department ?? \'None\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008910000000000000000";}";s:4:"hash";s:44:"Eek6ToIAO7F+ot5djoe+v5x6CY+nZoTKHaKxFTvhPBs=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::gTusRj848vkQ4oFT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'categories.redirect' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryView',
        'controller' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryView',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'categories.redirect',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryView',
        'controller' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryView',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'all.category',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'category.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'category/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryStore',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'category.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'category.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryEdit',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'category.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'category.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'category/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryUpdate',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'category.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'category.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\CategoryController@CategoryDelete',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'category.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.subcategory' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/sub/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryView',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryView',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'all.subcategory',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'subcategory.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'category/sub/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryStore',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'subcategory.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'subcategory.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/sub/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryEdit',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'subcategory.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'subcategory.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'category/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryUpdate',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'subcategory.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'subcategory.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/sub/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubCategoryDelete',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'subcategory.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.subsubcategory' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/sub/sub/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryView',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryView',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'all.subsubcategory',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::oPXSts9xjAxTz0cK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/subcategory/ajax/{category_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@GetSubCategory',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@GetSubCategory',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'generated::oPXSts9xjAxTz0cK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ltAROSnBfetUgV4z' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/sub-subcategory/ajax/{subcategory_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@GetSubSubCategory',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@GetSubSubCategory',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'generated::ltAROSnBfetUgV4z',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nALCSCV1WKgyy7y2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/service_category/ajax/{service_category_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@GetCategory',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@GetCategory',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'generated::nALCSCV1WKgyy7y2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'subsubcategory.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'category/sub/sub/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryStore',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'subsubcategory.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'subsubcategory.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/sub/sub/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryEdit',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'subsubcategory.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'subsubcategory.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'category/sub/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryUpdate',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'subsubcategory.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'subsubcategory.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'category/sub/sub/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\SubCategoryController@SubSubCategoryDelete',
        'namespace' => NULL,
        'prefix' => '/category',
        'where' => 
        array (
        ),
        'as' => 'subsubcategory.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.reminder' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reminder/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderView',
        'controller' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderView',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'all.reminder',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reminder.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reminder/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderStore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reminder.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reminder.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reminder/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderEdit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reminder.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reminder.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reminder/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reminder.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reminder.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reminder/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderDelete',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'reminder.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'add-reminder' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reminder/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderAdd',
        'controller' => 'App\\Http\\Controllers\\Backend\\ReminderController@reminderAdd',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'add-reminder',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0UjwP9mqywR02ORv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'generate-id',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ReminderController@generateId',
        'controller' => 'App\\Http\\Controllers\\Backend\\ReminderController@generateId',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::0UjwP9mqywR02ORv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.customer' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerView',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerView',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'all.customer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerStore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customer.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerEdit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customer.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'customer/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customer.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerDelete',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'customer.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'add-customer' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerAdd',
        'controller' => 'App\\Http\\Controllers\\Backend\\CustomerController@customerAdd',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'add-customer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.Employee' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Employee/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeView',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeView',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'all.Employee',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Employee.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Employee/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeStore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'Employee.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Employee.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Employee/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeEdit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'Employee.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Employee.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'Employee/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'Employee.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Employee.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Employee/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeDelete',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'Employee.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'add-Employee' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'Employee/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeAdd',
        'controller' => 'App\\Http\\Controllers\\Backend\\EmployeeController@EmployeeAdd',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'add-Employee',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.sales' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SalesController@salesView',
        'controller' => 'App\\Http\\Controllers\\Backend\\SalesController@salesView',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'all.sales',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sales/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SalesController@salesStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\SalesController@salesStore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sales.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SalesController@salesEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\SalesController@salesEdit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sales.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sales/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SalesController@salesUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\SalesController@salesUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sales.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SalesController@salesDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\SalesController@salesDelete',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sales.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'add-sales' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\SalesController@salesAdd',
        'controller' => 'App\\Http\\Controllers\\Backend\\SalesController@salesAdd',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'add-sales',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.ITEmployee' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ITEmployee/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeView',
        'controller' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeView',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'all.ITEmployee',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ITEmployee.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ITEmployee/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeStore',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ITEmployee.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ITEmployee.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ITEmployee/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeEdit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ITEmployee.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ITEmployee.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'ITEmployee/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeUpdate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ITEmployee.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ITEmployee.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ITEmployee/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeDelete',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ITEmployee.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'add-ITEmployee' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ITEmployee/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeAdd',
        'controller' => 'App\\Http\\Controllers\\Backend\\ITEmployeeController@EmployeeAdd',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'add-ITEmployee',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.brand' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/brand/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandView',
        'controller' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandView',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'all.brand',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'brand.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/brand/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandStore',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'brand.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'brand.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/brand/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandEdit',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'brand.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'brand.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/brand/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandUpdate',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'brand.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'brand.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/brand/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\BrandController@BrandDelete',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'brand.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.system_type' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/system_type/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeView',
        'controller' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeView',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'all.system_type',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'system_type.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/system_type/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeStore',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'system_type.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'system_type.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/system_type/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeEdit',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'system_type.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'system_type.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/system_type/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeUpdate',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'system_type.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'system_type.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/system_type/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\systemtypeController@system_typeDelete',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'system_type.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.service_category' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/service_category/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryView',
        'controller' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryView',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'all.service_category',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service_category.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/service_category/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryStore',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'service_category.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service_category.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/service_category/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryEdit',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'service_category.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service_category.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/service_category/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryUpdate',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'service_category.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'service_category.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/service_category/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\servicecategoryController@service_categoryDelete',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'service_category.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.operating_system' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/operating_system/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemView',
        'controller' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemView',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'all.operating_system',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'operating_system.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/operating_system/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemStore',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'operating_system.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'operating_system.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/operating_system/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemEdit',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'operating_system.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'operating_system.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/operating_system/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemUpdate',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'operating_system.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'operating_system.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/operating_system/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\operatingsystemController@operating_systemDelete',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'operating_system.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.Department' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/Department/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentView',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentView',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'all.Department',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Department.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/Department/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentStore',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Department.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Department.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/Department/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentEdit',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Department.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Department.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/Department/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentUpdate',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Department.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Department.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/Department/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@DepartmentDelete',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Department.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.Action' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/Action/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionView',
        'controller' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionView',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'all.Action',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Action.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/Action/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionStore',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Action.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Action.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/Action/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionEdit',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Action.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Action.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/Action/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionUpdate',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Action.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Action.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/Action/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\ActionController@ActionDelete',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Action.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.Ticket_status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/ticket_status/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusView',
        'controller' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusView',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'all.Ticket_status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Ticket_status.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/ticket_status/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusStore',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Ticket_status.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Ticket_status.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/ticket_status/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusEdit',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Ticket_status.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Ticket_status.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/ticket_status/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusUpdate',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Ticket_status.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Ticket_status.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/ticket_status/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\Ticket_statusController@Ticket_statusDelete',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Ticket_status.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'all.Group' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/Group/view',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupView',
        'controller' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupView',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'all.Group',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Group.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/Group/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupStore',
        'controller' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupStore',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Group.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Group.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/Group/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupEdit',
        'controller' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupEdit',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Group.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Group.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'control/Group/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupUpdate',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Group.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'Group.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'control/Group/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\GroupController@GroupDelete',
        'namespace' => NULL,
        'prefix' => '/control',
        'where' => 
        array (
        ),
        'as' => 'Group.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales.department' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales-department',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@salesDepartmentView',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@salesDepartmentView',
        'namespace' => NULL,
        'prefix' => '/sales-department',
        'where' => 
        array (
        ),
        'as' => 'sales.department',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales.department.create-invoice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sales-department/{lead}/create-invoice',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@createInvoiceFromLead',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@createInvoiceFromLead',
        'namespace' => NULL,
        'prefix' => '/sales-department',
        'where' => 
        array (
        ),
        'as' => 'sales.department.create-invoice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales.department.save-invoice' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sales-department/{lead}/save-invoice',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@saveInvoiceFromLead',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@saveInvoiceFromLead',
        'namespace' => NULL,
        'prefix' => '/sales-department',
        'where' => 
        array (
        ),
        'as' => 'sales.department.save-invoice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales.department.send-approval-email.backup' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'sales-department/{lead}/send-approval-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@sendApprovalEmail',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@sendApprovalEmail',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'sales.department.send-approval-email.backup',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sales.department.toggle-customer-panel' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'sales-department/{lead}/toggle-customer-panel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@toggleCustomerPanelForLead',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@toggleCustomerPanelForLead',
        'namespace' => NULL,
        'prefix' => '/sales-department',
        'where' => 
        array (
        ),
        'as' => 'sales.department.toggle-customer-panel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.sales-department.invoice-statuses' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/sales-department/invoice-statuses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@getInvoiceStatuses',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@getInvoiceStatuses',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'api.sales-department.invoice-statuses',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'api.accounts.invoice-statuses' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/accounts/invoice-statuses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@getInvoiceStatuses',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@getInvoiceStatuses',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'api.accounts.invoice-statuses',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.management' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/management/{quotationId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@management',
        'controller' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@management',
        'as' => 'invoices.management',
        'namespace' => NULL,
        'prefix' => '/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.create-installment' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/create-installment/{quotation}/{installmentLetter}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@createInstallment',
        'controller' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@createInstallment',
        'as' => 'invoices.create-installment',
        'namespace' => NULL,
        'prefix' => '/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.save-installment' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoices/save-installment/{quotation}/{installmentLetter}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@saveInstallment',
        'controller' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@saveInstallment',
        'as' => 'invoices.save-installment',
        'namespace' => NULL,
        'prefix' => '/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.send-approval-email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'invoices/send-approval-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@sendApprovalEmail',
        'controller' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@sendApprovalEmail',
        'as' => 'invoices.send-approval-email',
        'namespace' => NULL,
        'prefix' => '/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.test-email' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/test-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@testEmail',
        'controller' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@testEmail',
        'as' => 'invoices.test-email',
        'namespace' => NULL,
        'prefix' => '/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.management-show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/show/{invoice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@view',
        'controller' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@view',
        'as' => 'invoices.management-show',
        'namespace' => NULL,
        'prefix' => '/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'invoices/delete/{invoice}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@delete',
        'controller' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@delete',
        'as' => 'invoices.delete',
        'namespace' => NULL,
        'prefix' => '/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.api.statuses' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/api/statuses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@getInvoiceStatuses',
        'controller' => 'App\\Http\\Controllers\\Backend\\InvoiceManagementController@getInvoiceStatuses',
        'as' => 'invoices.api.statuses',
        'namespace' => NULL,
        'prefix' => '/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VXV9IZKrAQny1g56' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'refresh-csrf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:292:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:74:"function() {
    return \\response()->json([\'token\' => \\csrf_token()]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000008fb0000000000000000";}";s:4:"hash";s:44:"ax33oLfHUpSFoMNGYGKY5KK35NmJMLtiLRkCphuLXb0=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::VXV9IZKrAQny1g56',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoice.approve' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice/approve/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@approveInvoiceEnhanced',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@approveInvoiceEnhanced',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoice.approve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoice.reject' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoice/reject/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@rejectInvoiceEnhanced',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@rejectInvoiceEnhanced',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoice.reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'invoices.check-approval-status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'invoices/check-approval-status/{invoiceId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\DepartmentController@checkApprovalStatus',
        'controller' => 'App\\Http\\Controllers\\Backend\\DepartmentController@checkApprovalStatus',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'invoices.check-approval-status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'add-productuser' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/useraddticket',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@AddProductuser',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@AddProductuser',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'add-productuser',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'projects.get_by_system_type' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/projects/get-by-system-type',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@getProjectsBySystemType',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@getProjectsBySystemType',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'projects.get_by_system_type',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'add-product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/add',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@AddProduct',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@AddProduct',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'add-product',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'showForm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/showForm',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@showForm',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@showForm',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'showForm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product-store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@StoreProduct',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@StoreProduct',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product-store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product-storeuser' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/userdatastore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@StoreProductuser',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@StoreProductuser',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product-storeuser',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'manage-product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/manage',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@ManageProduct',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@ManageProduct',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'manage-product',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'my-manage-product' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/Mymanage',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@MyManageProduct',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@MyManageProduct',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'my-manage-product',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/edit/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@EditProduct',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@EditProduct',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/data/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductDataUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductDataUpdate',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'userassignupdate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/userassignupdate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@userassignupdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@userassignupdate',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'userassignupdate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'update-product-image' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/image/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@MultiImageUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@MultiImageUpdate',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'update-product-image',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'update-product-thambnail' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/thambnail/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@ThambnailImageUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@ThambnailImageUpdate',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'update-product-thambnail',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.multiimg.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/multiimg/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@MultiImageDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@MultiImageDelete',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product.multiimg.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.inactive' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/inactive/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductInactive',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductInactive',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product.inactive',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.active' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/active/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductActive',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductActive',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product.active',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.delete' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/delete/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductDelete',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductDelete',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1vUkRkIsbjrKztkU' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/Ticket/ajax/{Department_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@GetTicketUserName',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@GetTicketUserName',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'generated::1vUkRkIsbjrKztkU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::19KcCOZ4dLDmH309' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/timer/ajax',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@GetTimer',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@GetTimer',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'generated::19KcCOZ4dLDmH309',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.preview' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/preview_product/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@PreviewProduct',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@PreviewProduct',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product.preview',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.editemp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'product/editemp/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@EditProductemp',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@EditProductemp',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product.editemp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'product.updateemp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'product/data/updateemp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductDataUpdateemp',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@ProductDataUpdateemp',
        'namespace' => NULL,
        'prefix' => '/product',
        'where' => 
        array (
        ),
        'as' => 'product.updateemp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'excalate.assign' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'excalate/assign/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@nextteirgroupchange',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@nextteirgroupchange',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'excalate.assign',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'export-user' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'export-user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@exportUser',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@exportUser',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'export-user',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'import.user' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'import-user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\TicketController@importUser',
        'controller' => 'App\\Http\\Controllers\\Backend\\TicketController@importUser',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'import.user',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@index',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@create',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.create.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/create-new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@createNew',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@createNew',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.create.new',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leadsmanagement',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@store',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.store.new' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leadsmanagement/store-new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@storeNew',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@storeNew',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.store.new',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.edit.new' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/{lead}/edit-new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@editNew',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@editNew',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.edit.new',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.update.new' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'leadsmanagement/{lead}/update-new',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@updateNew',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@updateNew',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.update.new',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.upload' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@uploadForm',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@uploadForm',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.upload',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.upload.excel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leadsmanagement/upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@uploadExcel',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@uploadExcel',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.upload.excel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.direct.upload' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/direct-upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@directUploadForm',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@directUploadForm',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.direct.upload',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.process.excel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leadsmanagement/process-excel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@processExcel',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@processExcel',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.process.excel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.save.direct.upload' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leadsmanagement/save-direct-upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@saveDirectUpload',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@saveDirectUpload',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.save.direct.upload',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.template' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/template',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@downloadTemplate',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@downloadTemplate',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.template',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/{lead}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@show',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/{lead}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@edit',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'leadsmanagement/{lead}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@update',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'leadsmanagement/{lead}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@destroy',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.update.field' => 
    array (
      'methods' => 
      array (
        0 => 'PATCH',
      ),
      'uri' => 'leadsmanagement/{lead}/update-field',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@updateField',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@updateField',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.update.field',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'send.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leadsmanagement/send-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@sendEmail',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@sendEmail',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'send.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.send.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leadsmanagement/leads/send-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@sendEmail',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@sendEmail',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.send.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'test.email' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/test-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@testEmail',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@testEmail',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'test.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.reaction' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/{lead}/reaction',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@reaction',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@reaction',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.reaction',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.reaction.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leadsmanagement/{lead}/reaction',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@storeReaction',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@storeReaction',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.reaction.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leads.users.by.department' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leadsmanagement/users-by-department/{department}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@getUsersByDepartment',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@getUsersByDepartment',
        'namespace' => NULL,
        'prefix' => '/leadsmanagement',
        'where' => 
        array (
        ),
        'as' => 'leads.users.by.department',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'duedate.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'duedate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@dueDateIndex',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@dueDateIndex',
        'namespace' => NULL,
        'prefix' => '/duedate',
        'where' => 
        array (
        ),
        'as' => 'duedate.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'duedate.send.reminder' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'duedate/send-reminder/{lead}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@sendDueDateReminder',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@sendDueDateReminder',
        'namespace' => NULL,
        'prefix' => '/duedate',
        'where' => 
        array (
        ),
        'as' => 'duedate.send.reminder',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'duedate.send.bulk.reminders' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'duedate/send-bulk-reminders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeadController@sendBulkDueDateReminders',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeadController@sendBulkDueDateReminders',
        'namespace' => NULL,
        'prefix' => '/duedate',
        'where' => 
        array (
        ),
        'as' => 'duedate.send.bulk.reminders',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'google-sheets',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsController@index',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsController@index',
        'namespace' => NULL,
        'prefix' => '/google-sheets',
        'where' => 
        array (
        ),
        'as' => 'google-sheets.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets.test-connection' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'google-sheets/test-connection',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsController@testConnection',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsController@testConnection',
        'namespace' => NULL,
        'prefix' => '/google-sheets',
        'where' => 
        array (
        ),
        'as' => 'google-sheets.test-connection',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets.preview' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'google-sheets/preview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsController@preview',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsController@preview',
        'namespace' => NULL,
        'prefix' => '/google-sheets',
        'where' => 
        array (
        ),
        'as' => 'google-sheets.preview',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets.import' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'google-sheets/import',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsController@import',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsController@import',
        'namespace' => NULL,
        'prefix' => '/google-sheets',
        'where' => 
        array (
        ),
        'as' => 'google-sheets.import',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets.sync' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'google-sheets/sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsController@sync',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsController@sync',
        'namespace' => NULL,
        'prefix' => '/google-sheets',
        'where' => 
        array (
        ),
        'as' => 'google-sheets.sync',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets.configuration' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'google-sheets/configuration',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsController@configuration',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsController@configuration',
        'namespace' => NULL,
        'prefix' => '/google-sheets',
        'where' => 
        array (
        ),
        'as' => 'google-sheets.configuration',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets.configuration.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'google-sheets/configuration',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsController@updateConfiguration',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsController@updateConfiguration',
        'namespace' => NULL,
        'prefix' => '/google-sheets',
        'where' => 
        array (
        ),
        'as' => 'google-sheets.configuration.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets.statistics' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'google-sheets/statistics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsController@statistics',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsController@statistics',
        'namespace' => NULL,
        'prefix' => '/google-sheets',
        'where' => 
        array (
        ),
        'as' => 'google-sheets.statistics',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets-management.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'googlesheet',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@index',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'google-sheets-management.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets-management.sync' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'googlesheet/sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@sync',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@sync',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'google-sheets-management.sync',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google-sheets.export' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'googlesheet/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@export',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@export',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'google-sheets.export',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::RF27jp7wF2ekp4t6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/googlesheets/test-connection',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@testConnection',
        'controller' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@testConnection',
        'namespace' => NULL,
        'prefix' => '/api/googlesheets',
        'where' => 
        array (
        ),
        'as' => 'generated::RF27jp7wF2ekp4t6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EtSxRKqlCSz5OwG5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/googlesheets/new-entries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@getNewEntries',
        'controller' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@getNewEntries',
        'namespace' => NULL,
        'prefix' => '/api/googlesheets',
        'where' => 
        array (
        ),
        'as' => 'generated::EtSxRKqlCSz5OwG5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3NNcBWsoIJqLSVLj' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/googlesheets/column-data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@getColumnData',
        'controller' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@getColumnData',
        'namespace' => NULL,
        'prefix' => '/api/googlesheets',
        'where' => 
        array (
        ),
        'as' => 'generated::3NNcBWsoIJqLSVLj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CBHYcfx7IXMrSzkU' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/googlesheets/sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@sync',
        'controller' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@sync',
        'namespace' => NULL,
        'prefix' => '/api/googlesheets',
        'where' => 
        array (
        ),
        'as' => 'generated::CBHYcfx7IXMrSzkU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::BKwRSmeni05weoH1' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/googlesheets/export',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@export',
        'controller' => 'App\\Http\\Controllers\\SimpleGoogleSheetsController@export',
        'namespace' => NULL,
        'prefix' => '/api/googlesheets',
        'where' => 
        array (
        ),
        'as' => 'generated::BKwRSmeni05weoH1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapplogin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showLoginForm',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showLoginForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.login.post' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'callingapplogin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@login',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@login',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.login.post',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'callingapplogout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@logout',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@logout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@callingApp',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@callingApp',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.sync' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'callingapp/sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@sync',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@sync',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.sync',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.add-leads' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingappleads',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showAddLeadsForm',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showAddLeadsForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.add-leads',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.store-lead' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'callingappleads',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@storeLeadFromCallingApp',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@storeLeadFromCallingApp',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.store-lead',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.lead-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/lead-details/{index}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showLeadDetails',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showLeadDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.lead-details',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.lead-data' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/lead-data/{index}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getLeadDataForTransfer',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getLeadDataForTransfer',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.lead-data',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.employees' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/employees',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getEmployees',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getEmployees',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.employees',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.employees-debug' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/employees-debug',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:544:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:325:"function() {
    \\Log::info(\'Employee debug route accessed at: \' . \\now());
    return \\response()->json([
        \'success\' => true,
        \'message\' => \'Debug route working\',
        \'timestamp\' => \\now()->toISOString(),
        \'employees\' => \\App\\Models\\Employee::active()->get([\'id\', \'name\', \'email\'])
    ]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009560000000000000000";}";s:4:"hash";s:44:"sK8JcqhPf7+JkFBUZSui7d/Cjz3A68H8XGEM0CmPzyE=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.employees-debug',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.debug-manual-leads' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingappleads/debug',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:915:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:696:"function() {
    $manuallyAddedLeads = \\App\\Models\\Lead::where(\'source\', \'callingapp\')
        ->orderBy(\'created_at\', \'desc\')
        ->get();
    
    return \\response()->json([
        \'success\' => true,
        \'message\' => \'Debug route for manually added leads\',
        \'timestamp\' => \\now()->toISOString(),
        \'total_manual_leads\' => $manuallyAddedLeads->count(),
        \'leads\' => $manuallyAddedLeads->map(function($lead) {
            return [
                \'id\' => $lead->id,
                \'name\' => $lead->name,
                \'source\' => $lead->source,
                \'created_at\' => $lead->created_at->toISOString(),
            ];
        })
    ]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009580000000000000000";}";s:4:"hash";s:44:"+ZXuUgEEQCLRHcli+YvB28j58Zb5X82ixVLgrUnP8hk=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.debug-manual-leads',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.manual-leads' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/manual-leads',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showManualLeads',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showManualLeads',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.manual-leads',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.add-employee' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'callingapp/add-employee',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@addEmployee',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@addEmployee',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.add-employee',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.save-call-details' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'callingapp/save-call-details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@saveMeetingCallDetails',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@saveMeetingCallDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.save-call-details',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.test-connection' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'callingapp/test-connection',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@testConnection',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@testConnection',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.test-connection',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'whatsapp.main' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'mywhatsapp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\WhatsAppController@index',
        'controller' => 'App\\Http\\Controllers\\WhatsAppController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'whatsapp.main',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'whatsapp.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'whatsapp',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\WhatsAppController@index',
        'controller' => 'App\\Http\\Controllers\\WhatsAppController@index',
        'namespace' => NULL,
        'prefix' => '/whatsapp',
        'where' => 
        array (
        ),
        'as' => 'whatsapp.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'whatsapp.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'whatsapp/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\WhatsAppController@sendMessage',
        'controller' => 'App\\Http\\Controllers\\WhatsAppController@sendMessage',
        'namespace' => NULL,
        'prefix' => '/whatsapp',
        'where' => 
        array (
        ),
        'as' => 'whatsapp.send',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'whatsapp.bulk.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'whatsapp/bulk-send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\WhatsAppController@sendBulkMessage',
        'controller' => 'App\\Http\\Controllers\\WhatsAppController@sendBulkMessage',
        'namespace' => NULL,
        'prefix' => '/whatsapp',
        'where' => 
        array (
        ),
        'as' => 'whatsapp.bulk.send',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'whatsapp.templates' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'whatsapp/templates',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\WhatsAppController@getTemplates',
        'controller' => 'App\\Http\\Controllers\\WhatsAppController@getTemplates',
        'namespace' => NULL,
        'prefix' => '/whatsapp',
        'where' => 
        array (
        ),
        'as' => 'whatsapp.templates',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'whatsapp.history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'whatsapp/history/{leadId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\WhatsAppController@getMessageHistory',
        'controller' => 'App\\Http\\Controllers\\WhatsAppController@getMessageHistory',
        'namespace' => NULL,
        'prefix' => '/whatsapp',
        'where' => 
        array (
        ),
        'as' => 'whatsapp.history',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'whatsapp.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'whatsapp/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\WhatsAppController@checkStatus',
        'controller' => 'App\\Http\\Controllers\\WhatsAppController@checkStatus',
        'namespace' => NULL,
        'prefix' => '/whatsapp',
        'where' => 
        array (
        ),
        'as' => 'whatsapp.status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.get-call-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/call-details/{email}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getMeetingCallDetails',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getMeetingCallDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.get-call-details',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.callhistory' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/callhistory',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showCallHistoryPage',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showCallHistoryPage',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.callhistory',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callhistory.direct' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callhistory',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showCallHistoryPage',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showCallHistoryPage',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callhistory.direct',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.get-call-details-by-lead' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/call-details-by-lead',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getMeetingCallDetailsByLead',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getMeetingCallDetailsByLead',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.get-call-details-by-lead',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.get-meeting-call-detail' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/meeting-call-detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getMeetingCallDetail',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getMeetingCallDetail',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.get-meeting-call-detail',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.update-meeting-call-detail' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'callingapp/meeting-call-detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@updateMeetingCallDetail',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@updateMeetingCallDetail',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.update-meeting-call-detail',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'callingapp.today-followup-count' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'callingapp/today-followup-count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getTodayFollowupCount',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getTodayFollowupCount',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'callingapp.today-followup-count',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'automated-sync.auto-sync' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'automated-sync/auto-sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AutomatedSyncController@autoSync',
        'controller' => 'App\\Http\\Controllers\\AutomatedSyncController@autoSync',
        'namespace' => NULL,
        'prefix' => '/automated-sync',
        'where' => 
        array (
        ),
        'as' => 'automated-sync.auto-sync',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'automated-sync.check-notifications' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'automated-sync/check-notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AutomatedSyncController@checkNewEntriesAndNotify',
        'controller' => 'App\\Http\\Controllers\\AutomatedSyncController@checkNewEntriesAndNotify',
        'namespace' => NULL,
        'prefix' => '/automated-sync',
        'where' => 
        array (
        ),
        'as' => 'automated-sync.check-notifications',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'automated-sync.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'automated-sync/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AutomatedSyncController@getStatus',
        'controller' => 'App\\Http\\Controllers\\AutomatedSyncController@getStatus',
        'namespace' => NULL,
        'prefix' => '/automated-sync',
        'where' => 
        array (
        ),
        'as' => 'automated-sync.status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'followup.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'followup',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showFollowupPage',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@showFollowupPage',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'followup.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'followup.entries' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'followup/entries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getFollowupEntries',
        'controller' => 'App\\Http\\Controllers\\GoogleSheetsManagementController@getFollowupEntries',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'followup.entries',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'external-sync.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'external-sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ExternalSyncController@index',
        'controller' => 'App\\Http\\Controllers\\ExternalSyncController@index',
        'namespace' => NULL,
        'prefix' => '/external-sync',
        'where' => 
        array (
        ),
        'as' => 'external-sync.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'external-sync.sync' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'external-sync/sync',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ExternalSyncController@sync',
        'controller' => 'App\\Http\\Controllers\\ExternalSyncController@sync',
        'namespace' => NULL,
        'prefix' => '/external-sync',
        'where' => 
        array (
        ),
        'as' => 'external-sync.sync',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'external-sync.generate-sql' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'external-sync/generate-sql',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ExternalSyncController@generateSQL',
        'controller' => 'App\\Http\\Controllers\\ExternalSyncController@generateSQL',
        'namespace' => NULL,
        'prefix' => '/external-sync',
        'where' => 
        array (
        ),
        'as' => 'external-sync.generate-sql',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'external-sync.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'external-sync/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ExternalSyncController@status',
        'controller' => 'App\\Http\\Controllers\\ExternalSyncController@status',
        'namespace' => NULL,
        'prefix' => '/external-sync',
        'where' => 
        array (
        ),
        'as' => 'external-sync.status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'external-sync.create-trigger' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'external-sync/create-trigger',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ExternalSyncController@createTrigger',
        'controller' => 'App\\Http\\Controllers\\ExternalSyncController@createTrigger',
        'namespace' => NULL,
        'prefix' => '/external-sync',
        'where' => 
        array (
        ),
        'as' => 'external-sync.create-trigger',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'external-sync.test-connection' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'external-sync/test-connection',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ExternalSyncController@testConnection',
        'controller' => 'App\\Http\\Controllers\\ExternalSyncController@testConnection',
        'namespace' => NULL,
        'prefix' => '/external-sync',
        'where' => 
        array (
        ),
        'as' => 'external-sync.test-connection',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'staprio.statuses' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'staprio/statuses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\StaprioController@getStatuses',
        'controller' => 'App\\Http\\Controllers\\Admin\\StaprioController@getStatuses',
        'namespace' => NULL,
        'prefix' => '/staprio',
        'where' => 
        array (
        ),
        'as' => 'staprio.statuses',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'staprio.priorities' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'staprio/priorities',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\StaprioController@getPriorities',
        'controller' => 'App\\Http\\Controllers\\Admin\\StaprioController@getPriorities',
        'namespace' => NULL,
        'prefix' => '/staprio',
        'where' => 
        array (
        ),
        'as' => 'staprio.priorities',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'staprio.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'staprio',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\StaprioController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\StaprioController@store',
        'namespace' => NULL,
        'prefix' => '/staprio',
        'where' => 
        array (
        ),
        'as' => 'staprio.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'staprio.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'staprio/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\StaprioController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\StaprioController@update',
        'namespace' => NULL,
        'prefix' => '/staprio',
        'where' => 
        array (
        ),
        'as' => 'staprio.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'staprio.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'staprio/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\StaprioController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\StaprioController@destroy',
        'namespace' => NULL,
        'prefix' => '/staprio',
        'where' => 
        array (
        ),
        'as' => 'staprio.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reactions-system.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reactions-system',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@index',
        'namespace' => NULL,
        'prefix' => '/reactions-system',
        'where' => 
        array (
        ),
        'as' => 'reactions-system.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reactions-system.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reactions-system',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@store',
        'namespace' => NULL,
        'prefix' => '/reactions-system',
        'where' => 
        array (
        ),
        'as' => 'reactions-system.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reactions-system.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reactions-system/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@show',
        'namespace' => NULL,
        'prefix' => '/reactions-system',
        'where' => 
        array (
        ),
        'as' => 'reactions-system.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reactions-system.updateStatus' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'reactions-system/{id}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@updateStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@updateStatus',
        'namespace' => NULL,
        'prefix' => '/reactions-system',
        'where' => 
        array (
        ),
        'as' => 'reactions-system.updateStatus',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reactions-system.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'reactions-system/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@destroy',
        'namespace' => NULL,
        'prefix' => '/reactions-system',
        'where' => 
        array (
        ),
        'as' => 'reactions-system.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reactions.send.test' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reactions-system/send/test',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@testNotifications',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@testNotifications',
        'namespace' => NULL,
        'prefix' => '/reactions-system',
        'where' => 
        array (
        ),
        'as' => 'reactions.send.test',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reactions.send.pending' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reactions-system/send/pending',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@sendPendingNotifications',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@sendPendingNotifications',
        'namespace' => NULL,
        'prefix' => '/reactions-system',
        'where' => 
        array (
        ),
        'as' => 'reactions.send.pending',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'reactions.system.status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reactions-system/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@getSystemStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionsSystemController@getSystemStatus',
        'namespace' => NULL,
        'prefix' => '/reactions-system',
        'where' => 
        array (
        ),
        'as' => 'reactions.system.status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'lead-notifications.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'lead-notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@index',
        'namespace' => NULL,
        'prefix' => '/lead-notifications',
        'where' => 
        array (
        ),
        'as' => 'lead-notifications.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'lead-notifications.count' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'lead-notifications/count',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@getNotificationCount',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@getNotificationCount',
        'namespace' => NULL,
        'prefix' => '/lead-notifications',
        'where' => 
        array (
        ),
        'as' => 'lead-notifications.count',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'lead-notifications.read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'lead-notifications/{id}/read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@markAsRead',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@markAsRead',
        'namespace' => NULL,
        'prefix' => '/lead-notifications',
        'where' => 
        array (
        ),
        'as' => 'lead-notifications.read',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'lead-notifications.read-all' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'lead-notifications/read-all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@markAllAsRead',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@markAllAsRead',
        'namespace' => NULL,
        'prefix' => '/lead-notifications',
        'where' => 
        array (
        ),
        'as' => 'lead-notifications.read-all',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'lead-notifications.upcoming' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'lead-notifications/upcoming',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@getUpcomingFollowUps',
        'controller' => 'App\\Http\\Controllers\\Admin\\ReactionNotificationController@getUpcomingFollowUps',
        'namespace' => NULL,
        'prefix' => '/lead-notifications',
        'where' => 
        array (
        ),
        'as' => 'lead-notifications.upcoming',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ServiceController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\ServiceController@index',
        'namespace' => NULL,
        'prefix' => '/services',
        'where' => 
        array (
        ),
        'as' => 'services.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ServiceController@create',
        'controller' => 'App\\Http\\Controllers\\Backend\\ServiceController@create',
        'namespace' => NULL,
        'prefix' => '/services',
        'where' => 
        array (
        ),
        'as' => 'services.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ServiceController@store',
        'controller' => 'App\\Http\\Controllers\\Backend\\ServiceController@store',
        'namespace' => NULL,
        'prefix' => '/services',
        'where' => 
        array (
        ),
        'as' => 'services.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'services/{service}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ServiceController@edit',
        'controller' => 'App\\Http\\Controllers\\Backend\\ServiceController@edit',
        'namespace' => NULL,
        'prefix' => '/services',
        'where' => 
        array (
        ),
        'as' => 'services.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'services/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ServiceController@update',
        'controller' => 'App\\Http\\Controllers\\Backend\\ServiceController@update',
        'namespace' => NULL,
        'prefix' => '/services',
        'where' => 
        array (
        ),
        'as' => 'services.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'services.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'services/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\ServiceController@destroy',
        'controller' => 'App\\Http\\Controllers\\Backend\\ServiceController@destroy',
        'namespace' => NULL,
        'prefix' => '/services',
        'where' => 
        array (
        ),
        'as' => 'services.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::v569Fsoh4yhRhDyJ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-route',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:307:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:89:"function() {
    return \\response()->json([\'message\' => \'Route system is working!\']);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009710000000000000000";}";s:4:"hash";s:44:"bTIBVQlOmS0DcNSiHtTzkipn0umzhnTE11wrlmzZTMo=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::v569Fsoh4yhRhDyJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xoMCRE2RUu5kDXKy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-task-status-email/{invoiceId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:1708:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1488:"function($invoiceId) {
    try {
        $invoice = \\App\\Models\\Invoice::find($invoiceId);
        if (!$invoice) {
            return \\response()->json([\'error\' => \'Invoice not found\'], 404);
        }
        
        // Create test update data
        $originalUpdate = new \\stdClass();
        $originalUpdate->invoice = $invoice;
        $originalUpdate->request_text = "1. Test task content\\n2. Another test task";
        
        $workUpdate = new \\stdClass();
        $workUpdate->update_point_1 = "✅ Test task content - Completed\\n🔄 Another test task - Working";
        $workUpdate->update_date = \\now();
        
        $user = \\Illuminate\\Support\\Facades\\Auth::user();
        
        // Send the email
        $controller = new \\App\\Http\\Controllers\\ProjectUpdateController();
        $controller->sendTaskStatusUpdateEmail($originalUpdate, $workUpdate, $user);
        
        return \\response()->json([
            \'success\' => true,
            \'message\' => \'Test email sent successfully to: \' . $invoice->customer_email,
            \'invoice\' => [
                \'invoice_number\' => $invoice->invoice_number,
                \'project_name\' => $invoice->project_name,
                \'customer_email\' => $invoice->customer_email
            ]
        ]);
        
    } catch (\\Exception $e) {
        return \\response()->json([
            \'error\' => \'Failed to send test email: \' . $e->getMessage()
        ], 500);
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009910000000000000000";}";s:4:"hash";s:44:"T4iXRvWGsr1/ZCDwGHNjLK3WoCwO9mpJU6kTfg0BA/Q=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::xoMCRE2RUu5kDXKy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payment.plan' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payment-plan/{quotation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@paymentPlan',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@paymentPlan',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'payment.plan',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@index',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.store-session-data' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'accounts/store-session-data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@storeSessionData',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@storeSessionData',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.store-session-data',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.confirm-payment-plan' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'accounts/confirm-payment-plan/{quotation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@confirmPaymentPlan',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@confirmPaymentPlan',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.confirm-payment-plan',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.update-payment' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'accounts/{quotation}/update-payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@updatePaymentStatus',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@updatePaymentStatus',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.update-payment',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.toggle-customer-panel' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'accounts/{quotation}/toggle-customer-panel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@toggleCustomerPanel',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@toggleCustomerPanel',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.toggle-customer-panel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.lead.toggle-customer-panel' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'accounts/lead/{lead}/toggle-customer-panel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@toggleCustomerPanelForLead',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@toggleCustomerPanelForLead',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.lead.toggle-customer-panel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.move-lead-to-quotation' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'accounts/move-lead-to-quotation/{lead}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@moveLeadToQuotation',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@moveLeadToQuotation',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.move-lead-to-quotation',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.move-quotation-to-lead' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'accounts/move-quotation-to-lead/{quotation}/{lead}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@moveQuotationToLead',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@moveQuotationToLead',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.move-quotation-to-lead',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.generate-invoice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts/generate-invoice/{quotation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@generateInvoice',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@generateInvoice',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.generate-invoice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.create-invoice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts/create-invoice/{quotation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@generateInvoice',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@generateInvoice',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.create-invoice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.simple-save-invoice' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'accounts/simple-save-invoice/{quotation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@simpleSaveInvoice',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@simpleSaveInvoice',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.simple-save-invoice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'accounts.edit-quotation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'accounts/edit-quotation/{quotation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\AccountController@editQuotation',
        'controller' => 'App\\Http\\Controllers\\Backend\\AccountController@editQuotation',
        'namespace' => NULL,
        'prefix' => '/accounts',
        'where' => 
        array (
        ),
        'as' => 'accounts.edit-quotation',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@index',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotations/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@create',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@create',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@store',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@store',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotations/{quotation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@show',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@show',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotations/{quotation}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@edit',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@edit',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'quotations/{quotation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@update',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@update',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'quotations/{quotation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@destroy',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@destroy',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'quotations/{quotation}/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@sendEmail',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@sendEmail',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.send',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.pdf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotations/{quotation}/pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@downloadPDF',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@downloadPDF',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.pdf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.email-history' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotations/{quotation}/email-history',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@getEmailHistory',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@getEmailHistory',
        'namespace' => NULL,
        'prefix' => '/quotations',
        'where' => 
        array (
        ),
        'as' => 'quotations.email-history',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.approve' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotations/approve/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@approveQuotation',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@approveQuotation',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'quotations.approve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'quotations.reject' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'quotations/reject/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\QuotationController@rejectQuotation',
        'controller' => 'App\\Http\\Controllers\\Backend\\QuotationController@rejectQuotation',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'quotations.reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xx5oyfVAswZdm6tB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:291:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:73:"function() {
        return \\redirect()->route(\'invoices.index\');
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009ae0000000000000000";}";s:4:"hash";s:44:"nsy4KRmTFageHeGjv9PAuo0MnISevODWqM6lH+QzPDg=";}}',
        'namespace' => NULL,
        'prefix' => '/customer',
        'where' => 
        array (
        ),
        'as' => 'generated::xx5oyfVAswZdm6tB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/home',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerCompanyController@home',
        'controller' => 'App\\Http\\Controllers\\CustomerCompanyController@home',
        'namespace' => NULL,
        'prefix' => '/customer',
        'where' => 
        array (
        ),
        'as' => 'customer.home',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerCompanyController@dashboard',
        'controller' => 'App\\Http\\Controllers\\CustomerCompanyController@dashboard',
        'namespace' => NULL,
        'prefix' => '/customer',
        'where' => 
        array (
        ),
        'as' => 'customer.dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.mycusdashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/mycusdashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerCompanyController@myCustomerDashboard',
        'controller' => 'App\\Http\\Controllers\\CustomerCompanyController@myCustomerDashboard',
        'namespace' => NULL,
        'prefix' => '/customer',
        'where' => 
        array (
        ),
        'as' => 'customer.mycusdashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.companies.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/companies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerCompanyController@index',
        'controller' => 'App\\Http\\Controllers\\CustomerCompanyController@index',
        'namespace' => NULL,
        'prefix' => '/customer',
        'where' => 
        array (
        ),
        'as' => 'customer.companies.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.companies.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/companies/{companyName}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerCompanyController@show',
        'controller' => 'App\\Http\\Controllers\\CustomerCompanyController@show',
        'namespace' => NULL,
        'prefix' => '/customer',
        'where' => 
        array (
        ),
        'as' => 'customer.companies.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.companies.invoices' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/companies/{companyName}/invoices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerCompanyController@invoices',
        'controller' => 'App\\Http\\Controllers\\CustomerCompanyController@invoices',
        'namespace' => NULL,
        'prefix' => '/customer',
        'where' => 
        array (
        ),
        'as' => 'customer.companies.invoices',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.companies.projects' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/companies/{companyName}/projects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerCompanyController@projects',
        'controller' => 'App\\Http\\Controllers\\CustomerCompanyController@projects',
        'namespace' => NULL,
        'prefix' => '/customer',
        'where' => 
        array (
        ),
        'as' => 'customer.companies.projects',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'customer.quotations.pdf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'customer/quotations/{quotation}/pdf',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\CustomerCompanyController@downloadQuotationPDF',
        'controller' => 'App\\Http\\Controllers\\CustomerCompanyController@downloadQuotationPDF',
        'namespace' => NULL,
        'prefix' => '/customer',
        'where' => 
        array (
        ),
        'as' => 'customer.quotations.pdf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu-controller.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu-controller',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@index',
        'namespace' => NULL,
        'prefix' => '/menu-controller',
        'where' => 
        array (
        ),
        'as' => 'menu-controller.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu-controller.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu-controller/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@create',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@create',
        'namespace' => NULL,
        'prefix' => '/menu-controller',
        'where' => 
        array (
        ),
        'as' => 'menu-controller.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu-controller.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'menu-controller',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@store',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@store',
        'namespace' => NULL,
        'prefix' => '/menu-controller',
        'where' => 
        array (
        ),
        'as' => 'menu-controller.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu-controller.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu-controller/{menu}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@edit',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@edit',
        'namespace' => NULL,
        'prefix' => '/menu-controller',
        'where' => 
        array (
        ),
        'as' => 'menu-controller.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu-controller.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'menu-controller/{menu}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@update',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@update',
        'namespace' => NULL,
        'prefix' => '/menu-controller',
        'where' => 
        array (
        ),
        'as' => 'menu-controller.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu-controller.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'menu-controller/{menu}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@destroy',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@destroy',
        'namespace' => NULL,
        'prefix' => '/menu-controller',
        'where' => 
        array (
        ),
        'as' => 'menu-controller.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu-controller.api.permissions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'menu-controller/api/permissions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@getMenuPermissions',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@getMenuPermissions',
        'namespace' => NULL,
        'prefix' => '/menu-controller',
        'where' => 
        array (
        ),
        'as' => 'menu-controller.api.permissions',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'menu-controller.api.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'menu-controller/api/permissions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@updateMenuPermissions',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@updateMenuPermissions',
        'namespace' => NULL,
        'prefix' => '/menu-controller',
        'where' => 
        array (
        ),
        'as' => 'menu-controller.api.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee-menu-controller.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employee-menu-controller',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@employeeIndex',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@employeeIndex',
        'namespace' => NULL,
        'prefix' => '/employee-menu-controller',
        'where' => 
        array (
        ),
        'as' => 'employee-menu-controller.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee-menu-controller.api.employees' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employee-menu-controller/api/employees',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@getEmployeesByDepartmentAndRole',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@getEmployeesByDepartmentAndRole',
        'namespace' => NULL,
        'prefix' => '/employee-menu-controller',
        'where' => 
        array (
        ),
        'as' => 'employee-menu-controller.api.employees',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee-menu-controller.api.permissions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employee-menu-controller/api/permissions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@getEmployeeMenuPermissions',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@getEmployeeMenuPermissions',
        'namespace' => NULL,
        'prefix' => '/employee-menu-controller',
        'where' => 
        array (
        ),
        'as' => 'employee-menu-controller.api.permissions',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee-menu-controller.api.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employee-menu-controller/api/permissions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\MenuController@updateEmployeeMenuPermissions',
        'controller' => 'App\\Http\\Controllers\\Backend\\MenuController@updateEmployeeMenuPermissions',
        'namespace' => NULL,
        'prefix' => '/employee-menu-controller',
        'where' => 
        array (
        ),
        'as' => 'employee-menu-controller.api.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'activity-logs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'activity-logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@index',
        'namespace' => NULL,
        'prefix' => '/activity-logs',
        'where' => 
        array (
        ),
        'as' => 'activity-logs.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'activity-logs.api' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'activity-logs/api/logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@getLogs',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@getLogs',
        'namespace' => NULL,
        'prefix' => '/activity-logs',
        'where' => 
        array (
        ),
        'as' => 'activity-logs.api',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'activity-logs.read' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'activity-logs/api/logs/{id}/read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@markAsRead',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@markAsRead',
        'namespace' => NULL,
        'prefix' => '/activity-logs',
        'where' => 
        array (
        ),
        'as' => 'activity-logs.read',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'activity-logs.read-all' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'activity-logs/api/logs/read-all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@markAllAsRead',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@markAllAsRead',
        'namespace' => NULL,
        'prefix' => '/activity-logs',
        'where' => 
        array (
        ),
        'as' => 'activity-logs.read-all',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'activity-logs.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'activity-logs/api/logs/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\LogsController@deleteLog',
        'controller' => 'App\\Http\\Controllers\\Backend\\LogsController@deleteLog',
        'namespace' => NULL,
        'prefix' => '/activity-logs',
        'where' => 
        array (
        ),
        'as' => 'activity-logs.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Mbk8PZLu0MEWmiTT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'debug-user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:757:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:538:"function() {
    if (!\\auth()->check()) {
        return \\response()->json([\'error\' => \'Not authenticated\'], 401);
    }
    
    $user = \\auth()->user();
    return \\response()->json([
        \'user_id\' => $user->id,
        \'name\' => $user->name,
        \'role\' => $user->role,
        \'department\' => $user->department,
        \'position\' => $user->position,
        \'can_access_quotations\' => true, // Since routes only require auth
        \'can_access_services\' => true, // Since we removed role restrictions
    ]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009ac0000000000000000";}";s:4:"hash";s:44:"LJLWRsh3mLRI/iEDkCKlRAYRcZJhqEDvVlErx3CWxSw=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::Mbk8PZLu0MEWmiTT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'xray.viewer' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dashboard-xray',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\XrayViewerController@index',
        'controller' => 'App\\Http\\Controllers\\XrayViewerController@index',
        'namespace' => NULL,
        'prefix' => '/dashboard-xray',
        'where' => 
        array (
        ),
        'as' => 'xray.viewer',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'xray.upload' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'dashboard-xray/upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\XrayViewerController@uploadDicom',
        'controller' => 'App\\Http\\Controllers\\XrayViewerController@uploadDicom',
        'namespace' => NULL,
        'prefix' => '/dashboard-xray',
        'where' => 
        array (
        ),
        'as' => 'xray.upload',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'xray.view' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dashboard-xray/view/{filename}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\XrayViewerController@viewDicom',
        'controller' => 'App\\Http\\Controllers\\XrayViewerController@viewDicom',
        'namespace' => NULL,
        'prefix' => '/dashboard-xray',
        'where' => 
        array (
        ),
        'as' => 'xray.view',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'xray.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'dashboard-xray/download/{filename}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\XrayViewerController@downloadDicom',
        'controller' => 'App\\Http\\Controllers\\XrayViewerController@downloadDicom',
        'namespace' => NULL,
        'prefix' => '/dashboard-xray',
        'where' => 
        array (
        ),
        'as' => 'xray.download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page-customization',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@index',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@index',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.users-for-role' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page-customization/users-for-role',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getUsersForRole',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getUsersForRole',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.users-for-role',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.analyze' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'page-customization/analyze',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@analyzePage',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@analyzePage',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.analyze',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.get-customizations' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page-customization/get-customizations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getCustomizations',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getCustomizations',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.get-customizations',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.apply-customizations' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'page-customization/apply-customizations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@applyCustomizations',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@applyCustomizations',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.apply-customizations',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'page-customization/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@store',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@store',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.update-single' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'page-customization/update-single',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@updateSingle',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@updateSingle',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.update-single',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.batch-update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'page-customization/batch-update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@batchUpdate',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@batchUpdate',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.batch-update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'page-customization/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@destroy',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@destroy',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page-customization.reset' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'page-customization/reset',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@reset',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@reset',
        'namespace' => NULL,
        'prefix' => '/page-customization',
        'where' => 
        array (
        ),
        'as' => 'page-customization.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EehPhNhNEWPDoSSB' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/current-user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getCurrentUser',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getCurrentUser',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::EehPhNhNEWPDoSSB',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::TJ5JnLAJ53ErymUe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/menu-controller-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getMenuControllerSettings',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getMenuControllerSettings',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::TJ5JnLAJ53ErymUe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pQUvjHFeQJjYTnPE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/page-customizations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getSimpleCustomizations',
        'controller' => 'App\\Http\\Controllers\\Backend\\PageCustomizationController@getSimpleCustomizations',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::pQUvjHFeQJjYTnPE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fBrhH4wNlUQnweAp' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'test-post',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\TestController@testPost',
        'controller' => 'App\\Http\\Controllers\\TestController@testPost',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::fBrhH4wNlUQnweAp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role-element-visibility.roles' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'role-element-visibility/roles',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\RoleElementVisibilityController@getRoles',
        'controller' => 'App\\Http\\Controllers\\RoleElementVisibilityController@getRoles',
        'namespace' => NULL,
        'prefix' => '/role-element-visibility',
        'where' => 
        array (
        ),
        'as' => 'role-element-visibility.roles',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role-element-visibility.get' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'role-element-visibility/get',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\RoleElementVisibilityController@getVisibility',
        'controller' => 'App\\Http\\Controllers\\RoleElementVisibilityController@getVisibility',
        'namespace' => NULL,
        'prefix' => '/role-element-visibility',
        'where' => 
        array (
        ),
        'as' => 'role-element-visibility.get',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role-element-visibility.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'role-element-visibility/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\RoleElementVisibilityController@updateVisibility',
        'controller' => 'App\\Http\\Controllers\\RoleElementVisibilityController@updateVisibility',
        'namespace' => NULL,
        'prefix' => '/role-element-visibility',
        'where' => 
        array (
        ),
        'as' => 'role-element-visibility.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role-element-visibility.bulk-update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'role-element-visibility/bulk-update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\RoleElementVisibilityController@bulkUpdate',
        'controller' => 'App\\Http\\Controllers\\RoleElementVisibilityController@bulkUpdate',
        'namespace' => NULL,
        'prefix' => '/role-element-visibility',
        'where' => 
        array (
        ),
        'as' => 'role-element-visibility.bulk-update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'role-element-visibility.apply' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'role-element-visibility/apply',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\RoleElementVisibilityController@applyVisibility',
        'controller' => 'App\\Http\\Controllers\\RoleElementVisibilityController@applyVisibility',
        'namespace' => NULL,
        'prefix' => '/role-element-visibility',
        'where' => 
        array (
        ),
        'as' => 'role-element-visibility.apply',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ai-helper.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'ai-helper',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:271:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:53:"function() {
    return \\view(\'ai-helper.index\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009db0000000000000000";}";s:4:"hash";s:44:"WwsgZCqzEWjpMV0pLQORCBTbKYykS379N1l/WBvMoog=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'ai-helper.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@dashboard',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@dashboard',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/show/{attendance}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@show',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@show',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/edit/{attendance}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@edit',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@edit',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.report' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/report',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@report',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@report',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.report',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.check-in' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'attendance/check-in',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@checkIn',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@checkIn',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.check-in',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.check-out' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'attendance/check-out',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@checkOut',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@checkOut',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.check-out',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.mark' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'attendance/mark',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@markAttendance',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@markAttendance',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.mark',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.data' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@getAttendanceData',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@getAttendanceData',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.data',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.check-status' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/check-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@checkAttendanceStatus',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@checkAttendanceStatus',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.check-status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'attendance.send.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'attendance/send-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AttendanceController@sendEmailReport',
        'controller' => 'App\\Http\\Controllers\\AttendanceController@sendEmailReport',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'attendance.send.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VMyJK7EXbrc7UwlU' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'attendance/clear-popup-session',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:348:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:129:"function() {
        \\session()->forget(\'show_attendance_popup\');
        return \\response()->json([\'success\' => true]);
    }";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009ee0000000000000000";}";s:4:"hash";s:44:"Oc2YhzNQoa34FU4lOv+X1RjfAiHwnz01G5S8dcLWoqs=";}}',
        'namespace' => NULL,
        'prefix' => '/attendance',
        'where' => 
        array (
        ),
        'as' => 'generated::VMyJK7EXbrc7UwlU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shifts.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shifts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ShiftController@index',
        'controller' => 'App\\Http\\Controllers\\ShiftController@index',
        'namespace' => NULL,
        'prefix' => '/shifts',
        'where' => 
        array (
        ),
        'as' => 'shifts.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shifts.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shifts/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ShiftController@create',
        'controller' => 'App\\Http\\Controllers\\ShiftController@create',
        'namespace' => NULL,
        'prefix' => '/shifts',
        'where' => 
        array (
        ),
        'as' => 'shifts.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shifts.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shifts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ShiftController@store',
        'controller' => 'App\\Http\\Controllers\\ShiftController@store',
        'namespace' => NULL,
        'prefix' => '/shifts',
        'where' => 
        array (
        ),
        'as' => 'shifts.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shifts.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'shifts/{shift}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ShiftController@edit',
        'controller' => 'App\\Http\\Controllers\\ShiftController@edit',
        'namespace' => NULL,
        'prefix' => '/shifts',
        'where' => 
        array (
        ),
        'as' => 'shifts.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shifts.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'shifts/{shift}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ShiftController@update',
        'controller' => 'App\\Http\\Controllers\\ShiftController@update',
        'namespace' => NULL,
        'prefix' => '/shifts',
        'where' => 
        array (
        ),
        'as' => 'shifts.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shifts.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'shifts/{shift}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ShiftController@destroy',
        'controller' => 'App\\Http\\Controllers\\ShiftController@destroy',
        'namespace' => NULL,
        'prefix' => '/shifts',
        'where' => 
        array (
        ),
        'as' => 'shifts.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'shifts.assign' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'shifts/assign',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\ShiftController@assignShift',
        'controller' => 'App\\Http\\Controllers\\ShiftController@assignShift',
        'namespace' => NULL,
        'prefix' => '/shifts',
        'where' => 
        array (
        ),
        'as' => 'shifts.assign',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'users.toggle-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'users/toggle-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserManagementController@toggleUserStatus',
        'controller' => 'App\\Http\\Controllers\\UserManagementController@toggleUserStatus',
        'namespace' => NULL,
        'prefix' => '/users',
        'where' => 
        array (
        ),
        'as' => 'users.toggle-status',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'users.with-shifts' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'users/with-shifts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserManagementController@getUsersWithShifts',
        'controller' => 'App\\Http\\Controllers\\UserManagementController@getUsersWithShifts',
        'namespace' => NULL,
        'prefix' => '/users',
        'where' => 
        array (
        ),
        'as' => 'users.with-shifts',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'users.bulk-assign-shift' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'users/bulk-assign-shift',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserManagementController@bulkAssignShift',
        'controller' => 'App\\Http\\Controllers\\UserManagementController@bulkAssignShift',
        'namespace' => NULL,
        'prefix' => '/users',
        'where' => 
        array (
        ),
        'as' => 'users.bulk-assign-shift',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'users.get-users-by-department' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'users/get-users-by-department',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\UserManagementController@getUsersByDepartment',
        'controller' => 'App\\Http\\Controllers\\UserManagementController@getUsersByDepartment',
        'namespace' => NULL,
        'prefix' => '/users',
        'where' => 
        array (
        ),
        'as' => 'users.get-users-by-department',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uZc1Vh5ji4FGRkLu' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-leave',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:274:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:56:"function() {
    return \'Leave routes are working!\';
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009e20000000000000000";}";s:4:"hash";s:44:"aWlKHWt8mfy0EOASD/a1JAzMGNcuUXxa7Vq7tm9YTww=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::uZc1Vh5ji4FGRkLu',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::zpZyGaC99tHXemXt' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-controller',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@test',
        'controller' => 'App\\Http\\Controllers\\LeaveController@test',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::zpZyGaC99tHXemXt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fWrlMh2EO6gNHoXO' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-calendar-no-auth',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@calendar',
        'controller' => 'App\\Http\\Controllers\\LeaveController@calendar',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::fWrlMh2EO6gNHoXO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leave',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@index',
        'controller' => 'App\\Http\\Controllers\\LeaveController@index',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leave/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@create',
        'controller' => 'App\\Http\\Controllers\\LeaveController@create',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leave',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@store',
        'controller' => 'App\\Http\\Controllers\\LeaveController@store',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.calendar-leaves' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leave/calendar-leaves',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@calendarLeaves',
        'controller' => 'App\\Http\\Controllers\\LeaveController@calendarLeaves',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.calendar-leaves',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.calendar-leaves-data' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leave/calendar-leaves-data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@calendarLeavesData',
        'controller' => 'App\\Http\\Controllers\\LeaveController@calendarLeavesData',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.calendar-leaves-data',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.leave-bucket' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leave/leave-bucket',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@leaveBucket',
        'controller' => 'App\\Http\\Controllers\\LeaveController@leaveBucket',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.leave-bucket',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'leave/{leave}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@show',
        'controller' => 'App\\Http\\Controllers\\LeaveController@show',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leave/{leave}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@approve',
        'controller' => 'App\\Http\\Controllers\\LeaveController@approve',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.approve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leave/{leave}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@reject',
        'controller' => 'App\\Http\\Controllers\\LeaveController@reject',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'leave.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'leave/{leave}/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\LeaveController@cancel',
        'controller' => 'App\\Http\\Controllers\\LeaveController@cancel',
        'namespace' => NULL,
        'prefix' => '/leave',
        'where' => 
        array (
        ),
        'as' => 'leave.cancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.leave.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'approval-status/leave',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeaveApprovalController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeaveApprovalController@index',
        'namespace' => NULL,
        'prefix' => '/approval-status/leave',
        'where' => 
        array (
        ),
        'as' => 'approval-status.leave.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.leave.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'approval-status/leave/{leave}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeaveApprovalController@show',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeaveApprovalController@show',
        'namespace' => NULL,
        'prefix' => '/approval-status/leave',
        'where' => 
        array (
        ),
        'as' => 'approval-status.leave.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.leave.approve' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'approval-status/leave/{leave}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeaveApprovalController@approve',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeaveApprovalController@approve',
        'namespace' => NULL,
        'prefix' => '/approval-status/leave',
        'where' => 
        array (
        ),
        'as' => 'approval-status.leave.approve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'approval-status.leave.reject' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'approval-status/leave/{leave}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\LeaveApprovalController@reject',
        'controller' => 'App\\Http\\Controllers\\Admin\\LeaveApprovalController@reject',
        'namespace' => NULL,
        'prefix' => '/approval-status/leave',
        'where' => 
        array (
        ),
        'as' => 'approval-status.leave.reject',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'off-time-login.notify' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'off-time-login-notify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\OffTimeLoginController@notifySeniors',
        'controller' => 'App\\Http\\Controllers\\OffTimeLoginController@notifySeniors',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'off-time-login.notify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'off-time-login.clear' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'clear-off-time-modal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\OffTimeLoginController@clearModal',
        'controller' => 'App\\Http\\Controllers\\OffTimeLoginController@clearModal',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'off-time-login.clear',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dRwYxyFUbyNrcg2p' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => 'niremplogin',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:261:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:43:"function() {
    return \\redirect(\'/\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009fd0000000000000000";}";s:4:"hash";s:44:"XCACpwnlbLlexdCOLKy2MS+58RqQdSSYU7zqDPA7z5s=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::dRwYxyFUbyNrcg2p',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.register.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employee/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminController@showRegistrationForm',
        'controller' => 'App\\Http\\Controllers\\AdminController@showRegistrationForm',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.register.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.register' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employee/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminController@register',
        'controller' => 'App\\Http\\Controllers\\AdminController@register',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'niremptask',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@dashboard',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@dashboard',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.dashboard',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.tasks.filter' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employee/tasks/filter',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@getFilteredTasks',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@getFilteredTasks',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.tasks.filter',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.task.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employee/task/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@storeTask',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@storeTask',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.task.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.task.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'employee/task/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@editTask',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@editTask',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.task.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.task.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employee/task/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@updateTask',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@updateTask',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.task.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.send.daily.tasks.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employee/send-daily-tasks-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@sendDailyTasksEmail',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@sendDailyTasksEmail',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.send.daily.tasks.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::sIV8zD6iSj8SK6lV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'test-mail',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:663:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:444:"function() {
    try {
        \\Mail::raw(\'This is a test email from NIRCRM\', function($message) {
            $message->to(\'test@example.com\')
                    ->subject(\'Test Email\')
                    ->from(\\config(\'mail.from.address\'), \\config(\'mail.from.name\'));
        });
        return \'Test email sent successfully!\';
    } catch(\\Exception $e) {
        return \'Error sending test email: \' . $e->getMessage();
    }
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000a170000000000000000";}";s:4:"hash";s:44:"iHLf0cx+niMKqljPNk3sJ9tUqE8uJLVuIc9qDKj+8Lc=";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::sIV8zD6iSj8SK6lV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.task.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'employee/task/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@deleteTask',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@deleteTask',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.task.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.sync.google.sheets' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employee/sync-to-google-sheets',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@syncToGoogleSheets',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@syncToGoogleSheets',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.sync.google.sheets',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'employee.logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'employee/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@logout',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@logout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'employee.logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'biometric.register' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'biometric/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@registerBiometric',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@registerBiometric',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'biometric.register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'biometric.authenticate' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'biometric/authenticate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@authenticateBiometric',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@authenticateBiometric',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'biometric.authenticate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'biometric.challenge' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'biometric/challenge',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@getBiometricChallenge',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@getBiometricChallenge',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'biometric.challenge',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'biometric.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'biometric/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\EmployeeTaskController@deleteBiometricCredential',
        'controller' => 'App\\Http\\Controllers\\EmployeeTaskController@deleteBiometricCredential',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'biometric.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tasks.filter' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/tasks/filter',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminController@getFilteredTasks',
        'controller' => 'App\\Http\\Controllers\\AdminController@getFilteredTasks',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.tasks.filter',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.task.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/task/{id}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminController@editTask',
        'controller' => 'App\\Http\\Controllers\\AdminController@editTask',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.task.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.task.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/task/{id}/update',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminController@updateTask',
        'controller' => 'App\\Http\\Controllers\\AdminController@updateTask',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.task.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.task.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/task/{id}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\AdminController@deleteTask',
        'controller' => 'App\\Http\\Controllers\\AdminController@deleteTask',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'admin.task.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'recordings.all' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'allrecordingcall',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\RecordingController@allRecordings',
        'controller' => 'App\\Http\\Controllers\\RecordingController@allRecordings',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'recordings.all',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
