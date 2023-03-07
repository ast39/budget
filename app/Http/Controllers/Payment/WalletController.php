<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Payment\Wallet\Store as WalletPaymentStoreRequest;
use App\Models\Manage\Wallet;
use App\Models\Payment\WalletPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class WalletController extends BaseController {

    /**
     * Форма добавления транзакции
     *
     * @param int $wallet_id
     * @return View
     */
    public function create(int $wallet_id): View
    {
        $safe = Wallet::findOrFail($wallet_id);

        return view('payment.wallet.create', [
            'safe' => $safe,
        ]);
    }

    /**
     * Логика сохранения транзакции
     *
     * @param WalletPaymentStoreRequest $request
     * @return RedirectResponse
     */
    public function store(WalletPaymentStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->payment_wallet_service->store($data);

        return redirect()->route('manage.wallet.show', $data['wallet_id']);
    }

    /**
     * Форма просмотра транзакции
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $payment = WalletPayment::with('inWallet')
            ->where('payment_id', $id)
            ->findOrFail($id);

        return view('payment.wallet.show', [
            'payment'  => $payment,
        ]);
    }

    /**
     * Логика удаления транзакции
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->payment_wallet_service->destroy($id);

        return redirect()->back();
    }
}
