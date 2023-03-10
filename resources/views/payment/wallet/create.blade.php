@php
    use App\Classes\Icons;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить транзакцию') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('payment.wallet.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="safeTitle" class="form-label">{{ __('Кошелек') }}</label>
                                <input type="text" readonly class="form-control" id="safeTitle" name="title" placeholder="Мой кошелек" value="{{ old('title') ?? $safe->title }}" aria-describedby="safeTitleHelp">
                                <div id="safeTitleHelp" class="form-text">Название Вашего кошелька</div>
                            </div>

                            <div class="mb-3">
                                <label for="paymentNote" class="form-label">{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</label>
                                <textarea class="form-control" id="paymentNote" name="note" placeholder="Описание транзакции" rows="5" aria-describedby="paymentNoteHelp">{{ old('note') }}</textarea>
                                <div id="paymentNoteHelp" class="form-text">Заметка о назначении транзакции</div>
                            </div>

                            <label for="creditPayment" class="form-label">{{ __('Сумма') }}</label>
                            <div class="input-group">
                                <input type="hidden" readonly name="wallet_id" value="{{ old('wallet_id') ?? $safe->wallet_id }}">
                                <input type="text" class="form-control" id="creditPayment" name="amount" placeholder="1234.56" value="{{ old('payment') ?? '' }}" aria-describedby="creditPaymentHelp">
                                <span class="input-group-text">руб.</span>
                            </div>
                            <div id="creditPaymentHelp" class="form-text mb-3">{{ __('Укажите сумму пополнения или снятия (с минусом)') }}</div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Добавить') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
