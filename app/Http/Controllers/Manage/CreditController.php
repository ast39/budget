<?php

namespace App\Http\Controllers\Manage;

use App\Classes\Helper;
use App\Http\Controllers\BaseController;
use App\Models\Manage\Credit;
use App\Packages\Finance\Credit\Manager;
use App\Packages\Finance\PaymentType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Manage\Credit\Store as CreditStoreRequest;
use App\Http\Requests\Manage\Credit\Update as CreditUpdateRequest;
use Illuminate\Support\Facades\Auth;

class CreditController extends BaseController {

    public function test()
    {
        return view('manage.credit.test');
    }

    /**
     * Список кредитов с сальдо
     *
     * @param string|null $sortable
     * @return View
     */
    public function index(?string $sortable = null): View
    {
        $sortable = in_array($sortable, ['till', 'percent', 'payment', 'amount', 'overpay'])
            ? $sortable
            : 'till';

        $credits = Credit::with('owner')
            ->with('payments')
            ->where('owner_id', Auth::id())
            ->get()
            ->toArray();

        # Если кредитов больше 1, проведем сортировку
        if (count($credits) > 0) {

            foreach ($credits as $id => $credit) {
                $data = Manager::findPercent(Manager::setCredit(
                    $credit['title'],
                    PaymentType::ANNUITANT,
                    $credit['start_date'],
                    $credit['payment_date'],
                    null,
                    $credit['amount'],
                    $credit['percent'],
                    $credit['period'],
                    $credit['payment'],
                    $credit['payments'],
                ));

                $credits[$id]['overpay'] = $data->overpay ?? 0;
                $credits[$id]['data']    = $data;
                $credits[$id]['days_to'] = Helper::daysToPayment($credit['payment_date'], count($credit['payments']));
            }

            usort($credits, function($e1, $e2) use ($sortable) {

                return match($sortable) {

                    'till'    => $e1['days_to'] > $e2['days_to'],
                    'payment' => $e1['payment'] < $e2['payment'],
                    'overpay' => $e1['overpay'] < $e2['overpay'],
                    'amount'  => $e1['amount']  < $e2['amount'],

                    default   => $e1['percent'] < $e2['percent'],
                };
            });
        }

        return view('manage.credit.index', [
            'credits'  => $credits,
            'sortable' => $sortable,
        ]);
    }

    /**
     * Форма добавления кредита
     *
     * @return View
     */
    public function create(): View
    {
        return view('manage.credit.create');
    }

    /**
     * Логика сохранения кредита
     *
     * @param CreditStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CreditStoreRequest $request): RedirectResponse
    {
        return redirect()->route('manage.credit.show',
            $this->manage_credit_service->store($request->validated())
        );
    }

    /**
     * Форма просмотра кредита
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $credit = Credit::with('owner')
            ->with('payments')
            ->where('owner_id', Auth::id())
            ->findOrFail($id);

        $details = Manager::data(
            Manager::setCredit(
                $credit->title,
                PaymentType::ANNUITANT,
                $credit->start_date,
                $credit->payment_date,
                $credit->subject,
                $credit->amount,
                $credit->percent,
                $credit->period,
                $credit->payment,
                $credit->payments->toArray()
            )
        );

        return view('manage.credit.show', [
            'credit'  => $credit,
            'details' => $details,
        ]);
    }

    /**
     * Форма редактирования кредита
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('manage.credit.edit', [
            'credit' => Credit::where('owner_id', Auth::id())
                ->findOrFail($id)
        ]);
    }

    /**
     * Логика обновления кредита
     *
     * @param CreditUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CreditUpdateRequest $request, int $id): RedirectResponse
    {
        $this->manage_credit_service->update($id, $request->validated());

        return redirect()->route('manage.credit.show', $id);
    }

    /**
     * Логика удаления кредита
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->manage_credit_service->destroy($id);

        return redirect()->route('manage.credit.index');
    }
}
