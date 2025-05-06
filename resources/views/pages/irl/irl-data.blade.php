<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('IRL Reports List') }}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">IRL Report</a></div>
            <div class="breadcrumb-item"><a href="{{ route('irl') }}">IRL Reports List</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:table.main name="irl" :model="$irl" />
    </div>
</x-app-layout>
