@extends('layouts.app')

@section('title', 'Customers')

@section('content')

    @if(session()->has('status'))
        <div class="alert alert-warning" style="text-align: left">;
        {{ session()->get('status') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th># of Orders</th>
                <th>View Orders</th>
            </tr>
        </thead>
            <tbody>
                {{-- Details go here --}}
                @foreach($customers as $customer)
                <tr>
                    <td> {{ $customer->first_name . " " . $customer->last_name }} </td>
                    <td>{{ $customer->total_orders }}</td>
                    @if ($customer->total_orders > 0)
                        <td><a href="/customers/{{$customer->customer_id}}">View Order details</a></td>
                    @else
                        <td></td>
                    @endif
                </tr>
                @endforeach

            </tbody>
    </table>
@endsection
