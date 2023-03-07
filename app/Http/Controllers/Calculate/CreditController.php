<?php

namespace App\Http\Controllers\Calculate;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Calculate\Credit\Store;
use App\Packages\Finance\Exceptions\RequestDataException;
use App\Packages\Finance\Exceptions\ResponseDataException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CreditController extends BaseController {

    /**
     * @return View
     */
    public function create(): View
    {
        return view('calculate.credit.create');
    }

    /**
     * @param Store $request
     * @return RedirectResponse
     */
    public function store(Store $request): RedirectResponse
    {
        return redirect()->route('calculate.credit.show',
            $this->calculate_credit_service->store($request->validated())
        );
    }

    /**
     * @param int $id
     * @return View
     * @throws RequestDataException
     * @throws ResponseDataException
     */
    public function show(int $id): View
    {
        return view('calculate.credit.show', [
            'info' => $this->calculate_credit_service->calculate($id)
        ]);
    }

}
