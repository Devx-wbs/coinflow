<?php

use App\Http\Middleware\CheckRoutePermission;
use App\Http\Middleware\RedirectAdminFromFrontend;
use App\Models\SystemLog;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',

        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'route.permission' => CheckRoutePermission::class,
            'plugin.download.secure' => \App\Http\Middleware\PluginDownloadSecurity::class,
            'redirect.admin.from.frontend' => RedirectAdminFromFrontend::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (Throwable $e) {

            // ✅ Check toggle ON/OFF
            if (!SystemLog::systemLogsEnabled()) {
                return;
            }

            // ❌ Skip 404 errors
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return;
            }

            // ✅ Save error into DB
            SystemLog::create([
                'level'   => 'error',
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'url'     => request()->fullUrl(),
                'method'  => request()->method(),
                'user_id' => auth()->check() ? auth()->id() : null,
                'ip'      => request()->ip(),
            ]);
        });
    })->create();
