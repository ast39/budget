<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Http\Filters\WalletFilter;
use App\Models\Manage\Wallet as WalletModel;
use App\Packages\Finance\Safe\Manager as WalletManager;
use App\Http\Requests\Manage\Wallet\{
    Store  as WalletStoreRequest,
    Update as WalletUpdateRequest,
    Filter as WalletFilterRequest,
};
use Illuminate\{Contracts\Container\BindingResolutionException,
    Contracts\View\View,
    Http\RedirectResponse,
    Support\Facades\Auth};

/**
 * Контроллер работы с кошельками
 */
class WalletController extends BaseController {

    /**
     * Список кошельков с сальдо
     *
     * @param WalletFilterRequest $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(WalletFilterRequest $request): View
    {
        $data = $request->validated();

        $filter = app()->make(WalletFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $safes_all = WalletModel::with('owner')
            ->with('payments')
            ->where('owner_id', Auth::id())
            ->get()
            ->toArray();

        $safes_page = WalletModel::with('owner')
            ->with('payments')
            ->where('owner_id', Auth::id())
            ->filter($filter)
            ->paginate(config('user.limits.wallet'));

        return view('manage.wallet.index', [
            'wallets' => $safes_page,
            'balance' => $safes_all,
        ]);
    }

    /**
     * Форма создания нового кошелька
     *
     * @return View
     */
    public function create(): View
    {
        return view('manage.wallet.create');
    }

    /**
     * Логика сохранения кошелька
     *
     * @param WalletStoreRequest $request
     * @return RedirectResponse
     */
    public function store(WalletStoreRequest $request): RedirectResponse
    {
        return redirect()->route('manage.wallet.show',
            $this->manage_wallet_service->store($request->validated())
        );
    }

    /**
     * Форма просмотра кошелька
     *
     * @param WalletModel $wallet
     * @return View
     */
    public function show(WalletModel $wallet): View
    {
        $details = WalletManager::calculate(
            WalletManager::setSafe(
                $wallet->title,
                $wallet->amount,
                $wallet->payments->toArray(),
            )
        );

        return view('manage.wallet.show', [
            'wallet'  => $wallet,
            'details' => $details,
        ]);
    }

    /**
     * Форма редактирования кошелька
     *
     * @param WalletModel $wallet
     * @return View
     */
    public function edit(WalletModel $wallet): View
    {
        return view('manage.wallet.edit', [
            'wallet' => $wallet
        ]);
    }

    /**
     * Логика обновления кошелька
     *
     * @param WalletUpdateRequest $request
     * @param WalletModel $wallet
     * @return RedirectResponse
     */
    public function update(WalletUpdateRequest $request, WalletModel $wallet): RedirectResponse
    {
        $this->manage_wallet_service->update($wallet, $request->validated());

        return redirect()->route('manage.wallet.show', $wallet->wallet_id);
    }

    /**
     * Логика удаления кошелька
     *
     * @param WalletModel $wallet
     * @return RedirectResponse
     */
    public function destroy(WalletModel $wallet): RedirectResponse
    {
        $this->manage_wallet_service->destroy($wallet);

        return redirect()->route('manage.wallet.index');
    }
}
