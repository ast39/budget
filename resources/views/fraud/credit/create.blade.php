@php
    use App\Classes\Helper;
    use App\Classes\Icons;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Проверить кредит') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('fraud.credit.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="creditTitle" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" readonly class="form-control" id="creditTitle" name="title" value="{{ __('Расчет от') }} {{ date('d-m-Y H:i:s') }}">
                            </div>

                            <label for="creditAmount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="creditAmount" name="amount" placeholder="250000" value="{{ old('amount') }}">
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>

                            <label for="creditPercent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="creditPercent" name="percent" placeholder="14.9" value="{{ old('percent') }}">
                                <span class="input-group-text">%</span>
                            </div>

                            <label for="creditPeriod" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="creditPeriod" name="period" placeholder="36" value="{{ old('period') }}">
                                <span class="input-group-text">{{ __('месяцев') }}</span>
                            </div>

                            <label for="creditPayment" class="form-label">{!! Icons::get(Icons::PAYMENT) !!} {{ __('Платеж') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="creditPayment" name="payment" placeholder="8654.09" value="{{ old('payment') }}" aria-describedby="creditPaymentHelp">
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                            <div id="creditPaymentHelp" class="form-text mb-3">{{ __('Ваш ежемесячный платеж по кредиту') }}</div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="submit" class="btn btn-primary">{{ __('Проверить') }}</button>
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
