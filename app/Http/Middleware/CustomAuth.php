<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use App\Model\Admin;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        $path = $request->path();
        if ($path == "setup" || $path == "databasesetup" && !$this->alreadyInstalled()) {
            
        }elseif(!$this->alreadyInstalled()){
            return redirect("/setup");
        }else
        if($path == "autoFestivalNotification"){
            
        }elseif ($path == "login" && Session::has('userid')) {
            return redirect("/");
        }elseif ($path != "login" && !Session::has('userid')) {
            return redirect("/login");
        }
        return $next($request);
        
    }
    
    public function alreadyInstalled()
    {
        return (file_exists(public_path('install')) && file_get_contents(public_path('install')) == "nyota");
    }
    
}
