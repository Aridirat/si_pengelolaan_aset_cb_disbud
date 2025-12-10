@if ($paginator->hasPages())
<div class="flex items-center gap-2">

    {{-- Previous Page --}}
    @if ($paginator->onFirstPage())
        <span class="px-2 py-1 bg-gray-400 rounded opacity-50">
            <i class="fas fa-chevron-left"></i>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" 
           class="px-2 py-1 bg-gray-400 hover:bg-gray-500 rounded text-white">
            <i class="fas fa-chevron-left"></i>
        </a>
    @endif


    {{-- Numbers --}}
    <span class="px-3 py-1 bg-gray-300 rounded">1</span>
    <span class="px-3 py-1 bg-gray-300 rounded">…</span>
    <span class="px-3 py-1 bg-gray-300 rounded">{{ $paginator->lastPage() }}</span>


    {{-- Next Page --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" 
           class="px-2 py-1 bg-gray-400 hover:bg-gray-500 rounded text-white">
            <i class="fas fa-chevron-right"></i>
        </a>
    @else
        <span class="px-2 py-1 bg-gray-400 rounded opacity-50">
            <i class="fas fa-chevron-right"></i>
        </span>
    @endif

</div>
@endif
