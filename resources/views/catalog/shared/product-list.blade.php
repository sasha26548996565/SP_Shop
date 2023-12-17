<!-- Product card -->
<div class="product-card flex flex-col md:flex-row rounded-3xl bg-card">
    <a href="{{ route('product', $product) }}"
        class="product-card-photo overflow-hidden shrink-0 md:w-[260px] xl:w-[320px] h-[320px] md:h-full rounded-3xl">
        <img src="{{ asset($product->makeThumbnail('345x320')) }}" class="object-cover w-full h-full"
            alt="{{ $product->title }}">
    </a>
    <div class="grow flex flex-col py-8 px-6 md:px-8">
        <h3 class="text-sm lg:text-md font-black"><a href="{{ route('product', $product) }}"
                class="inline-block text-white hover:text-pink">{{ $product->title }}</a></h3>
        <ul class="space-y-1 mt-4 text-xxs">
            @if ($product->json_properties)
                @foreach ($product->json_properties as $property => $value)
                    <li class="flex justify-between text-body"><strong>{{ $property }}:</strong> {{ $value }}
                    </li>
                @endforeach
            @endif
        </ul>
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6 mt-6">
            <div class="flex items-baseline gap-4">
                <div class="text-pink text-md xl:text-lg font-black">{{ $product->price }} ₽</div>
                {{-- <div class="text-body text-sm xl:text-md font-semibold line-through">59 300 ₽</div> --}}
            </div>
        </div>
    </div>
</div><!-- /.product-card -->
