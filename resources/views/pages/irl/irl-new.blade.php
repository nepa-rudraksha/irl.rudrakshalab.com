<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Create an IRL Report') }}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">IRl</a></div>
            <div class="breadcrumb-item"><a href="{{ route('user') }}">All IRL Reports</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:create-irl-report action="createIrlReport" class="bg-green" />
    </div>
</x-app-layout>
