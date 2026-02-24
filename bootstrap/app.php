<?php

use App\Http\Middleware\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    //web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
     //   health: '/up',
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ])
            //->statefulApi() TODO возможно добавить в маршруты web shop
            ->trustProxies(at: IpUtils::PRIVATE_SUBNETS)
            ->api(prepend: [
                JsonResponse::class,
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(static function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api*')) {
                return response()->json([
                    'ok' => false,
                    'message' => $e->getMessage(),
                ], $e->getStatusCode(), [], JSON_UNESCAPED_SLASHES);
            }
        });

        /*
         * Format unauthorized responses
         */
        $exceptions->render(static function (AuthenticationException $e, Request $request): \Illuminate\Http\JsonResponse | \Illuminate\Http\RedirectResponse {
            if ($request->is('api*')) {
                return response()->json([
                    'ok' => false,
                    'message' => __('Unauthenticated.'),
                ], 401, [], JSON_UNESCAPED_SLASHES);
            }

            return redirect()->guest(route('login'));
        });

        /*
         * Format validation errors
         */
        $exceptions->render(static function (ValidationException $e, Request $request): \Illuminate\Http\JsonResponse {
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage(),
                'errors' => array_map(static function (string $field, array $errors): array {
                    return [
                        'name' => $field,
                        'message' => implode(' ', $errors),
                    ];
                }, array_keys($e->errors()), $e->errors()),
            ], $e->status);
        });
    })->create();


