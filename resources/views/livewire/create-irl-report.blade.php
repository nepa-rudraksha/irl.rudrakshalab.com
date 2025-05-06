<div id="form-create">
    <x-jet-form-section :submit="$action" class="mb-4">
        <x-slot name="title">
            {{ __('IRL Report') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Add/Edit IRL Report') }}
        </x-slot>

        <x-slot name="form">

            <div class="form-group col-span-6 sm:col-span-3 mb-2">
                <x-jet-label for="created_at" value="{{ __('Report Created At') }}" />
                <x-jet-input id="created_at" type="datetime-local" class="mt-1 block w-full form-control shadow-none" wire:model.defer="irlReport.created_at" />
                <x-jet-input-error for="irlReport.created_at" class="mt-2" />
            </div>
            <div class="form-group col-span-6 sm:col-span-3 mb-2">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="irlReport.name" />
                <x-jet-input-error for="irlReport.name" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3 mb-2">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="irlReport.email" />
                <x-jet-input-error for="irlReport.email" class="mt-2" />

            </div>

            <div class="form-group col-span-6 sm:col-span-3 mb-2">
                <x-jet-label for="phone" value="{{ __('Phone Number') }}" />
                <x-jet-input id="phone" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.defer="irlReport.phone" />
                <x-jet-input-error for="irlReport.phone" class="mt-2" />
            </div>

            <div class="form-group col-span-6 sm:col-span-3 mb-2">
                <x-jet-label for="reference_no" value="{{ __('Reference Number') }}" />
                <x-jet-input id="reference_no" type="text" class="mt-1 block w-full form-control shadow-none" wire:model.debounce.1000ms="irlReport.reference_no" />
                <x-jet-input-error for="irlReport.reference_no" class="mt-2" />
            </div>


            <div class="form-group col-span-6 sm:col-span-3 mb-2">
                <x-jet-label for="report" value="{{ __('Upload PDF') }}" />



                <div x-data="{ isUploading: false, progress: 0, completed: false }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; completed = true" x-on:livewire-upload-error="isUploading = false, completed = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                    <x-jet-input id="report" type="file" class="mt-1 block w-full form-control shadow-none" wire:model="report" />
                    <x-jet-input-error for="report" class="mt-2" />

                    <!-- Progress Bar -->
                    <div class="mt-2" x-show="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>

                    <div class="mt-3" x-show="completed">
                        <span class="bg-green-400 p-2 text-gray-200 border rounded-md">Upload complete</span>
                    </div>



                </div>

                @if (isset($irlReport['pdf_url']))
                <div class="mt-3" x-data="window.__controller.IrlController({{ $repo->id }})">
                    <a class="btn btn-light mr-2" target="_blank" href="{{ App\Models\IrlReport::getPdfUrl($irlReport['pdf_url'])}}"><i class="fa fa-16px fa-eye"></i> View PDF</a>
                    <a class="btn btn-danger" x-on:click.prevent="deleteDownload"><i class="fa fa-16px fa-trash"> </i> Delete PDF</a>
                </div>
                @endif


            </div>

            <div class="form-group col-span-6 sm:col-span-3 mb-2">
                @if(isset($qr) && (!empty($irlReport['email']) || !empty($irlReport['phone'])))
                {!! $qr !!}
                <a target="_blank" href="{{ route('irl.downloadqr',['referenceNo' =>  $irlReport['reference_no'], 'emailPhone' =>  $irlReport['email']] )}}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 my-2 rounded inline-flex items-center">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                    </svg>
                    <span>Download</span>
                </a>
                @endif
            </div>

            <div class="form-group col-span-6 sm:col-span-3 mb-2">
                <x-jet-label for="report" value="{{ __('Status') }}" />


                <label class="inline-flex items-center">
                    <input id="draft" value="0" type="radio" class="" wire:model="irlReport.status" />
                    <span class="ml-2">{{ __('Draft') }}</span>
                </label>



                <label class="inline-flex items-center ml-6">
                    <input id="published" value="1" type="radio" @if (!isset($irlReport['pdf_url'])) disabled @endif class="" wire:model="irlReport.status" />
                    <span class="ml-2">{{ __('Published') }}</span>
                </label>


                <x-jet-input-error for="irlReport.status" class="mt-2" />
            </div>





        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __($button['submit_response']) }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __($button['submit_text']) }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-notify-message on="saved" type="success" :message="__($button['submit_response_notyf'])" />
</div>