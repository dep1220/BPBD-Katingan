@props([
    'cancelUrl' => '#',
    'cancelText' => 'Batal',
    'submitText' => 'Simpan',
    'submitType' => 'submit',
    'additionalClasses' => ''
])

<div class="flex flex-col sm:flex-row sm:justify-end gap-3 mt-8 {{ $additionalClasses }}">
    <a href="{{ $cancelUrl }}"
       class="w-full sm:w-auto text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 px-6 rounded-lg transition-colors duration-200 text-sm sm:text-base">
        {{ $cancelText }}
    </a>

    <button type="{{ $submitType }}"
            class="w-full sm:w-auto inline-flex items-center justify-center bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors duration-200 text-sm sm:text-base">

        {{-- Ikon centang --}}
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>

        {{ $submitText }}
    </button>
</div>
