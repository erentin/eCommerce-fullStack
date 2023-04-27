<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                    
                <div class="ml-4">
                    <a href="/categories/{{ $category->slug }}" class="{{ $category->parent_id === null ? 'font-bold' : '' }}">{{ $category->title }}</a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
