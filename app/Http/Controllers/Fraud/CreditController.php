<?php

namespace App\Http\Controllers\Fraud;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Fraud\Credit\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CreditController extends BaseController {

    /**
     * @return View
     */
    public function create(): View
    {
        return view('fraud.credit.create');
    }

    /**
     * @param Store $request
     * @return RedirectResponse
     */
    public function store(Store $request): RedirectResponse
    {
        return redirect()->route('fraud.credit.show',
            $this->fraud_credit_service->store($request->validated())
        );
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        return view('fraud.credit.show', [
            'checker' => $this->fraud_credit_service->calculate($id)
        ]);
    }

}
