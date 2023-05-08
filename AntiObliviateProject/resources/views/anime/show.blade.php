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
                <!-- ... -->
            </div>
        </div>

        <div class="mt-8">
            @if($anime->users->contains(Auth::user()->id))
                <h2 class="text-2xl font-bold mb-2">Modifier la fiche</h2>
                <form action="{{ route('fiche_anime.update', $anime->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
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