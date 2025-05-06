<div>
    <x-data-table :data="$data" :model="$irlReports">
        <x-slot name="head">
            <tr>
                <th><a wire:click.prevent="sortBy('id')" role="button" href="#">
                        ID
                        @include('components.sort-icon', ['field' => 'id'])
                    </a></th>

                <th><a wire:click.prevent="sortBy('reference_no')" role="button" href="#">
                        Reference No
                        @include('components.sort-icon', ['field' => 'reference_no'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('name')" role="button" href="#">
                        Name
                        @include('components.sort-icon', ['field' => 'name'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('email')" role="button" href="#">
                        Email
                        @include('components.sort-icon', ['field' => 'email'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('phone')" role="button" href="#">
                        Phone
                        @include('components.sort-icon', ['field' => 'phone'])
                    </a></th>


                <th><a wire:click.prevent="sortBy('status')" role="button" href="#">
                        PDF
                        @include('components.sort-icon', ['field' => 'status'])
                    </a></th>
                <th><a wire:click.prevent="sortBy('created_at')" role="button" href="#">
                        Created At
                        @include('components.sort-icon', ['field' => 'created_at'])
                    </a></th>
                <th>Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($irlReports as $irl)
            @php
            if ($irl->isPdfUploaded() && $irl->status == App\Models\IrlReport::DRAFT ) {
            $class = "badge badge-warning";
            } elseif ($irl->isPdfUploaded() && $irl->status == App\Models\IrlReport::PUBLISHED){
            $class = "badge badge-success";
            }else {
            $class = "badge badge-danger";
            }
            @endphp
            <tr x-data="window.__controller.dataTableController({{ $irl->id }})">
                <td>{{ $irl->id }}</td>
                <td>{{ $irl->reference_no }}</td>
                <td>{{ $irl->name }}</td>
                <td>{{ $irl->email }}</td>
                <td>{{ $irl->phone }}</td>
                <td>
                    <span class="{{ $class }}">
                        {{ $irl->status == App\Models\IrlReport::PUBLISHED ? "Published": "Draft" }}
                    </span>
                </td>
                <td>{{ $irl->created_at->format('d M Y H:i') }}</td>
                <td class="whitespace-no-wrap row-action--icon">
                    <a role="button" href="/irl-reports/edit/{{ $irl->id }}" class="mr-3"><i class="fa fa-16px fa-pen"></i></a>
                    <a role="button" x-on:click.prevent="deleteItem" href="#"><i class="fa fa-16px fa-trash text-red-500"></i></a>
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-data-table>
</div>