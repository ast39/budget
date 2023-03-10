@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">

                    <div class="card-header">{{ __('Информация по расчету вклада') }}</div>

                    <div class="card-body">

                        <div class="accordion" id="accordionPanelsStayOpenExample">

                            <div class="accordion-item">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        {{ __('Параметры кредита') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">Название</th>
                                                <th scope="col">{{ $info->deposit->title ?? '' }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">{{ __('Сумма') }}</th>
                                                <td>{{ number_format($info->deposit->amount ?? '', 2, '.', ' ') }} {{ __('р.') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Процент') }}</th>
                                                <td>{{ number_format($info->deposit->percent ?? '', 2, '.', ' ') }}%</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Срок') }}</th>
                                                <td>{{ $info->deposit->period ?? '' }} {{ __('(в месяцах)') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Пополнения') }}</th>
                                                <td>{{ number_format($info->deposit->refill ?? '', 2, '.', ' ') }} {{ __('р.') }}</td>
                                            </tr>
                                            <tr><td colspan="2"></td></tr>
                                            <tr>
                                                <th scope="row">{{ __('Сумма пополнений') }}</th>
                                                <td><span class="text-danger">{{ number_format($info->refills ?? '', 2, '.', ' ') }} {{ __('р.') }}</span></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Заработок на процентах') }}</th>
                                                <td><span class="text-success">{{ number_format($info->profit ?? '', 2, '.', ' ') }} {{ __('р.') }}</span></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Снятые проценты') }}</th>
                                                <td><span class="text-success">{{ number_format($info->was_withdrawn ?? '', 2, '.', ' ') }} {{ __('р.') }}</span></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">{{ __('Итого к выплате') }}</th>
                                                <td><span class="text-primary">{{ number_format($info->to_withdraw ?? '', 2, '.', ' ') }} {{ __('р.') }}</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header shadow-sm" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        {{ __('График платежей') }}
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">

                                        <table class="table table-striped admin-table__adapt admin-table__instrument">
                                            <thead>
                                            <tr>
                                                <th class="text-center" scope="row">#</th>
                                                <th class="text-end">{{ __('Входящий баланс') }}</th>
                                                <th class="text-end">{{ __('Проценты') }}</th>
                                                <th class="text-end">{{ __('Пополнение') }}</th>
                                                <th class="text-end">{{ __('Сумма прироста') }}</th>
                                                <th class="text-end">{{ __('Текущий заработок') }}</th>
                                                <th class="text-end">{{ __('Снятые проценты') }}</th>
                                                <th class="text-end">{{ __('Исходящий баланс') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($info->details as $row)
                                                <tr>
                                                    <td data-label="#" class="text-center">{{ $loop->iteration }}</td>
                                                    <td data-label="Баланс" class="text-end">{{ number_format($row['inset_balance'], 0, '.', ' ') }} {{ __('р.') }}</td>
                                                    <td data-label="Проценты" class="text-end">{{ number_format($row['monthly_profit'], 0, '.', ' ') }} {{ __('р.') }}</td>
                                                    <td data-label="Пополнение" class="text-end">{{ number_format($row['monthly_refill'], 0, '.', ' ') }} {{ __('р.') }}</td>
                                                    <td data-label="Прирост" class="text-end">{{ number_format($row['monthly_deposit'], 0, '.', ' ') }} {{ __('р.') }}</td>
                                                    <td data-label="Заработок" class="text-end">{{ number_format($row['total_profit'], 0, '.', ' ') }} {{ __('р.') }}</td>
                                                    <td data-label="Снято" class="text-end">{{ number_format($row['was_withdrawn'], 0, '.', ' ') }} {{ __('р.') }}</td>
                                                    <td data-label="Остаток" class="text-end">{{ number_format($row['withdrawal_now'], 0, '.', ' ') }} {{ __('р.') }}</td>
                                                </tr>
                                            @empty
                                                <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Рассчет не удался') }}</div>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="d-grid gap-2 d-md-flex mt-3 justify-content-md-center">
                            <a href="{{ route('calculate.deposit.create') }}" class="btn btn-secondary me-md-2">Рассчитать новый вклад</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
