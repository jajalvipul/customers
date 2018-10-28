@extends('layouts.app')

@section('title', $customer->first_name . "'s Order History")

@section('content')
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th># of Products</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

            @foreach($customerOrders as $order)
                <tr>
                    <td> {{ date_format(date_create($order->date_created),'Y-m-d H:i:s') }}</td>
                    <td>{{ $order->productsCount }}</td>
                    <td>${{ money_format('%i', $order->total_inc_tax) }}</td>
                </tr>
            @endforeach

            {{-- Details go here --}}
            <tr>
                <td colspan="2">Lifetime Value</td>
                <td>${{ $lifeTimeValue }}</td>
            </tr>
        </tbody>
    </table>
@endsection
