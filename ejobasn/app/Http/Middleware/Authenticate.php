<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/');
            }
        }

        // if (empty(session('role_id'))) {
        //     if ($request->ajax()) {
        //         return response('Unauthorized.', 401);
        //     } else {
        //         return redirect()->guest('auth/login');
        //     }
        // }
        
		$cms = \ConfigurationsModel::get();
		$configurations = array();
		foreach($cms as $cm){
			$configurations[$cm->name] = $cm->value;
		}
		$_ENV['configurations'] = $configurations;
		$pms = \PermissionsmatrixModel::with('permissions')->where('role_id', \Session::get('role_id'))->get();
		$roles = array();
		foreach($pms as $pm){
			@$roles[$pm->permission_id] = @$pm->permissions->name;
		}

		$_ENV['roles'] = $roles;
        

        return $next($request);
    }
}
