<div>
    
    <a href="/categories/{{$category->slug}}" class="{{$category->depth == 0 ? 'font-bold' : '' }}">{{$category->title}}</a>

    <div class="ml-2">
        @foreach ($category->children as $child)
            <x-category :category="$child"/>    
        @endforeach
    </div>

</div>