
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('getItems') }}">Larashop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('shoppingCart') }}">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Shopping Cart
                        <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
                </li> --}}
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> User Management 
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <li><a href="{{route('admin.orders')}}">Order</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('user.profile') }}">User Profile</a></li>
                        <hr>
                        <li><a href="{{ route('user.logout') }}">Logout</a></li>
                    @elseif (Auth::check())
                        <li><a href="{{ route('user.profile') }}">User Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{ route('user.logout') }}">Logout</a></li>
                    @else
                        <li><a href="{{ route('user.signup') }}">Signup</a></li>
                        <li><a href="{{ route('user.signin') }}">Signin</a></li>
                    @endif
                </ul>
                </li>
            </ul>
            <form class="d-flex mt-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
            </div>
        </div>
    </div>
</nav>