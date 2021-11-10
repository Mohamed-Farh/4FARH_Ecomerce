<div class="card border-0 rounded-0 p-lg-4 bg-light">
    <div class="card-body">
        <h5 class="text-uppercase mb-4">NAVIGATION</h5>
        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'customer.dashboard' ? 'bg-dark text-white' : 'bg-light' }}">
            <a href="{{ route('customer.dashboard') }}">
                <strong class="small text-uppercase font-weight-bold">DASHBOARD</strong>
            </a>
        </div>
        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'customer.profile' ? 'bg-dark text-white' : 'bg-light' }}">
            <a href="{{ route('customer.profile') }}">
                <strong class="small text-uppercase font-weight-bold">PROFILE</strong>
            </a>
        </div>
        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'customer.addresses' ? 'bg-dark text-white' : 'bg-light' }}">
            <a href="{{ route('customer.addresses') }}">
                <strong class="small text-uppercase font-weight-bold">ADDRESSES</strong>
            </a>
        </div>
        <div class="py-2 px-4 mb-3 {{ Route::currentRouteName() == 'customer.orders' ? 'bg-dark text-white' : 'bg-light' }}">
            <a href="{{ route('customer.orders') }}">
                <strong class="small text-uppercase font-weight-bold">ORDERS</strong>
            </a>
        </div>
        <div class="py-2 px-4 mb-3 bg-light">
            <a href="javascript:void(0);"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <strong class="small text-uppercase font-weight-bold">LOGOUT</strong>
            </a>
            {{-- <form action="{{ route('logout') }}" method="post" id="logout-form" class="d-none">
                @csrf
            </form> --}}
        </div>

    </div>
</div>
