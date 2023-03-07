@php
    use App\Packages\Finance\PlowBack;
    use App\Classes\Helper;
    use App\Classes\Icons;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Изменить вклад') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('manage.deposit.update', $deposit->deposit_id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="depositTitle" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="depositTitle" name="title" placeholder="Мой новый вклад" value="{{ $deposit->title }}" aria-describedby="depositTitleHelp">
                                <div id="depositTitleHelp" class="form-text">Лэйбл Вашего вклада для простоты идентификации</div>
                            </div>

                            <div class="mb-3">
                                <label for="depositDepositor" class="form-label">{!! Icons::get(Icons::BANK) !!} {{ __('Обьект инвестиции') }}</label>
                                <input type="text" class="form-control" id="depositDepositor" name="depositor" placeholder="Новый банк" value="{{ $deposit->depositor }}" aria-describedby="depositDepositorHelp">
                                <div id="depositDepositorHelp" class="form-text">Куда вы вложиил средства</div>
                            </div>

                            <div class="mb-3">
                                <label for="depositStart" class="form-label">{!! Icons::get(Icons::CALENDAR_MONTH) !!} {{ __('День открытия вклада') }}</label>
                                <input type="date" class="form-control" id="depositStart" name="start_date" value="{{ date('Y-m-d', $deposit->start_date) }}" />
                            </div>

                            <label for="depositAmount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="depositAmount" name="amount" placeholder="250000" value="{{ $deposit->amount }}">
                                <span class="input-group-text">руб.</span>
                            </div>

                            <label for="depositPercent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="depositPercent" name="percent" placeholder="14.9" value="{{ $deposit->percent }}">
                                <span class="input-group-text">%</span>
                            </div>

                            <label for="depositPeriod" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="depositPeriod" name="period" placeholder="36" value="{{ $deposit->period }}">
                                <span class="input-group-text">месяцев</span>
                            </div>

                            <label for="depositRefill" class="form-label">{!! Icons::get(Icons::PAYMENT) !!} {{ __('Пополнение') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="depositRefill" name="refill" placeholder="10000" value="{{ $deposit->refill }}" aria-describedby="depositRefillHelp">
                                <span class="input-group-text">руб.</span>
                            </div>
                            <div id="depositRefillHelp" class="form-text mb-3">{{ __('Сумма ежемесячного пополнения вклада') }}</div>

                            <div class="mb-3">
                                <label for="depositPlowBack" class="form-label">{!! Icons::get(Icons::CAPITALIZATION) !!} {{ __('Капитализация') }}</label>
                                <select class="form-select" id="depositPlowBack" name="plow_back" aria-label="Default select example" aria-describedby="depositPlowBackHelp">
                                    <option {{ $deposit->plow_back == PlowBack::WITHOUT ? 'selected': '' }} value="{{ PlowBack::WITHOUT }}">{{ __('При закрытии кредита') }}</option>
                                    <option {{ $deposit->plow_back == PlowBack::DAILY   ? 'selected': '' }} value="{{ PlowBack::DAILY }}">{{ __('Ежедневно') }}</option>
                                    <option {{ $deposit->plow_back == PlowBack::WEEKLY  ? 'selected': '' }} value="{{ PlowBack::WEEKLY }}">{{ __('Еженедельно') }}</option>
                                    <option {{ $deposit->plow_back == PlowBack::MONTHLY ? 'selected': '' }} value="{{ PlowBack::MONTHLY }}">{{ __('Раз в месяц') }}</option>
                                    <option {{ $deposit->plow_back == PlowBack::YEARLY  ? 'selected': '' }} value="{{ PlowBack::YEARLY }}">{{ __('Раз в год') }}</option>
                                </select>
                                <div id="depositPlowBackHelp" class="form-text">{{ __('Период капитализации процентов') }}</div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" {{ $deposit->withdrawal > 0 ? 'checked' : '' }} class="form-check-input" id="depositWd" name="withdrawal" aria-describedby="depositWdHelp">
                                <label class="form-check-label" for="depositWd">{!! Icons::get(Icons::WITHDRAWAL) !!}  {{ __('Снимать проценты') }}</label>
                                <div id="depositWdHelp" class="form-text">{{ __('Снимать ежемесячно проценты или капитализировать во вклад') }}</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('manage.deposit.index') }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Сохранить') }}</button>
                            </div>
                        </form>

                        @if(count($errors) > 0)
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
