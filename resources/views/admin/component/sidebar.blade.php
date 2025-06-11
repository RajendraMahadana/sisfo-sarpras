<!--=============== HEADER ===============-->
<header class="header" id="header">
    <div class="header__container h-header">
       <a href="#" class="header__logo">
          <i class="ri-cloud-fill text-3xl text-first"></i>
          <span>Sarpras</span>
       </a>
       <div class="flex items-center gap-8 lg:flex lg:flex-row-reverse">
         <h1>@yield('header-title')</h1>

         <button class="header__toggle" id="header-toggle">
            <i class="ri-menu-line"></i>
         </button>
      </div>
    </div>
 </header>

 <!--=============== SIDEBAR ===============-->
 <nav class="sidebar" id="sidebar">
    <div class="sidebar__container">
       <div class="sidebar__user">
          <div class="sidebar__img">
             <img class="" src="assets/img/perfil.png" alt="image">
          </div>

          <div class="sidebar__info">
            @auth
            <h3>{{ Auth::user()->name}}</h3>
            <span>{{ Auth::user()->email }}</span>
            @endauth
          </div>
       </div>

       <div class="sidebar__content">
          <div>
             <h3 class="sidebar__title w-max text-tiny pl-8 mb-4">MANAGE</h3>

             <div class="sidebar__list grid gap-y-4">
               <a href="{{ route('show-dashboard-admin') }}" class="sidebar__link {{ request()->routeIs('show-dashboard-admin') ? 'active-link' : '' }}">
                  <i class="ri-dashboard-line"></i>
                  <span>Dashboard</span>
               </a>
                
                <a href="{{ route('categories.index') }}" class="sidebar__link {{ request()->routeIs('categories.index') ? 'active-link' : '' }}">
                   <i class="ri-stack-line"></i>
                   <span class="">Category</span>
                </a>

                <a href="{{ route('items.index') }}" class="sidebar__link {{ request()->routeIs('items.index') ? 'active-link' : '' }}">
                   <i class="ri-box-2-line"></i>
                   <span class="">Items</span>
                </a>

                <a href="{{ route('locations.index') }}" class="sidebar__link {{ request()->routeIs('locations.index') ? 'active-link' : '' }}">
                   <i class="ri-map-pin-5-line"></i>
                   <span class="">Location</span>
                </a>

                <a href="{{ route('users.index') }}" class="sidebar__link {{ request()->routeIs('users.index') ? 'active-link' : '' }}" class="sidebar__link ">
                   <i class="ri-user-settings-line"></i>
                   <span class="">Admin & User</span>
                </a>
             </div>
          </div>

          <div>
             <h3 class="sidebar__title">SETTINGS</h3>

             <div class="sidebar__list grid gap-y-4">

               <div>
                  <!-- Button Dropdown -->
                  <button onclick="toggleSubMenu(this)" class="dropdown-btn flex items-center justify-between w-11/12 text-left text-gray-800 hover:text-blue-600 transition duration-300 ease-in-out" data-open="false">
                      <a class="sidebar__link">
                          <i class="ri-hand-coin-line "></i>
                          <span>Borrow/Return</span>
                      </a>
                      <!-- Panah -->
                     <i class="dropdown-icon ri-arrow-down-s-line transform transition-transform duration-300 {{ request()->routeIs('loans.*', 'returns.*', 'transaksi.*') ? 'rotate-180' : '' }}"></i>
                  </button>
              
                  <!-- Submenu -->
                  <ul class="sub-menu text-sm ml-10 pl-4 mt-1 space-y-1 border-l border-gray-200 overflow-hidden transition-all duration-500 ease-in-out max-h-0 {{ request()->routeIs('loans.*', 'returns.*', 'transaksi.*') ? 'max-h-96' : 'max-h-0' }}">
                      <li>
                          <a href="{{ route('loans.index') }}" class=" {{ request()->routeIs('loans.index') ? 'active-link' : '' }} sidebar__link block px-3 py-1 hover:text-blue-500">
                              <span>Loans</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{ route('returns.index') }}" class="{{ request()->routeIs('returns.index') ? 'active-link' : '' }} sidebar__link block px-3 py-1 hover:text-blue-500">
                              <span>Return</span>
                          </a>
                      </li>
                      <li>
                          <a href="#" class="sidebar__link block px-3 py-1 hover:text-blue-500">
                              <span>Transaction History</span>
                          </a>
                      </li>
                  </ul>
              </div>

                <div>
                  <button onclick="toggleSubMenu(this)" class="dropdown-btn flex items-center justify-between w-11/12 text-left text-gray-800 hover:text-blue-600 transition duration-300 ease-in-out">
                    <a class="sidebar__link">
                     <i class="ri-draft-line"></i>
                      <span>Laporan</span>
                    </a>
                    <!-- Panah -->
                    <i class="dropdown-icon ri-arrow-down-s-line transform transition-transform duration-300 
                      {{ request()->routeIs('peminjaman.*', 'pengembalian.*', 'transaksi.*') ? 'rotate-180' : '' }}">
                   </i>
                  </button>
                
                  <ul class="sub-menu text-sm ml-10 pl-4 mt-1 space-y-1 border-l border-gray-200 overflow-hidden transition-all duration-500 ease-in-out
                      {{ request()->routeIs('peminjaman.*', 'pengembalian.*', 'transaksi.*') ? 'max-h-96' : 'max-h-0' }}">

                    <li class="{{ request()->routeIs('peminjaman.index') ? 'text-blue-600 font-semibold' : '' }}">
                      <a href="" class="sidebar__link block px-3 py-1 hover:text-blue-500">
                        <span>Stok Barang</span>
                      </a>
                    </li>

                    <li class="{{ request()->routeIs('pengembalian.index') ? 'text-blue-600 font-semibold' : '' }}">
                      <a href="" class="sidebar__link block px-3 py-1 hover:text-blue-500">
                        <span>Peminjaman</span>
                      </a>
                    </li>

                    <li class="{{ request()->routeIs('transaksi.index') ? 'text-blue-600 font-semibold' : '' }}">
                      <a href="" class="sidebar__link block px-3 py-1 hover:text-blue-500">
                        <span>Pengembalian</span>
                      </a>
                    </li>

                  </ul>
                </div>

                <a href="#" class="sidebar__link">
                   <i class="ri-mail-unread-fill"></i>
                   <span class="">My Messages</span>
                </a>

                <a href="#" class="sidebar__link">
                   <i class="ri-notification-2-fill"></i>
                   <span class="">Notifications</span>
                </a>
             </div>
          </div>
       </div>

       <div class="sidebar__actions">
          <button class="sidebar__link">
             <i class="ri-moon-clear-fill" id="theme-button"></i>
             <span class="">Theme</span>
          </button>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="sidebar__link" type="submit" class="text-red-500 hover:text-red-700">
               <i class="ri-logout-box-r-fill"></i>
               <span class="">Log Out</span>
            </button>
        </form>
       </div>
    </div>
 </nav>

 <script>
   function toggleSubMenu(button) {
    const submenu = button.nextElementSibling; // Ambil submenu
    const icon = button.querySelector('.dropdown-icon'); // Ambil ikon panah

    // Toggle submenu height and icon rotation
    if (submenu.classList.contains('max-h-0')) {
        submenu.classList.remove('max-h-0');
        submenu.classList.add('max-h-96');
        icon.classList.add('rotate-180');
    } else {
        submenu.classList.remove('max-h-96');
        submenu.classList.add('max-h-0');
        icon.classList.remove('rotate-180');
    }
}
 </script>
 
 