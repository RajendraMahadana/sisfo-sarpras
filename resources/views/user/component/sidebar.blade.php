<!--=============== HEADER ===============-->
<header class="header" id="header">
    <div class="header__container h-header">
       <a href="#" class="header__logo">
          <i class="ri-cloud-fill text-3xl text-first"></i>
          <span>Sarpras</span>
       </a>
       
       <button class="header__toggle" id="header-toggle">
          <i class="ri-menu-line"></i>
       </button>
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
             <h3 class="sidebar__title w-max  text-tiny pl-8 mb-4">MANAGE</h3>

             <div class="sidebar__list grid gap-y-4">
                <a href="{{ route('show-home-user') }}" class="sidebar__link {{ request()->routeIs('show-home-user') ? 'active-link' : '' }}">
                   <i class="ri-home-9-line"></i>
                   <span class="">Home</span>
                </a>
                
                <a href="#" class="sidebar__link ">
                   <i class="ri-wallet-3-fill"></i>
                   <span class="">My Wallet</span>
                </a>

                <a href="#" class="sidebar__link ">
                   <i class="ri-calendar-fill"></i>
                   <span class="">Calendar</span>
                </a>

                <a href="{{ route('user.loan.history') }}" class="sidebar__link ">
                   <i class="ri-arrow-up-down-line"></i>
                   <span class="">Recent Transactions</span>
                </a>

                <a href="#" class="sidebar__link ">
                   <i class="ri-bar-chart-box-fill"></i>
                   <span class="">Statistics</span>
                </a>
             </div>
          </div>

          <div>
             <h3 class="sidebar__title">SETTINGS</h3>

             <div class="sidebar__list grid gap-y-4">
                <a href="#" class="sidebar__link">
                   <i class="ri-settings-3-fill"></i>
                   <span class="">Settings</span>
                </a>

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

 