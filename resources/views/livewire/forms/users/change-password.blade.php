<div>
    <div class="mb-8 ">
        <h3 class="xl:text-left text-center text-lg font-bold xl:mt-0 mt-5">Cambiar Contraseña</h3>
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

        <!-- Old Password -->
        <div class="color_azuloscuro letterSpace-20 form_login grid grid-cols-2 gap-4">
            <!-- Old Password -->
            <div class="col-span-2">
                <x-input id="old_password" class="block w-full mb-1 font-bold color_gris" type="text" name="old_password"
                    value="" required type="password" />
                <x-label for="old_password" value="Contraseña antigua" class="ml-2" />
            </div>


            <!-- New Password -->
            <div class="col-span-2">
                <x-input id="new_password" class="block w-full mb-1 font-bold color_gris" type="text" name="new_password"
                    value="" required type="password" />
                <x-label for="new_password" value="Contraseña Nueva" class="ml-2" />
            </div>


            <!-- Confirm New Password -->
            <div class="col-span-2">
                <x-input id="confirm_password" class="block w-full mb-1 font-bold color_gris" type="text" name="confirm_password"
                    value="" required type="password" />
                <x-label for="confirm_password" value="Confirmar nueva contraseña" class="ml-2" />
            </div>

        </div>

        <div class="flex mt-8 md:mt-16 w-full justify-center flex">
            <a href="/forgot-password" class="uppercase hover:text-gray-600 inline-flex items-center text-xs tracking-widest hover:bg-gray-200 active:bg-gray-200 focus:outline-none focus:border-gray-200 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150 md:w-72 w-full bg-white redhat_bold flex justify-center  mb-0 font-bold color_gris cursor-poiner text-center">             
                    {{ __('¿Has olvidado tu contraseña?') }}
            </a>
        </div>
        <div class="flex mt-8 md:mt-8 w-full justify-center flex">
            <x-button class="md:w-60 w-full background_azuloscuro redhat_bold flex justify-center letterSpace-20 mb-0">
                {{ __('GUARDAR') }}
            </x-button>
        </div>
    </form>

</div>