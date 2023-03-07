<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Models\Manage\Deposit;
use App\Packages\Finance\Deposit\Manager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Manage\Deposit\Store as DepositStoreRequest;
use App\Http\Requests\Manage\Deposit\Update as DepositUpdateRequest;
use Illuminate\Support\Facades\Auth;

class DepositController extends BaseController {

    /**
     * Список вкладов с сальдо
     *
     * @return View
     */
    public function index(): View
    {
        $deposits = Deposit::with('owner')
            ->where('owner_id', Auth::id())
            ->get()
            ->toArray();

        $result = [];
        if ($deposits > 0) {
            foreach ($deposits as $deposit) {

                $result[] = Manager::calculate(
                    Manager::setDeposit(
                        $deposit['title'],
                        $deposit['amount'],
                        $deposit['percent'],
                        $deposit['period'],
                        $deposit['refill'],
                        $deposit['plow_back'],
                        $deposit['withdrawal'],
                        $deposit['start_date'],
                        $deposit['deposit_id'],
                    )
                );
            }
        }

        return view('manage.deposit.index', [
            'deposits' => $result,
        ]);
    }

    /**
     * Форма создания нового вклада
     *
     * @return View
     */
    public function create(): View
    {
        return view('manage.deposit.create');
    }

    /**
     * Логика сохранения вклада
     *
     * @param DepositStoreRequest $request
     * @return RedirectResponse
     */
    public function store(DepositStoreRequest $request): RedirectResponse
    {
        return redirect()->route('manage.deposit.show',
            $this->manage_deposit_service->store($request->validated())
        );
    }

    /**
     * Форма просмотра вклада
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $deposit = Deposit::with('owner')
            ->where('owner_id', Auth::id())
            ->findOrFail($id);

        $details = Manager::calculate(
            Manager::setDeposit(
                $deposit->title,
                $deposit->amount,
                $deposit->percent,
                $deposit->period,
                $deposit->refill,
                $deposit->plow_back,
                ($deposit->withdrawal ?? 0) == 1,
                $deposit->start_date,
            )
        );

        return view('manage.deposit.show', [
            'deposit' => $deposit,
            'details' => $details,
        ]);
    }

    /**
     * Форма редактирования вклада
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('manage.deposit.edit', [
            'deposit' => Deposit::where('owner_id', Auth::id())
                ->findOrFail($id)
        ]);
    }

    /**
     * Логика обновления вклада
     *
     * @param DepositUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(DepositUpdateRequest $request, int $id): RedirectResponse
    {
        $this->manage_deposit_service->update($id, $request->validated());

        return redirect()->route('manage.deposit.show', $id);
    }

    /**
     * Логика удаления вклада
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->manage_deposit_service->destroy($id);

        return redirect()->route('manage.deposit.index');
    }
}
