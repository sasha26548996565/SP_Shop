<nav class="hidden 2xl:flex gap-8">
    @foreach ($menu as $item)
        <a href="{{ $item->getLink() }}"
            class="text-white hover:text-pink {{ $item->isActive() ? 'font-bold' : '' }}">
                {{ $item->getLabel() }}
        </a>
    @endforeach
</nav>