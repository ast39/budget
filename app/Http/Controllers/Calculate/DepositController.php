<?php

namespace App\Http\Controllers\Calculate;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Calculate\Deposit\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Packages\Finance\Exceptions\RequestDataException;

class DepositController extends BaseController {

    /**
     * @return View
     */
    public function create(): View
    {
        return view('calculate.deposit.create');
    }

    /**
     * @param Store $request
     * @return RedirectResponse
     */
    public function store(Store $request): RedirectResponse
    {
        return redirect()->route('calculate.deposit.show',
            $this->calculate_deposit_service->store($request->validated())
        );
    }

    /**
     * @param int $id
     * @return View
     * @throws RequestDataException
     */
    public function show(int $id): View
    {
        return view('calculate.deposit.show', [
            'info' => $this->calculate_deposit_service->calculate($id)
        ]);
    }

}
