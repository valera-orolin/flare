<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome to Flare" />

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <div>
                <Link
                    :href="route('login')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >
                    Register
                </Link>
            </div>
        </div>

        <div class="sm:flex sm:items-center sm:justify-center p-6">
            <div class="text-center">
                <Link :href="route('posts.index')">
                    <h1 class="text-4xl font-bold mb-4">Welcome to Flare</h1>
                </Link>
                <p class="text-xl mb-4">A social meadia built with love by Valeryia Matveyeva</p>
                <p class="text-lg mb-4">You can reach me at <a href="mailto:matveyeva.valeryia@gmail.com" class="underline text-blue-400 hover:text-blue-600">matveyeva.valeryia@gmail.com</a></p>
                <p class="text-lg">Check out the project on <a href="https://github.com/valera-orolin/flare" class="underline text-blue-400 hover:text-blue-600">GitHub</a></p>
            </div>
        </div>
    </div>
</template>
