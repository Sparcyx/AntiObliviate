<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Personal anime List') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8 flex-wrap">
            <h1 class="text-4xl font-bold w-full sm:w-auto mb-4 sm:mb-0">Page {{$animes->currentPage()}}</h1>
            <!-- Add filter form -->
            <form id="filter-form" class="flex flex-wrap w-full sm:w-auto" method="GET" action="{{ route('filterAnimes') }}">
                <div class="w-full sm:w-auto flex flex-wrap items-center justify-start sm:justify-center mb-4 sm:mb-0">
                    <label class="inline-flex items-center mr-4">
                        <span class="ml-2 text-gray-700">Alphabetical order</span>
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-green-500 transition duration-150 ease-in-out ml-2" name="order[]" value="alphabetical">
                    </label>
                    <label class="inline-flex items-center mr-4">
                        <span class="ml-2 text-gray-700">Last episode watched</span>
                        <input type="checkbox" class="form-checkbox h-4 w-4 text-green-500 transition duration-150 ease-in-out ml-2" name="order[]" value="last_watched">
                    </label>
                    <label class="inline-flex items-center">
                        <span class="ml-2 text-gray-700">Category:</span>
                        <select class="form-select block w-full mt-1 ml-2 rounded border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="category">
                            <option value="">All</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="relative w-full sm:w-auto flex items-center justify-center sm:justify-start">
                    <input type="text" id="search" name="search" class="border p-2 rounded-l mr-2 sm:mr-0 sm:rounded-r-none w-full sm:w-64" placeholder="Rechercher">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-r sm:rounded-l-none mt-4 sm:mt-0">Filter</button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" id="anime-list">
            @foreach ($animes as $anime)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
                <img class="w-full h-64 object-cover" src="{{ $anime->image_url }}" alt="{{ $anime->title }}">
                <div class="p-4 flex flex-col h-full">
                    <h2 class="text-2xl font-bold mb-2 truncate w-full ">{{ $anime->title }}</h2>
                    <div class="flex justify-between items-center mb-4">
                        @if($anime->animeRecords->isNotEmpty())
                        <span class="text-sm font-semibold">Current episode: {{ $anime->animeRecords[0]->last_episode_watched }}</span>
                        @else
                        <span class="text-sm font-semibold">No episode watched yet</span>
                        @endif
                    </div>
                </div>
                <!-- Add a button for anime details -->
                <a href="/anime/{{ $anime->id }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-auto rounded absolute bottom-0 right-0 w-1.3/3 mb-4 mr-4">
                    View Details
                </a>
            </div>
            @endforeach
        </div>
        <!-- Add pagination -->
        <div class="mt-8" id="pagination">
            {{ $animes->links() }}
        </div>
    </div>
</x-app-layout>

<script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.form-checkbox'));
    elems.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#4099ff',
            size: 'small'
        });
    });
</script>