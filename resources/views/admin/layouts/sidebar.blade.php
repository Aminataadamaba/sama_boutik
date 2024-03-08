<ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item active">
      <a href="{{ route('admin.dashboard')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>


    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Pages</span>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Account Settings">Category</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{ route('categories.index') }}" class="menu-link">
            <div data-i18n="Account">Categories</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('sub-categories.index') }}" class="menu-link">
            <div data-i18n="Notifications">Sous Categories</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('brands.index') }}" class="menu-link">
            <div data-i18n="Connections">Marques</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Authentications">Pruduct</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{ route('products.index') }}" class="menu-link">
            <div data-i18n="Basic">Produit</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('shipping.create') }}" class="menu-link" >
            <div data-i18n="Basic">Expedition</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('orders.index') }}" class="menu-link" >
            <div data-i18n="Basic">Commandes</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
        <div data-i18n="Authentications">Infos</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{ route('coupons.index') }}" class="menu-link">
              <div data-i18n="Basic">Coupons</div>
            </a>
          </li>
        <li class="menu-item">
          <a href="auth-login-basic.html" class="menu-link" target="_blank">
            <div data-i18n="Basic">Utilisateurs</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="auth-register-basic.html" class="menu-link" target="_blank">
            <div data-i18n="Basic">Page</div>
          </a>
        </li>

      </ul>
    </li>

    <!-- Components -->
    <!-- <li class="menu-header small text-uppercase"><span class="menu-header-text">Components</span></li> -->
    <!-- Cards -->

</aside>
