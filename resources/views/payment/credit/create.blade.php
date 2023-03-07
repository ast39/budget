@php
    use App\Classes\Icons;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Добавить платеж') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('payment.credit.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="creditTitle" class="form-label">{{ __('Название') }}</label>
                                <input type="text" readonly class="form-control" id="creditTitle" name="title" placeholder="{{ __('Мой новый кредит') }}" value="{{ old('title') ?? $credit->title }}" aria-describedby="creditTitleHelp">
                                <div id="creditTitleHelp" class="form-text">{{ __('Лейбл Вашего кредита для простоты идентификации') }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="paymentNote" class="form-label">{!! Icons::get(Icons::NOTE) !!} {{ __('Описание') }}</label>
                                <textarea class="form-control" id="paymentNote" name="note" placeholder="{{ __('Заметка о кредите') }}" rows="5" aria-describedby="paymentNoteHelp">{{ old('note') }}</textarea>
                                <div id="paymentNoteHelp" class="form-text">Заметка о кредите</div>
                            </div>

                            <label for="creditPayment" class="form-label">{{ __('Платеж') }}</label>
                            <div class="input-group">
                                <input type="hidden" readonly name="credit_id" value="{{ old('credit_id') ?? $credit->credit_id }}">
                                <input type="text" readonly class="form-control" id="creditPayment" name="amount" placeholder="8654.09" value="{{ old('payment') ?? $credit->payment }}" aria-describedby="creditPaymentHelp">
                                <span class="input-group-text">руб.</span>
                            </div>
                            <div id="creditPaymentHelp" class="form-text mb-3">{{ __('Ваш ежемесячный платеж по кредиту') }}</div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary me-md-2">{{ __('Назад') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Внести') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
