@props(['icon' => null])

<h2 class="font-bold text-sm sm:text-base md:text-2xl text-orange-600 leading-tight flex items-center">
    @if($icon)
        {!! $icon !!}
    @endif
    <span class="truncate">{{ $slot }}</span>
</h2>
