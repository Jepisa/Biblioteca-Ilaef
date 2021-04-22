<div class="py-2">
    <nav class="nav-principal" x-data="{ open: false }" class="">
        {{-- <picture class="background-navbar">
            <source class="background-navbar" media="(max-width:100px)" srcset="{{ asset('img/navbar/navbar-mobile.png') }}">
            <source class="background-navbar" media="(max-width:640px)" srcset="{{ asset('img/navbar/navbar-tablet.png') }}">
            <img class="background-navbar" src="{{ asset('img/navbar/navbar.png') }}">
        </picture> --}}
        <!-- Primary Navigation Menu -->
        <div class="navbar w-full h-full">
            <div class="flex justify-between h-full">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="logo">
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden links space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Inicio') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden links space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('aboutUs')" :active="request()->routeIs('aboutUs')">
                            {{ __('Nosotros') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden links space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                            {{ __('Contacto') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    @guest
                        <a class="left-items register" href="{{ route('register') }}">Registrarse</a>
                        <a class="left-items" href="{{ route('login') }}" >Iniciar sesión</a>
                    @endguest
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    @auth
                                        <div class="">Hola {{ Auth::user()->name }}</div>
                                    @endauth

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @if (Auth::user()->isAdminPrincipalAdminOrProgrammer())
                                {{-- @minAdmin --}} 
                                    <x-dropdown-link :href="route('book.create')">
                                        {{ __('Crear Libros') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('books.index')">
                                        {{ __('Listar Libros') }}
                                    </x-dropdown-link>
                                    @if (Auth::user()->isPrincipalAdminOrProgrammer())
                                        <x-dropdown-link :href="route('register')">
                                            {{ __('Registar un usuario') }}
                                        </x-dropdown-link>
                                    @endif
                                @endif
                                {{-- @endminAdmin --}}
                                <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Logout') }}
                                        </x-dropdown-link>
                                    </form>
                                
                                @programmer
                                    @foreach (App\Models\User::all() as $user)
                                        <form method="POST" action="{{ route('impersonate.start', [$user->id]) }}" class="{{ (Auth::user()->email == $user->email) ? 'border font-black': ''}}">
                                            @csrf

                                            <x-dropdown-link :href="route('impersonate.start', [$user->id])"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{$user->name." -> ".$user->role->name }}
                                            </x-dropdown-link>
                                        </form>
                                    @endforeach
                                @endprogrammer
                            </x-slot>
                        </x-dropdown>
                    @endauth
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background: #383E56; border: 2px solid #D5E5E3; border-radius: 0 0 12px 12px">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('Inicio') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('aboutUs')" :active="request()->routeIs('aboutUs')">
                    {{ __('Nosotros') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                    {{ __('Contacto') }}
                </x-responsive-nav-link>
            </div>
            
            <!-- Responsive Settings Options -->
            <div class="pt-1 pb-1 border-t border-gray-200">
                @guest
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Registate') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Iniciar sesión') }}
                    </x-responsive-nav-link>
                @endguest
                
                @auth
                    @minAdmin
                        <x-responsive-nav-link :href="route('book.create')" :active="request()->routeIs('book.create')">
                            {{ __('Crear Libros') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.index')">
                            {{ __('Listar Libros') }}
                        </x-responsive-nav-link>
                        @if (Auth::user()->isPrincipalAdminOrProgrammer())
                            <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                                {{ __('Registar un usuario') }}
                            </x-responsive-nav-link>
                        @endif
                    @endminAdmin

                    <div class="space-y-1">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Logout') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
</div>
