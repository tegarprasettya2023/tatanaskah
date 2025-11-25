<nav class="layout-navbar container-xxl zindex-5 navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Theme Switcher -->
            <li class="nav-item navbar-dropdown dropdown-notifications dropdown me-3 me-xl-2">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" id="themeDropdown">
                    <i class="bx bx-palette bx-sm"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0" style="min-width: 280px;">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto">Pilih Tema</h5>
                            <i class="bx bx-paint bx-sm text-muted"></i>
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush">
                            <!-- Light Mode -->
                            <li class="list-group-item list-group-item-action dropdown-notifications-item theme-item" data-theme="light" style="cursor: pointer;">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded bg-label-warning">
                                                <i class="bx bx-sun"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Light Mode</h6>
                                        <p class="mb-0 small text-muted">Tema terang klasik</p>
                                    </div>
                                    <div class="flex-shrink-0 theme-check" style="display: none;">
                                        <i class="bx bx-check-circle bx-sm"></i>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Dark Mode -->
                            <li class="list-group-item list-group-item-action dropdown-notifications-item theme-item" data-theme="dark" style="cursor: pointer;">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded bg-label-dark">
                                                <i class="bx bx-moon"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Dark Mode</h6>
                                        <p class="mb-0 small text-muted">Tema gelap elegan</p>
                                    </div>
                                    <div class="flex-shrink-0 theme-check" style="display: none;">
                                        <i class="bx bx-check-circle bx-sm"></i>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Blue Mode -->
                            <li class="list-group-item list-group-item-action dropdown-notifications-item theme-item" data-theme="blue" style="cursor: pointer;">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded bg-label-primary">
                                                <i class="bx bx-water"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Blue Ocean</h6>
                                        <p class="mb-0 small text-muted">Tema biru menenangkan</p>
                                    </div>
                                    <div class="flex-shrink-0 theme-check" style="display: none;">
                                        <i class="bx bx-check-circle bx-sm"></i>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Green Mode -->
                            <li class="list-group-item list-group-item-action dropdown-notifications-item theme-item" data-theme="green" style="cursor: pointer;">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded bg-label-success">
                                                <i class="bx bx-leaf"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Nature Green</h6>
                                        <p class="mb-0 small text-muted">Tema hijau natural</p>
                                    </div>
                                    <div class="flex-shrink-0 theme-check" style="display: none;">
                                        <i class="bx bx-check-circle bx-sm"></i>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Purple Mode -->
                            <li class="list-group-item list-group-item-action dropdown-notifications-item theme-item" data-theme="purple" style="cursor: pointer;">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded bg-label-info">
                                                <i class="bx bx-crown"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Royal Purple</h6>
                                        <p class="mb-0 small text-muted">Tema ungu premium</p>
                                    </div>
                                    <div class="flex-shrink-0 theme-check" style="display: none;">
                                        <i class="bx bx-check-circle bx-sm"></i>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- Red Mode -->
                            <li class="list-group-item list-group-item-action dropdown-notifications-item theme-item" data-theme="red" style="cursor: pointer;">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded bg-label-danger">
                                                <i class="bx bx-heart"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Passion Red</h6>
                                        <p class="mb-0 small text-muted">Tema merah energik</p>
                                    </div>
                                    <div class="flex-shrink-0 theme-check" style="display: none;">
                                        <i class="bx bx-check-circle bx-sm"></i>
                                    </div>
                                </div>
                            </li>
                            
                            <!-- System Default -->
                            <li class="list-group-item list-group-item-action dropdown-notifications-item border-top theme-item" data-theme="system" style="cursor: pointer;">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar">
                                            <span class="avatar-initial rounded bg-label-secondary">
                                                <i class="bx bx-desktop"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">System Default</h6>
                                        <p class="mb-0 small text-muted">Ikuti pengaturan sistem</p>
                                    </div>
                                    <div class="flex-shrink-0 theme-check" style="display: none;">
                                        <i class="bx bx-check-circle bx-sm"></i>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!--/ Theme Switcher -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ auth()->user()->profile_picture }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ auth()->user()->profile_picture }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">{{ __('navbar.profile.profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="dropdown-item cursor-pointer">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">{{ __('navbar.profile.logout') }}</span>
                            </button>
                        </form>
                    </li>

                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>

<style>
/* Theme Item Styling */
.theme-item {
    transition: all 0.3s ease !important;
    position: relative;
    border-left: 3px solid transparent !important;
}

.theme-item .theme-check i {
    transition: color 0.3s ease;
}

/* Active Theme Styles */
html.light-style .theme-item[data-theme="light"] {
    background-color: rgba(105, 108, 255, 0.08) !important;
    border-left-color: #696cff !important;
}
html.light-style .theme-item[data-theme="light"] .theme-check {
    display: block !important;
}
html.light-style .theme-item[data-theme="light"] .theme-check i {
    color: #696cff !important;
}

html.dark-style .theme-item[data-theme="dark"] {
    background-color: rgba(135, 137, 255, 0.15) !important;
    border-left-color: #8789ff !important;
}
html.dark-style .theme-item[data-theme="dark"] .theme-check {
    display: block !important;
}
html.dark-style .theme-item[data-theme="dark"] .theme-check i {
    color: #8789ff !important;
}

