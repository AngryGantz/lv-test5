<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;
use SleepingOwl\Admin\Admin;
use Request;

class AdminPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Sentinel::guest()) return redirect('login');
        if(Sentinel::inRole('admin')) return $next($request);
        $arrSlugs=str_getcsv($request->path(), '/');
        $method=Request::method();
        $user = Sentinel::check();
        if($method == 'DELETE')
        {
            $permit = $arrSlugs[0] . '.' . $arrSlugs[1] . '.delete';
            if ($user->hasAccess([$permit])) return $next($request);
            $content = 'Для удаления объекта необходимы установленные права <b>'. $permit .'</b> Для получения прав обратитесь к администратору';
            return Admin::view($content, 'Dashboard');
        }
        $permit=$arrSlugs[0];
        if(isset($arrSlugs[1])) $permit = $permit . '.' . $arrSlugs[1];
        if(isset($arrSlugs[2]) && ($arrSlugs[2] == "create")) $permit = $permit . '.' . $arrSlugs[2];
        if(isset($arrSlugs[3])) $permit = $permit . '.' . $arrSlugs[3];
        if ($user->hasAccess([$permit])) return $next($request);
        $content = 'Доступ в раздел <b>'. $permit .'</b> запрещен. Для получения прав обратитесь к администратору';
        return Admin::view($content, 'Dashboard');
    }
}
