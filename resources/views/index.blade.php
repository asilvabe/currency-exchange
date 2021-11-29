@extends('layouts.app')
@section('main')
    <div class="flex flex-col bg-white rounded shadow-lg p-12 mt-2">
        <img class="self-center" src="{{ asset('images/logo.png') }}" alt="siteLogo" width="400">

        <form class="flex flex-row" action="{{ route('convert') }}" method="POST">
            @csrf

            <div class="flex flex-col">
                <label class="font-semibold text-xs" for="amount">Amount</label>
                <input class="flex items-center h-12 px-4 w-48 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2 @error('amount') border-2 border-red-500 @enderror" type="number" name="amount" value="{{ old('amount') }}">
                @error('amount')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>
    
            <div class="flex flex-col ml-1">
                <label class="font-semibold text-xs" for="from">From</label>
                @include('layouts.currencies-select', ['name' => 'from'])
            </div>
    
            <div class="flex flex-col ml-1">
                <label class="font-semibold text-xs" for="to">To</label>
                @include('layouts.currencies-select', ['name' => 'to'])
            </div>
    
            <button type="submit" class="flex items-center justify-center self-end h-12 px-6 w-32 bg-blue-600 rounded font-semibold text-sm text-blue-100 hover:bg-blue-700 ml-2">Convert</button>

        </form>

        @isset($result)
            <div class="flex flex-row mt-3">
                <span class="text-xl self-end">{{ $amount }} {{ $from }} = </span>
                <span class="text-4xl font-bold ml-2">{{ $result }} {{ $to }}</span>
            </div>
        @endisset
    </div>
@endsection
