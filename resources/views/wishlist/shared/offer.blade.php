<div class="product-card flex flex-col rounded-3xl bg-card">
    <a href="{{ route('product', $offer->product) . '?optionValueIds=' . $offer->option_value_ids }}"
        class="product-card-photo overflow-hidden h-[320px] rounded-3xl">
        <img src="{{ asset($offer->makeThumbnail('345x320')) }}" class="object-cover w-full h-full"
            alt="{{ $offer->product->title }}">
    </a>
    <div class="grow flex flex-col py-8 px-6">
        <h3 class="text-sm lg:text-md font-black"><a
                href="{{ route('product', $offer->product) . '?optionValueIds=' . $offer->option_value_ids }}"
                class="inline-block text-white hover:text-pink">{{ $offer->product->title }}</a></h3>
        <div class="mt-auto pt-6">
            <div class="mb-3 text-sm font-semibold">{{ $offer->price }}</div>
            @if (check_contain_in_wishlist($offer))
                <form action="{{ route('wishlist.remove', $offer) }}" method="POST">
                    @csrf
                    <button class="w-[68px] !px-0 btn btn-purple" title="Удалить из избранного">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 52 52">
                            <path
                                d="M26 48.486c-.263 0-.526-.067-.762-.203-.255-.148-6.336-3.679-12.504-8.998-3.656-3.153-6.574-6.28-8.673-9.295C1.344 26.09-.022 22.338 0 18.84c.025-4.072 1.483-7.901 4.106-10.782 2.667-2.93 6.226-4.544 10.021-4.544 4.865 0 9.312 2.725 11.872 7.042 2.56-4.317 7.007-7.042 11.872-7.042 3.586 0 7.007 1.456 9.634 4.1 2.883 2.9 4.52 7 4.494 11.245-.022 3.493-1.414 7.24-4.137 11.135-2.105 3.012-5.02 6.138-8.66 9.29-6.146 5.32-12.183 8.85-12.437 8.997a1.524 1.524 0 0 1-.766.206Z" />
                        </svg>
                    </button>
                </form>
            @else
                <form action="{{ route('wishlist.add', $offer) }}" method="POST">
                    @csrf
                    <button class="w-[68px] !px-0 btn btn-purple" title="В избранное">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 52 52">
                            <path
                                d="M26 48.486c-.263 0-.526-.067-.762-.203-.255-.148-6.336-3.679-12.504-8.998-3.656-3.153-6.574-6.28-8.673-9.295C1.344 26.09-.022 22.338 0 18.84c.025-4.072 1.483-7.901 4.106-10.782 2.667-2.93 6.226-4.544 10.021-4.544 4.865 0 9.312 2.725 11.872 7.042 2.56-4.317 7.007-7.042 11.872-7.042 3.586 0 7.007 1.456 9.634 4.1 2.883 2.9 4.52 7 4.494 11.245-.022 3.493-1.414 7.24-4.137 11.134-2.105 3.013-5.02 6.14-8.66 9.291-6.146 5.32-12.183 8.85-12.437 8.997a1.524 1.524 0 0 1-.766.206ZM14.128 6.56c-2.927 0-5.686 1.26-7.768 3.548-2.115 2.324-3.292 5.431-3.313 8.75-.042 6.606 6.308 13.483 11.642 18.09 4.712 4.068 9.49 7.123 11.308 8.236 1.808-1.115 6.554-4.168 11.246-8.235 5.319-4.61 11.668-11.493 11.71-18.11.022-3.44-1.294-6.749-3.608-9.079-2.05-2.063-4.705-3.2-7.473-3.2-4.658 0-8.847 3.276-10.422 8.152a1.523 1.523 0 0 1-2.9 0C22.976 9.836 18.787 6.56 14.129 6.56Z" />
                        </svg>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div><!-- /.product-card -->
