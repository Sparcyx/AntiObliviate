<main>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8">Anime List</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach ($animes as $anime)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img class="w-full h-64 object-cover" src="{{ $anime->main_picture->medium }}" alt="{{ $anime->title }}">
                <div class="p-4">
                    <h2 class="text-2xl font-bold mb-2">{{ $anime->title }}</h2>
                    <p class="text-gray-700 mb-4">{{ $anime->synopsis }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold">Episodes: {{ $anime->num_episodes }}</span>
                        <span class="text-sm font-semibold">Popularity: {{ $anime->popularity }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</main>