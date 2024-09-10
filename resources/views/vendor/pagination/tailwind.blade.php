@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-md">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        <!-- Pagination Elements -->
        <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    {!! __('pagination.showing') !!}
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    {!! __('pagination.to') !!}
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    {!! __('pagination.of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                </p>
            </div>

            <div>
                {{ $paginator->links() }}
            </div>
        </div>

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-md">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif