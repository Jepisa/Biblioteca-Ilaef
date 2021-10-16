<div>
    <div class="text-left md:text-center mb-8 ">
        <h3 class="text-lg md:text-2xl">Creá una cuenta. Es gratis</h3>
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

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name and Last Name -->
        <div class="color_azuloscuro letterSpace-20 form_login grid grid-cols-2 gap-4">
            <!-- Name -->
            <div class="md:col-span-1 col-span-2">
                <x-input id="name" class="block w-full mb-1" type="text" name="name" :value="old('name')" required
                    autofocus />
                <x-label for="name" :value="__('Name')" class="ml-2" />
            </div>

            <!-- Last Name -->
            <div class="md:col-span-1 col-span-2">
                <x-input id="lastName" class="block w-full mb-1" type="text" name="lastName" :value="old('lastName')"
                    required />
                <x-label for="lastName" :value="__('Last Name')" class="ml-2" />
            </div>



            <!-- Country -->
            <div class="md:col-span-1 col-span-2" wire:ignore>
                {{-- <x-input id="country" class="mt-1 w-full" type="text" name="country" :value="old('country')" required autofocus /> --}}
                <select id="country" class="w-full tracking-normal mb-1" name="country" wire:model="selectedCountry"
                    :value="old('country')" required>
                    <option selected disabled>
                        Seleccione un país
                    </option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ $country->name }}
                        </option>
                    @endforeach

                </select>
                <x-label for="country" :value="__('Country')" class="ml-2" />
            </div>

            <!-- State -->
            <div class="md:col-span-1 col-span-2">
                {{-- <x-input id="state" class="mt-1 w-full" type="text" name="state" :value="old('state')" required /> --}}
                <select id="state" class="w-full tracking-normal mb-1" name="state" required>
                    <option value="Lugar de Residencia" selected disabled>
                        Lugar de Residencia...
                    </option>
                    @if ($states)
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">
                                {{ $state->name }}
                            </option>
                        @endforeach
                    @endif

                </select>
                <x-label for="state" value="Lugar de Residencia" class="ml-2" />
            </div>


            <!-- Telephone and Email Address -->

            <div class="md:col-span-1 col-span-2">
                <x-input id="phoneNumber" class="block w-full" type="tel" name="phoneNumber"
                    :value="old('phoneNumber')" required />
                <x-label for="phoneNumber" :value="__('Telephone')" class="ml-2" />
            </div>
            <div class="md:col-span-1 col-span-2">
                <x-input id="email" class="block w-full" type="email" name="email" :value="old('email')"
                    required />
                <x-label for="email" :value="__('Email')" class="ml-2" />
            </div>


            <!-- Occupation and Referrer -->


            <!-- Occupation -->
            <div class="md:col-span-1 col-span-2">
                <select id="occupation" class="w-full tracking-normal mb-1" name="occupation" :value="old('occupation')"
                    required>
                    <option selected disabled>
                        Selecciona una Ocupación
                    </option>
                    @foreach ($occupations as $occupation)
                        <option value="{{ $occupation->id }}">
                            {{ $occupation->name }}
                        </option>
                    @endforeach

                </select>
                <x-label for="occupation" value="Ocupación" class="ml-2" />
            </div>




            <!-- Referrer -->
            <div class="md:col-span-1 col-span-2">
                <select id="referrer" class="w-full tracking-normal mb-1" name="referrer" required>
                    <option selected disabled>
                        Nos conoces por...
                    </option>
                    @if ($referrers)

                        @foreach ($referrers as $referrer)
                            <option value="{{ $referrer->id }}">
                                {{ $referrer->name }}
                            </option>
                        @endforeach
                    @endif

                </select>

                <x-label for="referrer" :value="__('Nos conocés por')" class="ml-2" />
            </div>



            <!--Password and Confirm Password -->

            <!-- Password -->
            <div class="md:col-span-1 col-span-2">
                <x-input id="password" class="block w-full mb-1" type="password" name="password" required
                    autocomplete="new-password" />
                <x-label for="password" :value="__('Password')" class="ml-2" />
            </div>

            <!-- Confirm Password -->
            <div class="md:col-span-1 col-span-2">

                <x-input id="password_confirmation" class="block w-full mb-1" type="password"
                    name="password_confirmation" required />
                <x-label for="password_confirmation" :value="__('Confirm Password')" class="ml-2" />
            </div>
        </div>
        @auth
            <!-- Roles -->
            @if (isset($roles))

                <!-- Role -->
                <div class="mb-6">
                    <x-label for="role" :value="__('Role')" />

                    {{-- <x-input id="role" class="block mt-1 w-full" type="text" name="role_id" :value="old('role_id')" required />

                    <option {{ (Auth::user()->role->name == 'Administrador Principal') ? 'selected="selected"' : '' }} value="{{ HOla1 }}">
                        {{ Label }}
                    </option> --}}

                    <select name="role_id">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">
                                {{ $role->name }}
                            </option>
                        @endforeach

                    </select>

                </div>

            @endif
        @endauth

        <div class="flex mt-8 md:mt-16 w-full justify-center flex">
            <x-button
                class="xl:w-60 w-full background_azuloscuro redhat_bold flex justify-center letterSpace-20 mb-0">
                {{ __('REGISTRATE') }}
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