html.blue-style .theme-item[data-theme="blue"] {
    background-color: rgba(52, 152, 219, 0.15) !important;
    border-left-color: #3498db !important;
}
html.blue-style .theme-item[data-theme="blue"] .theme-check {
    display: block !important;
}
html.blue-style .theme-item[data-theme="blue"] .theme-check i {
    color: #3498db !important;
}

html.green-style .theme-item[data-theme="green"] {
    background-color: rgba(46, 204, 113, 0.15) !important;
    border-left-color: #2ecc71 !important;
}
html.green-style .theme-item[data-theme="green"] .theme-check {
    display: block !important;
}
html.green-style .theme-item[data-theme="green"] .theme-check i {
    color: #2ecc71 !important;
}

html.purple-style .theme-item[data-theme="purple"] {
    background-color: rgba(155, 89, 182, 0.15) !important;
    border-left-color: #9b59b6 !important;
}
html.purple-style .theme-item[data-theme="purple"] .theme-check {
    display: block !important;
}
html.purple-style .theme-item[data-theme="purple"] .theme-check i {
    color: #9b59b6 !important;
}

html.red-style .theme-item[data-theme="red"] {
    background-color: rgba(231, 76, 60, 0.15) !important;
    border-left-color: #e74c3c !important;
}
html.red-style .theme-item[data-theme="red"] .theme-check {
    display: block !important;
}
html.red-style .theme-item[data-theme="red"] .theme-check i {
    color: #e74c3c !important;
}

.theme-item[data-theme="system"].system-active {
    background-color: rgba(108, 117, 125, 0.12) !important;
    border-left-color: #6c757d !important;
}
.theme-item[data-theme="system"].system-active .theme-check {
    display: block !important;
}
.theme-item[data-theme="system"].system-active .theme-check i {
    color: #6c757d !important;
}

/* Hover Effects */
html.light-style .theme-item:hover {
    background-color: rgba(105, 108, 255, 0.04) !important;
    transform: translateX(2px);
}

html.dark-style .theme-item:hover,
html.blue-style .theme-item:hover,
html.green-style .theme-item:hover,
html.purple-style .theme-item:hover,
html.red-style .theme-item:hover {
    background-color: rgba(255, 255, 255, 0.05) !important;
    transform: translateX(2px);
}

html.light-style .theme-item[data-theme="light"]:hover,
html.dark-style .theme-item[data-theme="dark"]:hover,
html.blue-style .theme-item[data-theme="blue"]:hover,
html.green-style .theme-item[data-theme="green"]:hover,
html.purple-style .theme-item[data-theme="purple"]:hover,
html.red-style .theme-item[data-theme="red"]:hover,
.theme-item[data-theme="system"].system-active:hover {
    transform: translateX(0);
}
</style>

<script>
// Theme Switcher Function - MUST BE GLOBAL
window.setTheme = function(theme) {
    const htmlElement = document.documentElement;
    
    htmlElement.classList.remove('light-style', 'dark-style', 'blue-style', 'green-style', 'purple-style', 'red-style');
    
    document.querySelectorAll('.theme-item').forEach(item => {
        item.classList.remove('system-active');
    });
    
    if (theme === 'system') {
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        htmlElement.classList.add(systemTheme + '-style');
        localStorage.setItem('theme', 'system');
        localStorage.setItem('effectiveTheme', systemTheme);
        
        const systemItem = document.querySelector('.theme-item[data-theme="system"]');
        if (systemItem) systemItem.classList.add('system-active');
    } else {
        htmlElement.classList.add(theme + '-style');
        localStorage.setItem('theme', theme);
        localStorage.setItem('effectiveTheme', theme);
    }
    
    if (typeof Toast !== 'undefined') {
        Toast.fire({
            icon: 'success',
            title: 'Tema berhasil diubah'
        });
    }
};

// Add click events to theme items
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listeners
    document.querySelectorAll('.theme-item').forEach(item => {
        item.addEventListener('click', function() {
            const theme = this.getAttribute('data-theme');
            setTheme(theme);
        });
    });
    
    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    
    if (savedTheme === 'system') {
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        document.documentElement.classList.remove('light-style', 'dark-style', 'blue-style', 'green-style', 'purple-style', 'red-style');
        document.documentElement.classList.add(systemTheme + '-style');
        
        const systemItem = document.querySelector('.theme-item[data-theme="system"]');
        if (systemItem) systemItem.classList.add('system-active');
    } else {
        document.documentElement.classList.remove('light-style', 'dark-style', 'blue-style', 'green-style', 'purple-style', 'red-style');
        document.documentElement.classList.add(savedTheme + '-style');
    }
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (localStorage.getItem('theme') === 'system') {
            const newTheme = e.matches ? 'dark' : 'light';
            document.documentElement.classList.remove('light-style', 'dark-style', 'blue-style', 'green-style', 'purple-style', 'red-style');
            document.documentElement.classList.add(newTheme + '-style');
        }
    });
});
</script>