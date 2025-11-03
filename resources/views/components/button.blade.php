@props([
    'href' => '#',
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, success
    'size' => 'medium', // small, medium, large
    'icon' => null,
    'iconPosition' => 'left', // left, right
    'loading' => false,
    'disabled' => false
])

@php
    $baseClasses = 'inline-flex items-center font-bold rounded transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $variantClasses = [
        'primary' => 'bg-orange-600 hover:bg-orange-700 text-white focus:ring-orange-500',
        'secondary' => 'bg-gray-300 hover:bg-gray-400 text-gray-800 focus:ring-gray-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
    ];
    
    $sizeClasses = [
        'small' => 'px-3 py-1.5 text-sm',
        'medium' => 'px-4 py-2 text-base',
        'large' => 'px-6 py-3 text-lg',
    ];
    
    $classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
    
    if ($disabled) {
        $classes .= ' opacity-50 cursor-not-allowed';
    }
@endphp

@if($type === 'link')
    <a href="{{ $href }}" 
       class="{{ $classes }}" 
       @if($disabled) onclick="return false;" @endif
       {{ $attributes }}>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            {!! $icon !!}
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconPosition === 'right')
            {!! $icon !!}
        @endif
    </a>
@else
    <button type="{{ $type }}" 
            class="{{ $classes }}"
            @if($disabled) disabled @endif
            {{ $attributes }}>
        @if($loading)
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        @elseif($icon && $iconPosition === 'left')
            {!! $icon !!}
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconPosition === 'right')
            {!! $icon !!}
        @endif
    </button>
@endif