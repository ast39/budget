@php
    use App\Packages\Finance\CreditSubject;
    use App\Packages\Finance\PaymentType;
    use App\Classes\Icons;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Рассчитать кредит') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('calculate.credit.store') }}">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="creditTitle" class="form-label">{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</label>
                                <input type="text" readonly class="form-control" id="creditTitle" name="title" placeholder="Мой новый кредит" value="Расчет от {{ date('d-m-Y H:i:s') }}">
                            </div>

                            <div class="mb-3">
                                <label for="creditSubject" class="form-label">{!! Icons::get(Icons::QUESTION) !!} {{ __('Что нужно рассчитать') }}</label>
                                <select class="form-select" id="creditSubject" name="subject" aria-label="Default select example" aria-describedby="creditSubjectBackHelp">
                                    <option {{ old('subject') == CreditSubject::AMOUNT  ? 'selected': '' }} value="{{ CreditSubject::AMOUNT }}">{{ __('Сумму кредита') }}</option>
                                    <option {{ old('subject') == CreditSubject::PERCENT ? 'selected': '' }} value="{{ CreditSubject::PERCENT }}">{{ __('Процент по кредиту') }}</option>
                                    <option {{ old('subject') == CreditSubject::PERIOD  ? 'selected': '' }} value="{{ CreditSubject::PERIOD }}">{{ __('Срок кредита') }}</option>
                                    <option {{ old('subject') == CreditSubject::PAYMENT ? 'selected': '' }} value="{{ CreditSubject::PAYMENT }}">{{ __('Ежемесячный платеж') }}</option>
                                </select>
                                <div id="creditSubjectHelp" class="form-text">{{ __('Выбранное поле заполнять не надо') }}</div>
                            </div>

                            <label for="creditAmount" class="form-label">{!! Icons::get(Icons::AMOUNT) !!} {{ __('Сумма') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" {{ old('subject') == null ? 'disabled' : (old('subject') == CreditSubject::AMOUNT  ? 'disabled' : '') }} class="form-control subjects" id="creditAmount" name="amount" placeholder="250000" value="{{ old('amount') }}">
                                <span class="input-group-text">р.</span>
                            </div>

                            <label for="creditPercent" class="form-label">{!! Icons::get(Icons::PERCENT) !!} {{ __('Процент') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" {{ old('subject') == CreditSubject::PERCENT  ? 'disabled' : '' }} class="form-control subjects" id="creditPercent" name="percent" placeholder="14.9" value="{{ old('percent') }}">
                                <span class="input-group-text">%</span>
                            </div>

                            <label for="creditPeriod" class="form-label">{!! Icons::get(Icons::PERIOD) !!} {{ __('Срок') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" {{ old('subject') == CreditSubject::PERIOD  ? 'disabled' : '' }} class="form-control subjects" id="creditPeriod" name="period" placeholder="36" value="{{ old('period') }}">
                                <span class="input-group-text">месяцев</span>
                            </div>

                            <label for="creditPayment" class="form-label">{!! Icons::get(Icons::PAYMENT) !!} {{ __('Платеж') }}</label>
                            <div class="input-group">
                                <input type="text" {{ old('subject') == CreditSubject::PAYMENT  ? 'disabled' : '' }} class="form-control subjects" id="creditPayment" name="payment" placeholder="8654.09" value="{{ old('payment') }}" aria-describedby="creditPaymentHelp">
                                <span class="input-group-text">руб.</span>
                            </div>
                            <div id="creditPaymentHelp" class="form-text mb-3">{{ __('Ваш ежемесячный платеж по кредиту') }}</div>

                            <div class="mb-3">
                                <label for="payment_type" class="form-label">{!! Icons::get(Icons::LIST) !!} {{ __('Тип платежа') }}</label>
                                <select class="form-select" id="payment_type" name="payment_type" aria-label="Default select example" aria-describedby="payment_typeHelp">
                                    <option {{ old('payment_type') == PaymentType::ANNUITANT  ? 'selected': '' }} value="{{ PaymentType::ANNUITANT }}">{{ __('Аннуитетный') }}</option>
                                    <option {{ old('payment_type') == PaymentType::DIFFERENCE ? 'selected': '' }} value="{{ PaymentType::DIFFERENCE }}">{{ __('Дифференцированный') }}</option>
                                </select>
                                <div id="payment_typeHelp" class="form-text">{{ __('Выберите тип платежа по кредиту') }}</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="submit" class="btn btn-primary">{{ __('Рассчитать') }}</button>
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

    @push('js')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#creditSubject').change(function() {
                    let subject = $(this).val();

                    $('.subjects').attr('disabled', false);

                    if (subject === '{{ CreditSubject::AMOUNT }}') {
                        $('#creditAmount').attr('disabled', true).val('');
                    }
                    if (subject === '{{ CreditSubject::PERCENT }}') {
                        $('#creditPercent').attr('disabled', true).val('');
                    }
                    if (subject === '{{ CreditSubject::PERIOD }}') {
                        $('#creditPeriod').attr('disabled', true).val('');
                    }
                    if (subject === '{{ CreditSubject::PAYMENT }}') {
                        $('#creditPayment').attr('disabled', true).val('');
                    }
                });
            });
        </script>
    @endpush
@endsection
