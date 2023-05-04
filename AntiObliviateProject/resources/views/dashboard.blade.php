<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="container mx-auto px-4 py-8">
            <div class="container mx-auto px-4 py-8">
                <h1 class="text-4xl font-bold mb-8">Anime List</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach ($animes as $anime)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <img class="w-full h-64 object-cover" src="{{ $anime->main_picture->medium }}" alt="{{ $anime->title }}">
                        <div class="p-4">
                            <h2 class="text-2xl font-bold mb-2">{{ $anime->title }}</h2>
                            <!-- Truncate synopsis to 150 characters -->
                            <p class="text-gray-700 mb-4">{{ \Illuminate\Support\Str::limit($anime->synopsis, 150) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold">Episodes: {{ $anime->num_episodes }}</span>
                                <span class="text-sm font-semibold">Popularity: {{ $anime->popularity }}</span>
                            </div>
                            <!-- Add a button for anime details -->
                            <a href="/anime/{{ $anime->id }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-4 rounded">
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Add pagination -->
                <div class="mt-8">
                    {{ $animes->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>