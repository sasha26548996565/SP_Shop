<div class="product-card flex flex-col rounded-3xl bg-card">
    <a href="{{ route('product', $product) }}" class="product-card-photo overflow-hidden h-[320px] rounded-3xl">
        <img src="{{ asset($product->makeThumbnail('345x320')) }}" class="object-cover w-full h-full"
            alt="{{ $product->title }}">
    </a>
    <div class="grow flex flex-col py-8 px-6">
        <h3 class="text-sm lg:text-md font-black"><a href="{{ route('product', $product) }}"
                class="inline-block text-white hover:text-pink">{{ $product->title }}</a></h3>
        <div class="mt-auto pt-6">
            <div class="mb-3 text-sm font-semibold">{{ $product->price }}</div>
        </div>
    </div>
</div><!-- /.product-card -->
