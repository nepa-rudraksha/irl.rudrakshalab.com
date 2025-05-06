<x-app-layout>
    <x-slot name="header_content">
        <h1>{{ __('Edit an IRL Report') }}</h1>

        <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">IRL</a></div>
            <div class="breadcrumb-item"><a href="{{ route('irl') }}">Edit IRL Report</a></div>
        </div>
    </x-slot>

    <div>
        <livewire:create-irl-report action="updateIrlReport" :irlReportId="request()->irlReportId" />
    </div>
</x-app-layout>
