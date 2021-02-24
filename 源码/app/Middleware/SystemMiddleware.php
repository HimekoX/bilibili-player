<?php


namespace App\Middleware;

use App\Model\SystemUser;
use App\Utils\BasicUtil;
use Core\extend\exception\JSONException;
use Core\lib\socket\MiddlewareInterface;
use Illuminate\Database\Eloquent\Relations\Relation;

class SystemMiddleware implements MiddlewareInterface
{

    public function handle(): void
    {
        $user = BasicUtil::session('user');
        $route = BasicUtil::get('route');

        if (empty($user)) {
            throw new JSONException('验证数据失败,请重新登录', 1001);
        }

        $userData = SystemUser::query()->where('id', $user['id'])->first();

        if ($user['pass'] != $userData->pass) {
            throw new JSONException('账号密码发生了改变', 1001);
        }

        $findByUserRouters = SystemUser::with(['roles' => function (Relation $relation) {
            $relation->with(['routers' => function (Relation $relation) {
                $relation->where("status", 1)->orderBy("rank", "asc");
            }])->where("status", 1);
        }])->find($user['id']);

        if (!$findByUserRouters) {
            $_SESSION['user'] = null;
            throw new JSONException('账号出现了异常', 1001);
        }

        $routers = [];
        $roles = [];
        $menus = [];
        $routes = [];

        foreach ($findByUserRouters->roles as $role) {
            $roles[] = $role;
            foreach ($role->routers as $router) {

                if ($route == $router->path) {
                    $routes[] = $router->path;
                }

                if ($router->type == 1) {
                    $routers[trim($router->path, '/')] = $router->id;
                } else {
                    $menus[] = [
                        'id' => $router->id,
                        'title' => $router->name,
                        'name' => $router->path,
                        'icon' => $router->face,
                        'pid' => $router->pid
                    ];
                }
            }
        }

        if (count($routes) < 1) {
            throw new JSONException('未授权或出现异常', 100);
        }

        $userData = $userData->toArray();

        $userData['routers'] = $routers;
        $userData['roles'] = $roles;
        $userData['menus'] = $menus;

        $_SESSION['user'] = $userData;
    }
}