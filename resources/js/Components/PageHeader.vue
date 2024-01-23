<script setup>
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue';

const currentPage = ref('Feeds');

Inertia.on('navigate', (event) => {
    if (event.detail.page.url.startsWith('/profile/') && !event.detail.page.url.endsWith('/edit')) {
        currentPage.value = "Profile";
    } else {
        switch(event.detail.page.url) {
        case '/posts':
            currentPage.value = 'Feeds';
            break;
        case '/profile/edit':
            currentPage.value = 'Settings';
            break;
        default:
            currentPage.value = '';
            break;
        }
    }
});
</script>

<template>
    <div class="flex items-end justify-between">
        <div class="text-2xl font-bold hidden lg:block">{{ currentPage }}</div>
        <div class="flex w-full justify-between lg:space-x-2 lg:w-auto" v-if="currentPage === 'Feeds'">
            <a href="#"
                class="feeds-choice text-base text-gray-500 px-2 rounded-full transition-all duration-200 lg:hover:bg-gray-200 lg:hover:shadow">Recent</a>
            <a href="#"
                class="feeds-choice text-base text-gray-500 px-2 rounded-full transition-all duration-200 lg:hover:bg-gray-200 lg:hover:shadow">Friends</a>
            <a href="#"
                class="feeds-choice text-base text-gray-500 px-2 rounded-full transition-all duration-200 lg:hover:bg-gray-200 lg:hover:shadow">Popular</a>
        </div>
    </div>
</template>