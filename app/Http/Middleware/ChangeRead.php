<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\h_blog;

class ChangeRead
{
    /**
     * 阅读量前置中间键
     */
    public function handle($request, Closure $next)
    {
        if(empty(session('read'))){
            return $next($request);
        }else{
            $read = session('read');
            if ((time()-$read['time'])>=300){
                $res = h_blog::changRead($read['id']);
                if($res){
                    $request->session()->forget('read');
                }
            }else{
                $request->session()->forget('read');
            }
            return $next($request);
        }

    }
}
