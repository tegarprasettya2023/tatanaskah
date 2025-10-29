<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo py-5">
        <a href="{{ route('home') }}" class="app-brand-link">
            <img src="{{ asset('logo.png') }}" alt="SISURTA" width="45">
            <span class="app-brand-text demo text-black fw-bolder ms-2 fs-4">TATA NASKAH</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1 mt-3 ">
        <!-- Home -->
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link fs-5 fw-bold">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="{{ __('menu.home') }}">{{ __('menu.home') }}</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('menu.header.main_menu') }}</span>
        </li>
        <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('transaction.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-mail-send"></i>
                <div data-i18n="{{ __('menu.transaction.menu') }}">{{ __('menu.transaction.menu') }}</div>
            </a>
            <ul class="menu-sub">
                  <!-- Tambahan Surat Pribadi -->
                <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('transaction.personal.*') ? 'active' : '' }}">
            <a href="{{ route('transaction.personal.index') }}" class="menu-link">
                <div data-i18n="Surat Pribadi">Tata Naskah</div>
            </a>
</aside>
