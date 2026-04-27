@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])

@if ($message)
    <div
        x-data="{ show: true, style: '{{ $style }}', message: '{{ $message }}' }"
        :class="{ 'bg-indigo-500': style == 'success', 'bg-red-700': style == 'danger', 'bg-gray-800': style != 'success' && style != 'danger' }"
        style="display: none;"
        x-show="show && message"
        x-on:banner-message.window="
            style = $event.detail.style;
            message = $event.detail.message;
            show = true;
        "
        class="fixed top-0 inset-x-0 pb-2"
    >
        <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center min-w-0">
                    <span class="flex p-2 rounded-lg" :class="{ 'bg-indigo-600': style == 'success', 'bg-red-600': style == 'danger' }">
                        <svg
                            class="h-5 w-5 text-white"
                            x-show="style == 'success'"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m6 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>

                        <svg
                            class="h-5 w-5 text-white"
                            x-show="style == 'danger'"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.949 3.374H4.646c-1.732 0-2.815-1.874-1.949-3.374L9.928 3.5c.866-1.5 3.032-1.5 3.898 0l7.477 12.876ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </span>

                    <p class="ms-3 font-medium text-sm text-white truncate" x-text="message"></p>
                </div>

                <div class="shrink-0 sm:ms-3">
                    <button
                        type="button"
                        class="-me-1 flex p-2 rounded-md hover:bg-indigo-600 focus:outline-hidden sm:-me-2 transition"
                        :class="{ 'hover:bg-indigo-600 focus:bg-indigo-600': style == 'success', 'hover:bg-red-600 focus:bg-red-600': style == 'danger' }"
                        aria-label="Dismiss"
                        x-on:click="show = false"
                    >
                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
