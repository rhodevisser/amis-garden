<?php

namespace App\Http\Middleware;

use App\Models\Key;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegistrationKeyIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('registration_key_id')) {
            return redirect()->route('register.key')->withErrors([
                'key' => 'Please enter a valid registration key first.',
            ]);
        }

        $keyId = $request->session()->get('registration_key_id');
        $key = Key::find($keyId);

        if (!$key || !$key->isValid()) {
            $request->session()->forget('registration_key_id');

            return redirect()->route('register.key')->withErrors([
                'key' => 'Your registration key is no longer valid. Please try again.',
            ]);
        }

        return $next($request);
    }
}
