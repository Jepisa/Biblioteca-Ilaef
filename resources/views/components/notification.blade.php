@if (Session()->exists('notification'))
    <div id="notification" class="flex bg-green-200 max-w-sm md:max-w-md mb-4"
        style="display:none; cursor:pointer; right: -150vw; top:5px; position:fixed; transition: right 2s;">
        <div class="w-16 bg-green-400">
            <div class="p-4">
                <svg class="h-8 w-8 text-white fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M468.907 214.604c-11.423 0-20.682 9.26-20.682 20.682v20.831c-.031 54.338-21.221 105.412-59.666 143.812-38.417 38.372-89.467 59.5-143.761 59.5h-.12C132.506 459.365 41.3 368.056 41.364 255.883c.031-54.337 21.221-105.411 59.667-143.813 38.417-38.372 89.468-59.5 143.761-59.5h.12c28.672.016 56.49 5.942 82.68 17.611 10.436 4.65 22.659-.041 27.309-10.474 4.648-10.433-.04-22.659-10.474-27.309-31.516-14.043-64.989-21.173-99.492-21.192h-.144c-65.329 0-126.767 25.428-172.993 71.6C25.536 129.014.038 190.473 0 255.861c-.037 65.386 25.389 126.874 71.599 173.136 46.21 46.262 107.668 71.76 173.055 71.798h.144c65.329 0 126.767-25.427 172.993-71.6 46.262-46.209 71.76-107.668 71.798-173.066v-20.842c0-11.423-9.259-20.683-20.682-20.683z" />
                    <path
                        d="M505.942 39.803c-8.077-8.076-21.172-8.076-29.249 0L244.794 271.701l-52.609-52.609c-8.076-8.077-21.172-8.077-29.248 0-8.077 8.077-8.077 21.172 0 29.249l67.234 67.234a20.616 20.616 0 0 0 14.625 6.058 20.618 20.618 0 0 0 14.625-6.058L505.942 69.052c8.077-8.077 8.077-21.172 0-29.249z" />
                </svg>
            </div>
        </div>
        <div class="w-auto text-gray-500 items-center p-4">
            <span class="text-lg font-bold pb-4">
                {{ Session()->get('titleNotification') }}
            </span>
            <p id="message-notification" class="leading-tight">
                {{ Session()->get('notification') }}
            </p>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            let notification = document.querySelector('#notification');
            let lengt = document.querySelector('#message-notification').innerText.length;
            if (notification) {

                notification.style.display = "flex";

                setTimeout(() => {
                    notification.style.right = "10px";
                }, 500);
                setTimeout(() => {
                    notification.style.transition = "right 0.5s";
                    notification.style.right = "1px";
                }, 2500);

                setTimeout(() => {
                    sacarLaNotificacion();
                }, ((lengt/200) * 1000 * 60 + 2000));

                notification.addEventListener('click', (event) => {
                    sacarLaNotificacion();
                });


                function sacarLaNotificacion() {
                    notification.style.pointerEvents = "none";
                    setTimeout(() => {
                        notification.style.right = "10px";
                    }, 500);
                    setTimeout(() => {
                        notification.style.transition = "right 2s";
                        notification.style.right = "-150vw";
                    }, 1000);
                    setTimeout(() => {
                        notification.remove();
                    }, 3500);
                }

            }
        });

    </script>
@endif
