<ul id="account-panel" class="nav nav-pills flex-column" style="background-color: #fff;">

    <li class="nav-item" style="border-top: 1px solid #0e2a47; margin-bottom: 5px; background-color: #363636;">
        <a href="{{ route('account.profile') }}" class="nav-link font-weight-bold text-white">
            <i class="fas fa-user-alt mr-2"></i> My Profile
        </a>
    </li>

    <li class="nav-item" style="border-top: 1px solid #0e2a47; margin-bottom: 5px; background-color: #363636;">
        <a href="{{ route('account.orders') }}" class="nav-link font-weight-bold text-white">
            <i class="fas fa-shopping-bag mr-2"></i> My Orders
        </a>
    </li>
    <li class="nav-item" style="border-top: 1px solid #0e2a47; margin-bottom: 5px; background-color: #363636;">
        <a href="{{ route('account.wishlist') }}" class="nav-link font-weight-bold text-white">
            <i class="fas fa-heart mr-2"></i> Wishlist
        </a>
    </li>
    <li class="nav-item" style="border-top: 1px solid #0e2a47; margin-bottom: 5px; background-color: #363636;">
        <a href="change-password.php" class="nav-link font-weight-bold text-white">
            <i class="fas fa-lock mr-2"></i> Change Password
        </a>
    </li>
    <li class="nav-item" style="border-top: 1px solid #191c1f; margin-bottom: 5px; background-color: #363636;">
        <a href="{{ route('account.logout') }}" class="nav-link font-weight-bold text-white">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
    </li>
</ul>
