<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Manage\CreditController as ManageCredit;
use App\Http\Controllers\Manage\DepositController as ManageDeposit;
use App\Http\Controllers\Manage\WalletController as ManageWallet;

use App\Http\Controllers\Fraud\CreditController as FraudCredit;

use App\Http\Controllers\Payment\CreditController as PaymentCredit;
use App\Http\Controllers\Payment\WalletController as PaymentWallet;

use App\Http\Controllers\Calculate\CreditController as CalculateCredit;
use App\Http\Controllers\Calculate\DepositController as CalculateDeposit;

use App\Http\Controllers\TelegramController as Tg;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/ast11', function() {
    dd(\App\Models\User::all()->toArray());
});

Route::get('/', function() {
    return redirect('/manage/credit/index');
});

# Сменить язык
Route::get('locale/change/{lang}', [\App\Http\Controllers\LocaleController::class, 'change'])->name('locale.change');

Auth::routes();

# Блок кредитов
Route::group(['prefix' => 'manage/credit', 'middleware' => 'user.auth'], function() {

    # Прочитать все кредиты
    Route::get('index/{sortable?}', [ManageCredit::class, 'index'])->name('manage.credit.index');

    # Форма добавления кредита
    Route::get('create', [ManageCredit::class, 'create'])->name('manage.credit.create');

    # Логика добавления кредита
    Route::post('', [ManageCredit::class, 'store'])->name('manage.credit.store');

    # Прочитать кредит
    Route::get('{id}', [ManageCredit::class, 'show'])->name('manage.credit.show');

    # Форма редактирования кредита
    Route::get('{id}/edit', [ManageCredit::class, 'edit'])->name('manage.credit.edit');

    # Логика редактирования кредита
    Route::put('{id}', [ManageCredit::class, 'update'])->name('manage.credit.update');

    # Логика удаления кредита
    Route::delete('{id}', [ManageCredit::class, 'destroy'])->name('manage.credit.destroy');

});

# Блок платежей по кредитам
Route::group(['prefix' => 'payment/credit', 'middleware' => 'user.auth'], function() {

    # Форма добавления платежа
    Route::get('create/{credit_id}', [PaymentCredit::class, 'create'])->name('payment.credit.create');

    # Логика добавления платежа
    Route::post('', [PaymentCredit::class, 'store'])->name('payment.credit.store');

    # Прочитать платеж
    Route::get('{id}', [PaymentCredit::class, 'show'])->name('payment.credit.show');

    # Логика удаления платежа
    Route::delete('{id}', [PaymentCredit::class, 'destroy'])->name('payment.credit.destroy');

});

# Блок вкладов
Route::group(['prefix' => 'manage/deposit', 'middleware' => 'user.auth'], function() {

    # Прочитать все вкладф
    Route::get('', [ManageDeposit::class, 'index'])->name('manage.deposit.index');

    # Форма добавления вклада
    Route::get('create', [ManageDeposit::class, 'create'])->name('manage.deposit.create');

    # Логика добавления вклада
    Route::post('', [ManageDeposit::class, 'store'])->name('manage.deposit.store');

    # Прочитать вклад
    Route::get('{id}', [ManageDeposit::class, 'show'])->name('manage.deposit.show');

    # Форма редактирования вклада
    Route::get('{id}/edit', [ManageDeposit::class, 'edit'])->name('manage.deposit.edit');

    # Логика редактирования вклада
    Route::put('{id}', [ManageDeposit::class, 'update'])->name('manage.deposit.update');

    # Логика удаления вклада
    Route::delete('{id}', [ManageDeposit::class, 'destroy'])->name('manage.deposit.destroy');

});

# Блок кошельков
Route::group(['prefix' => 'manage/wallet', 'middleware' => 'user.auth'], function() {

    # Получить все кошельки
    Route::get('', [ManageWallet::class, 'index'])->name('manage.wallet.index');

    # Форма добавления кошелька
    Route::get('create', [ManageWallet::class, 'create'])->name('manage.wallet.create');

    # Логика добавления кошелька
    Route::post('', [ManageWallet::class, 'store'])->name('manage.wallet.store');

    # Информация о кошельке
    Route::get('{wallet}', [ManageWallet::class, 'show'])->name('manage.wallet.show');

    # Форма редактирования кошелька
    Route::get('{wallet}/edit', [ManageWallet::class, 'edit'])->name('manage.wallet.edit');

    # Логика редактирования кошелька
    Route::put('{wallet}', [ManageWallet::class, 'update'])->name('manage.wallet.update');

    # Логика удаления кошелька
    Route::delete('{wallet}', [ManageWallet::class, 'destroy'])->name('manage.wallet.destroy');

});

# Блок транзакций кошельков
Route::group(['prefix' => 'payment/wallet', 'middleware' => 'user.auth'], function() {

    # Форма добавления транзакции
    Route::get('create/{wallet_id}', [PaymentWallet::class, 'create'])->name('payment.wallet.create');

    # Логика добавления транзакции
    Route::post('', [PaymentWallet::class, 'store'])->name('payment.wallet.store');

    # Прочитать транзакцию
    Route::get('{id}', [PaymentWallet::class, 'show'])->name('payment.wallet.show');

    # Логика удаления транзакции
    Route::delete('{id}', [PaymentWallet::class, 'destroy'])->name('payment.wallet.destroy');

});

# Блок проверки условий кредита
Route::group(['prefix' => 'check/credit'], function() {

    # Форма добавления расчета
    Route::get('create', [FraudCredit::class, 'create'])->name('fraud.credit.create');

    # Логика сохранения вводных данных
    Route::post('', [FraudCredit::class, 'store'])->name('fraud.credit.store');

    # Посмотреть расчет
    Route::get('{id}', [FraudCredit::class, 'show'])->name('fraud.credit.show');

});

# Блок расчетов кредита
Route::group(['prefix' => 'calculate/credit'], function() {

    # Форма добавления расчета
    Route::get('create', [CalculateCredit::class, 'create'])->name('calculate.credit.create');

    # Логика сохранения вводных данных
    Route::post('', [CalculateCredit::class, 'store'])->name('calculate.credit.store');

    # Посмотреть расчет
    Route::get('{id}', [CalculateCredit::class, 'show'])->name('calculate.credit.show');

});

# Блок расчетов вклада
Route::group(['prefix' => 'calculate/deposit'], function() {

    # Форма добавления расчета
    Route::get('create', [CalculateDeposit::class, 'create'])->name('calculate.deposit.create');

    # Логика сохранения вводных данных
    Route::post('', [CalculateDeposit::class, 'store'])->name('calculate.deposit.store');

    # Посмотреть расчет
    Route::get('{id}', [CalculateDeposit::class, 'show'])->name('calculate.deposit.show');

});

# Блок телеграм
Route::group(['prefix' => 'telegram', 'middleware' => 'user.auth'], function() {

    # Сальдо по кредитам
    Route::post('webhook', [Tg::class, 'hook'])->name('tg.hook');

});
