@php
    use App\Packages\Finance\PlowBack;
    use App\Classes\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Новый вклад'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить вклад') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('manage.deposit.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="depositTitle" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" class="form-control" id="depositTitle" name="title" placeholder="Мой новый вклад" value="{{ old('title') }}" aria-describedby="depositTitleHelp">
                                <div id="depositTitleHelp" class="form-text">Лэйбл Вашего вклада для простоты идентификации</div>
                                @error('title')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="depositDepositor" class="form-label">{!! Icons::get(Icons::BANK) !!} {{ __('Обьект инвестиции') }}</label>
                                <input type="text" class="form-control" id="depositDepositor" name="depositor" placeholder="Новый банк" value="{{ old('depositor') }}" aria-describedby="depositDepositorHelp">
                                <div id="depositDepositorHelp" class="form-text">Куда вы вложиил средства</div>
                                @error('depositor')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="depositStart" class="form-label">{!! Icons::get(Icons::CALENDAR_MONTH) !!} {{ __('День открытия вклада') }}</label>
                                <input type="date" class="form-control" id="depositStart" name="start_date" value="{{ old('start_date') }}" />
                                @error('start_date')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="depositAmount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="depositAmount" name="amount" placeholder="250000" value="{{ old('amount') }}">
                                <span class="input-group-text">руб.</span>
                            </div>
                            @error('amount')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror

                            <label for="depositPercent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="depositPercent" name="percent" placeholder="14.9" value="{{ old('percent') }}">
                                <span class="input-group-text">%</span>
                            </div>
                            @error('percent')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror

                            <label for="depositPeriod" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="depositPeriod" name="period" placeholder="36" value="{{ old('period') }}">
                                <span class="input-group-text">месяцев</span>
                            </div>
                            @error('period')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror

                            <label for="depositRefill" class="form-label">{!! Icons::get(Icons::PAYMENT) !!} {{ __('Пополнение') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="depositRefill" name="refill" placeholder="10000" value="{{ old('refill') }}" aria-describedby="depositRefillHelp">
                                <span class="input-group-text">руб.</span>
                            </div>
                            <div id="depositRefillHelp" class="form-text mb-3">{{ __('Сумма ежемесячного пополнения вклада') }}</div>
                            @error('refill')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror

                            <div class="mb-3">
                                <label for="depositPlowBack" class="form-label">{!! Icons::get(Icons::CAPITALIZATION) !!} {{ __('Капитализация') }}</label>
                                <select class="form-select" id="depositPlowBack" name="plow_back" aria-label="Default select example" aria-describedby="depositPlowBackHelp">
                                    <option {{ old('plow_back') == PlowBack::WITHOUT ? 'selected': '' }} value="{{ PlowBack::WITHOUT }}">{{ __('При закрытии кредита') }}</option>
                                    <option {{ old('plow_back') == PlowBack::DAILY   ? 'selected': '' }} value="{{ PlowBack::DAILY }}">{{ __('Ежедневно') }}</option>
                                    <option {{ old('plow_back') == PlowBack::WEEKLY  ? 'selected': '' }} value="{{ PlowBack::WEEKLY }}">{{ __('Еженедельно') }}</option>
                                    <option {{ old('plow_back') == PlowBack::MONTHLY ? 'selected': '' }} value="{{ PlowBack::MONTHLY }}">{{ __('Раз в месяц') }}</option>
                                    <option {{ old('plow_back') == PlowBack::YEARLY  ? 'selected': '' }} value="{{ PlowBack::YEARLY }}">{{ __('Раз в год') }}</option>
                                </select>
                                <div id="depositPlowBackHelp" class="form-text">{{ __('Период капитализации процентов') }}</div>
                                @error('plow_back')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" {{ old('withdrawal') > 0 ? 'checked' : '' }} class="form-check-input" id="depositWd" name="withdrawal" aria-describedby="depositWdHelp">
                                <label class="form-check-label" for="depositWd">{!! Icons::get(Icons::WITHDRAWAL) !!} {{ __('Снимать проценты') }}</label>
                                <div id="depositWdHelp" class="form-text">{{ __('Снимать ежемесячно проценты или капитализировать во вклад') }}</div>
                                @error('withdrawal')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ route('manage.deposit.index') }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Добавить') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
