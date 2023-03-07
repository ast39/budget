<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller {

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function change(Request $request): RedirectResponse
    {
        app()->setLocale($request->lang);
        session()->put('locale', $request->lang);

        return redirect()->back();
    }
}
