<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Redirect after a successful save — but answer with JSON when the request
     * came from the slide-in drawer (AJAX), so the panel can navigate itself.
     */
    protected function saved(Request $request, string $route, string $message, array $params = [])
    {
        if ($request->wantsJson()) {
            session()->flash('success', $message);

            return response()->json(['redirect' => route($route, $params)]);
        }

        return redirect()->route($route, $params)->with('success', $message);
    }
}
