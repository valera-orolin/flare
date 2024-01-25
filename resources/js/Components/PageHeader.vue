<script setup>
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue';

const currentPage = ref('');

Inertia.on('navigate', (event) => {
    const currentRouteName = route().current();

    if (currentRouteName.startsWith('profile.show')) {
        currentPage.value = "Profile";
    } else if (currentRouteName == 'posts.index') {
        currentPage.value = 'Feeds';
    } else if (currentRouteName.startsWith('posts.comments')) {
        currentPage.value = 'Comments';
    } else if (currentRouteName.startsWith('follows.followers')) {
        currentPage.value = 'Followers';
    } else if (currentRouteName.startsWith('follows.followees')) {
        currentPage.value = 'Following';
    } else if (currentRouteName == 'follows.friends') {
        currentPage.value = 'Friends';
    } else if (currentRouteName == 'profile.edit') {
        currentPage.value = 'Settings';
    } else {
        currentPage.value = "x";
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