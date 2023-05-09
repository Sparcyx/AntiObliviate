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
                    <p class="text-sm mb-1"><strong>Nombre d'épisodes :</strong> {{ $anime->num_episodes }}</p>
                    <p class="text-sm"><strong>Popularité :</strong> {{ $anime->popularity }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            @if($animeInUserList)
            <h2 class="text-2xl font-bold mb-4">Modifier la fiche</h2>
            <form action="{{ route('fiche_anime.update', $anime->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="date_visionnage" class="block mb-1 text-sm font-bold">Date de visionnage</label>
                    <input type="date" name="date_visionnage" id="date_visionnage" class="w-full border rounded-lg p-2" value="{{ $ficheAnime->date_visionnage }}">
                </div>
                <div class="mb-4">
                    <label for="dernier_episode_vu" class="block mb-1 text-sm font-bold">Dernier épisode vu</label>
                    <input type="number" name="dernier_episode_vu" id="dernier_episode_vu" class="w-full border rounded-lg p-2" value="{{ $ficheAnime->dernier_episode_vu }}">
                </div>
                <div class="mb-4">
                    <label for="categorie" class="block mb-1 text-sm font-bold">Catégorie</label>
                    <select name="categorie" id="categorie" class="w-full border rounded-lg p-2">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $ficheAnime->categorie_id == $category->id ? 'selected' : '' }}>{{ $category->titre }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Enregistrer les modifications</button>
            </form>
            <form action="{{ route('supprimer_anime_route', ['id' => $anime->id]) }}" method="POST" class="mt-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer de la liste</button>
            </form>
            @else
            <form action="{{ route('ajouter_anime_route', ['id' => $anime->id]) }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ajouter à ma liste</button>
            </form>
            @endif
        </div>
    </div>
</x-app-layout>