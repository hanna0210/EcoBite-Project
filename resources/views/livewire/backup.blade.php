@section('title', __('Database Backups'))
<div>

    <x-baseview title="{{ __('Database Backups') }}" showButton="true">
        @production
            <div class="ml-auto flex space-x-2 justify-end items-end w-full md:w-4/12 lg:w-4/12">
                <x-buttons.primary title="{{ __('Backup Database') }}" wireClick='newBackUp'>
                    <svg class="w-5 h-5 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </x-buttons.primary>
                <x-buttons.primary title="{{ __('Files + Database') }}" wireClick='newFullBackUp'>
                    <svg class="w-5 h-5 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </x-buttons.primary>
            </div>
        @endproduction

        {{-- table data --}}
        <table class="w-full mt-5 overflow-hidden bg-white border rounded shadow">
            <thead>
                <tr class="bg-gray-300 border-b">
                    <td class="p-2">S/N</td>
                    <td class="p-2">{{ __('File Name') }}</td>
                    <td class="p-2">{{ __('File Size') }}</td>
                    <td class="p-2">{{ __('Created') }}</td>
                    @production
                        <td class="p-2">{{ __('Actions') }}</td>
                    @endproduction
                </tr>
            </thead>
            <tbody>
                @php
                    $count = 1;
                @endphp
                @foreach ($this->backups as $backup)
                    @php
                        $infoPath = pathinfo($backup);
                        $extension = $infoPath['extension'] ?? '';
                    @endphp
                    @if ($extension == 'zip')
                        <tr class="border-b">
                            <td class="p-2">{{ $count }}</td>
                            <td class="p-2">{{ basename($backup) }}</td>
                            <td class="p-2">{{ Storage::size($backup) / 1000 }} KB</td>
                            <td class="p-2">
                                {{ \Carbon\Carbon::createFromTimestamp(Storage::lastModified($backup))->format("d M Y \\a\\t h:i a") }}
                            </td>

                            @production
                                <td class="flex p-2 space-x-4">
                                    {{-- Actions --}}
                                    <x-buttons.plain wireClick="downloadBackup('{{ $backup }}')" title="Download">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                        </svg>
                                        <span class="">Download</span>
                                    </x-buttons.plain>
                                    <x-buttons.delete id="'{{ $backup }}'" />
                                </td>
                            @endproduction
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endif
                @endforeach
                @if ($count <= 1)
                    <tr class="border-b">
                        <td class="p-2 text-center" colspan="5">
                            {{ __('No Backup Yet') }}
                        </td>
                    </tr>
                @endempty
        </tbody>

    </table>

</x-baseview>


</div>
