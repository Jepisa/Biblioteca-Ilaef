<div>
    <div class="mb-8 ">
        <h3 class="xl:text-left text-center text-lg font-bold xl:mt-0 mt-5">Editar mi perfil</h3>
    </div>

    <!-- Validation Errors -->

    @if ($errors->any())
        <div class="mb-4" :errors="$errors">
            <div class="font-medium text-red-600">
                {{ __('Whoops! Something went wrong.') }}
            </div>

            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="" class="mb-0">
        @csrf

        <!-- Name and Last Name -->
        <div class="color_azuloscuro letterSpace-20 form_login grid grid-cols-2 gap-4">
            <!-- Name -->
            <div class="md:col-span-1 col-span-2">
                <x-input id="name" class="block w-full mb-1 font-bold color_gris" type="text" name="name"
                    value="{{ Auth::user()->name }}" required autofocus />
                <x-label for="name" :value="__('Name')" class="ml-2" />
            </div>

            <!-- Last Name -->
            <div class="md:col-span-1 col-span-2">
                <x-input id="lastName" class="block w-full mb-1 font-bold color_gris" type="text" name="lastName"
                    value="{{ Auth::user()->lastName }}" required />
                <x-label for="lastName" :value="__('Last Name')" class="ml-2" />
            </div>



            <!-- Country -->
            <div class="md:col-span-1 col-span-2">
                {{-- <x-input id="country" class="mt-1 w-full" type="text" name="country" :value="old('country')" required autofocus /> --}}
                <select id="country" class="w-full tracking-normal mb-1 font-bold color_gris" name="country"
                    wire:model="selectedCountry" value="{{ Auth::user()->country_id }}" required>
                    <option disabled>
                        Seleccione un país
                    </option>
                    {{-- @foreach ($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ $country->name }}
                        </option>
                    @endforeach --}}

                </select>
                <x-label for="country" :value="__('Country')" class="ml-2" />
            </div>

            <!-- State -->
            <div class="md:col-span-1 col-span-2">
                {{-- <x-input id="state" class="mt-1 w-full" type="text" name="state" :value="old('state')" required /> --}}
                <select id="state" class="w-full tracking-normal mb-1 font-bold color_gris" name="state" required
                    value="{{ Auth::user()->state_id }}">
                    <option value="Lugar de Residencia" disabled>
                        Lugar de Residencia...
                    </option>
                    {{-- @if ($states)
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">
                                {{ $state->name }}
                            </option>
                        @endforeach
                    @endif --}}

                </select>
                <x-label for="state" value="Lugar de Residencia" class="ml-2" />
            </div>


            <!-- Telephone and Email Address -->

            <div class="md:col-span-1 col-span-2">
                <x-input id="phoneNumber" class="block w-full font-bold color_gris" type="tel" name="phoneNumber"
                    value="{{ Auth::user()->phoneNumber }}" required />
                <x-label for="phoneNumber" :value="__('Telephone')" class="ml-2" />
            </div>
            <div class="md:col-span-1 col-span-2">
                <x-input id="email" class="block w-full font-bold color_gris" type="email" name="email"
                    value="{{ Auth::user()->email }}" required />
                <x-label for="email" :value="__('Email')" class="ml-2" />
            </div>


            <!-- Occupation and Referrer -->


            <!-- Occupation -->
            <div class="md:col-span-1 col-span-2">
                <select id="occupation" class="w-full tracking-normal mb-1 font-bold color_gris" name="occupation"
                    value="{{ Auth::user()->occupation_id }}" required>
                    <option disabled>
                        Selecciona una Ocupación
                    </option>
                    {{-- @foreach ($occupations as $occupation)
                        <option value="{{ $occupation->id }}">
                            {{ $occupation->name }}
                        </option>
                    @endforeach --}}

                </select>
                <x-label for="occupation" value="Ocupación" class="ml-2" />
            </div>




            <!-- Referrer -->
            <div class="md:col-span-1 col-span-2">
                <select id="referrer" class="w-full tracking-normal mb-1 font-bold color_gris" name="referrer" required
                    value="{{ Auth::user()->referrer_id }}">
                    <option disabled>
                        Nos conoces por...
                    </option>
                    {{-- @if ($referrers)
                        @foreach ($referrers as $referrer)
                            <option value="{{ $referrer->id }}">
                                {{ $referrer->name }}
                            </option>
                        @endforeach
                    @endif --}}

                </select>

                <x-label for="referrer" :value="__('Nos conocés por')" class="ml-2" />
            </div>

        </div>

        <div class="flex mt-8 md:mt-16 w-full justify-center flex">
            <a href="/changePassword" class="hover:text-gray-600 inline-flex items-center px-4 py-2 border rounded-md text-xs uppercase tracking-widest hover:bg-gray-200 active:bg-gray-200 focus:outline-none focus:border-gray-200 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150 md:w-60 w-full bg-white redhat_bold flex justify-center letterSpace-20 mb-0 border-gray-200 border font-bold color_gris cursor-poiner">             
                    {{ __('CAMBIAR CONTRASEÑA') }}
            </a>
        </div>
        <div class="flex mt-8 md:mt-8 w-full justify-center flex">
            <x-button class="md:w-60 w-full background_azuloscuro redhat_bold flex justify-center letterSpace-20 mb-0">
                {{ __('GUARDAR') }}
            </x-button>
        </div>
    </form>

</div>

<script>
    new TomSelect('#country', {
        plugins: ['dropdown_input'],
    });
    new TomSelect('#state', {
        plugins: ['dropdown_input'],
    });
    new TomSelect('#occupation', {
        plugins: ['dropdown_input'],
    });
    new TomSelect('#referrer', {
        plugins: ['dropdown_input'],
    });
</script>
