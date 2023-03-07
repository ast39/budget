<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Payment\Credit\Store;
use App\Models\Manage\Credit;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CreditController extends BaseController {

    /**
     * @param int $credit_id
     * @return View
     */
    public function create(int $credit_id): View
    {
        $credit = Credit::findOrFail($credit_id);

        return view('payment.credit.create', [
            'credit' => $credit,
        ]);
    }

    /**
     * @param Store $request
     * @return RedirectResponse
     */
    public function store(Store $request): RedirectResponse
    {
        $data = $request->validated();
        $this->payment_credit_service->store($data);

        return redirect()->route('manage.credit.show', $data['credit_id']);
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $credit = Credit::with('owner')
            ->with('payments')
            ->where('owner_id', Auth::id())
            ->findOrFail($id);

        return view('manage.credit.show', [
            'credit'  => $credit,
        ]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->manage_credit_service->destroy($id);

        return redirect()->back();
    }
}
