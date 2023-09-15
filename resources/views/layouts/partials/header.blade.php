<header class="mb-3">
    <a href="#" class="burger-btn d-block d-xl-none">
        <i class="bi bi-justify fs-3"></i>
    </a>
</header>

<div class="page-heading">
    {{-- <h3>Profile Statistics</h3> --}}
    <h3>@yield('title')</h3>
</div>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    @section('breadcrumb')
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    @show
                </ol>
            </nav>
        </div>
    </div>
</div>
