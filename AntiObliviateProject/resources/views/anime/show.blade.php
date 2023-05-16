<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Anime Details') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-xl rounded-lg p-6">
            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 mb-8">
                    <img class="w-full h-100 object-cover rounded-lg shadow-md" src="{{ $anime->main_picture->medium }}" alt="{{ $anime->title }}">
                </div>
                <div class="w-full sm:w-1/2 md:w-2/3 lg:w-3/4 pl-8">
                    <h1 class="text-3xl font-bold mb-4">{{ $anime->title }}</h1>
                    <p class="text-lg mb-2">{{ $anime->synopsis }}</p>
                    <p class="text-sm mb-1"><strong>Number of episodes :</strong> {{ $anime->num_episodes }}</p>
                    <p class="text-sm"><strong>Popularity :</strong> {{ $anime->popularity }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            @if($animeInUserList)
            <h2 class="text-2xl font-bold mb-4">Edit record</h2>
            <form action="{{ route('anime.update', $anime->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="watch_date" class="block mb-1 text-sm font-bold">Viewing date</label>
                    <input type="date" name="watch_date" id="watch_date" class="w-full border rounded-lg p-2" value="{{ $AnimeRecord->watch_date }}">
                </div>
                <div class="mb-4">
                    <label for="last_episode_watched" class="block mb-1 text-sm font-bold">Last episode seen</label>
                    <input type="number" name="last_episode_watched" id="last_episode_watched" class="w-full border rounded-lg p-2" value="{{ $AnimeRecord->last_episode_watched }}">
                </div>
                <div class="mb-4">
                    <label for="categorie" class="block mb-1 text-sm font-bold">Category</label>
                    <select name="category_id" id="categorie" class="w-full border rounded-lg p-2">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $AnimeRecord->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save Changes</button>
            </form>
            <form action="{{ route('anime.destroy', ['id' => $anime->id]) }}" method="POST" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove from list</button>
            </form>
            @else
            <form action="{{ route('anime.add', ['id' => $anime->id]) }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add to my list</button>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>