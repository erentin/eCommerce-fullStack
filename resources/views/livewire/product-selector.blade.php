<div>
    @if ($initialVariation)

    @livewire('product-dropdown', ['variations' => $initialVariation])
        
    @endif
    
    @if ($skuVariant)
        <div class="space-y-6">
            <div class="font-semibold text-lg">
                {{$skuVariant->formattedPrice()}}
            </div>
            <x-primary-button wire:click.prevent="addToCart">Add to Cart</x-primary-button>
        </div>
    @endif
</div>
