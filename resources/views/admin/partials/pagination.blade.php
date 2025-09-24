@if(!empty($pagination))
    <div class="pagination_area">
        <div class="right">
            @if(isset($customUrl) && $customUrl)
                {{ $pagination->onEachSide(1)->appends($_GET)->withPath($customUrl) }}
            @else
                {{ $pagination->onEachSide(1)->appends($_GET)->links() }}
            @endif
        </div>
    </div>
@endif