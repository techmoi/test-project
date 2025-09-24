@php
    $logo = config('constant.logo');
    $companyName = config('constant.company_name');
@endphp

<header class="header-section-other">
    <div class="container-fluid">
        <div class="logo">
            <a href="{{ route('product.index') }}"><img src="{{ General::renderImage($logo ?? '')}}" alt="{{ $companyName ?? 'Logo'}}">
        </div>
        <div class="nav-menu">
            <nav class="main-menu mobile-menu">
                <ul>
                    <li class="active"><a href="{{ route('product.index') }}">Home</a></li>
                </ul>
            </nav>
        </div>
        <div id="mobile-menu-wrap"></div>
    </div>
</header>