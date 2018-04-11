<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\DB;

class CheckRole
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
        $role_id = DB::table('model_has_roles')->select('role_id')->where('model_id',$request->user()->id)->first()->role_id;
        if($role_id != 2){
            return successResponseData(301,['用户无权限']);
        }
        return $next($request);
    }
}
