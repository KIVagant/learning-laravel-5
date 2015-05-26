<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if ($request->server('HTTP_HOST') == \Config::get('api.domain')
        || 0 === strpos($request->server('REQUEST_URI'), '/' . \Config::get('api.prefix'))) {

            return $next($request);
        }

		return parent::handle($request, $next);
	}

}
