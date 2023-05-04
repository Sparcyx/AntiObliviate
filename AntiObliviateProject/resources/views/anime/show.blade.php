<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Anime Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold mb-8">{{ $anime->title }}</h1>
        <div class="flex flex-wrap">
            <div class="w-full md:w-1/2 mb-8">
                <img class="w-full h-auto object-cover" src="{{ $anime->main_picture->medium }}" alt="{{ $anime->title }}">
            </div>
            <div class="w-full md:w-1/2">
                <h2 class="text-2xl font-bold mb-2">Synopsis</h2>
                <p class="text-gray-700 mb-4">{{ $anime->synopsis }}</p>
                <div class="mb-4">
                    <span class="font-semibold">Episodes: </span>{{ $anime->num_episodes }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Popularity: </span>{{ $anime->popularity }}
                </div>
                <div class="mb-4">
                    <span class="font-semibold">Alternative titles: </span>
                    <ul>
                        @if (isset($anime->alternative_titles->synonyms))
                        @foreach ($anime->alternative_titles->synonyms as $synonym)
                        <li>Synonym: {{ $synonym }}</li>
                        @endforeach
                        @endif
                        @if (isset($anime->alternative_titles->en))
                        <li>English: {{ $anime->alternative_titles->en }}</li>
                        @endif
                        @if (isset($anime->alternative_titles->ja))
                        <li>Japanese: {{ $anime->alternative_titles->ja }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>