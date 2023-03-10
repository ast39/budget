@php
    use App\Classes\Helper;
    use App\Classes\Icons;
@endphp

@extends('layouts.app')

@section('title', __('Список кредитов'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">{{ __('Список кредитов') }}</div>

                    <div class="card-body">

                        <div class="card-title">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link {{ $sortable == 'till' ? 'active' : '' }}" href="{{ route('manage.credit.index', 'till') }}" >{{ __('Дней до платежа') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $sortable == 'percent' ? 'active' : '' }}" href="{{ route('manage.credit.index', 'percent') }}">{{ __('По проценту') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $sortable == 'amount' ? 'active' : '' }}" href="{{ route('manage.credit.index', 'amount') }}">{{ __('По сумме') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $sortable == 'payment' ? 'active' : '' }}" href="{{ route('manage.credit.index', 'payment') }}">{{ __('По платежу') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $sortable == 'overpay' ? 'active' : '' }}" href="{{ route('manage.credit.index', 'overpay') }}" >{{ __('По переплате') }}</a>
                                </li>
                            </ul>
                        </div>

                        <table class="table table-striped admin-table__adapt admin-table__instrument">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{!! Icons::get(Icons::TITLE) !!} {{ __('Название') }}</th>
                                    <th>{!! Icons::get(Icons::BANK) !!} {{ __('Банк') }}</th>
                                    <th class="text-center">{!! Icons::get(Icons::CALENDAR_DAY) !!} {{ __('Дней до платежа') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::PAYMENT) !!} {{ __('Сумма платежа') }}</th>
                                    <th class="text-end">{{ __('Выплачено долга') }}</th>
                                    <th class="text-end">{{ __('Остаток долга') }}</th>
                                    <th class="text-end">{!! Icons::get(Icons::TOOLS) !!} {{ __('Действия') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($credits as $credit)
                                    <tr>
                                        <td data-label="#"><b>{{ $loop->iteration }}</b></td>
                                        <td data-label="{{ __('Название') }}"><a class="text-decoration-none text-primary" href="{{ route('manage.credit.show', $credit['credit_id']) }}">{{ $credit['title'] ?? '' }}</a></td>
                                        <td data-label="{{ __('Банк') }}">{{ $credit['creditor'] ?? '' }}</td>

                                        <td data-label="{{ __('Дней до платежа') }}" class="text-center {{ $credit['days_to'] <= 5 ? 'text-danger' : ($credit['days_to'] <= 10 ? 'text-warning' : 'text-success') }}">
                                            {{ $credit['days_to'] < 0 ? __('Просрочен') : ($credit['days_to'] > 0 ? $credit['days_to'] . Helper::number($credit['days_to'] ?? 0, [__('день'), __('дня'), __('дней')]) : __('Сегодня')) }}
                                        </td>
                                        <td data-label="{{ __('Сумма платежа') }}" class="text-end">{{ number_format($credit['payment'], 2, '.', ' ')}} {{ __('р.') }}</td>
                                        <td data-label="{{ __('Выплачено долга') }}" class="text-end">{{ number_format($credit['data']->balance_payed, 0, '.', ' ') }} {{ __('р.') }}</td>
                                        <td data-label="{{ __('Остаток') }}" class="text-end">{{ number_format($credit['data']->balance_owed, 0, '.', ' ') }} {{ __('р.') }}</td>
                                        <td data-label="{{ __('Действия') }}" class="text-end">
                                            <form method="post" action="{{ route('manage.credit.destroy', $credit['credit_id']) }}">
                                                @csrf
                                                @method('DELETE')

                                                <a title="{{ __('Открыть') }}" href="{{ route('manage.credit.show', $credit['credit_id']) }}" class="btn btn-primary"><i class="bi bi-text-center" style="font-size: 1rem"></i></a>
                                                <a title="{{ __('Изменить') }}" href="{{ route('manage.credit.edit', $credit['credit_id']) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                <button type="submit" title="{{ __('Удалить') }}" onclick="return confirm('{{ __('Вы уверены, что хотите удалить кредит?') }}')" class="btn btn-danger"><i class="bi bi-trash" style="font-size: 1rem"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('У вас нет текущих кредитов') }}</div>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('manage.credit.create') }}" class="btn btn-primary">{{ __('Добавить кредит') }}</a>
                        </div>

                        <table class="table table-striped mt-3 admin-table__adapt admin-table__instrument">
                            <thead>
                            <tr>
                                <th class="text-center">{{ __('Всего кредитов') }}</th>
                                <th class="text-center">{{ __('Сумма кредитов') }}</th>
                                <th class="text-center">{{ __('Выплачено долга') }}</th>
                                <th class="text-center">{{ __('Остаток долга') }}</th>
                                <th class="text-center">{{ __('Платежей в месяц') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td data-label="{{ __('Всего кредитов') }}" class="text-center">{{ count($credits ?: []) }}</td>
                                <td data-label="{{ __('Сумма кредитов') }}" class="text-center">{{ number_format(array_sum(array_map(function($e) {return $e['amount'];}, $credits)), 0, '.', ' ') }} {{ __('руб.') }}</td>
                                <td data-label="{{ __('Выплачено долга') }}" class="text-center">{{ number_format(array_sum(array_map(function($e) {return $e['data']->balance_payed;}, $credits)), 0, '.', ' ') }} {{ __('руб.') }}</td>
                                <td data-label="{{ __('Остаток долга') }}" class="text-center">{{ number_format(array_sum(array_map(function($e) {return $e['data']->balance_owed;}, $credits)), 0, '.', ' ') }} {{ __('руб.') }}</td>
                                <td data-label="{{ __('Платежей в месяц') }}" class="text-center">{{ number_format(array_sum(array_map(function($e) {return $e['payment'];}, $credits)), 0, '.', ' ') }} {{ __('руб.') }}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
