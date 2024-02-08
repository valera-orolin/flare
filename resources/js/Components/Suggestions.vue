<script setup>
import { Link } from '@inertiajs/vue3';

defineProps(['users']);
</script>

<template>
    <div class="hidden lg:col-span-1 lg:block">
        <div class="sticky top-0 pt-8">
            <div class="text-2xl font-bold">Suggestions</div>
            <div class="mt-4 space-y-2">
                <Link :href="route('profile.show', user.id)" v-for="(user, index) in users" :key="user.id" class="flex items-center justify-between space-x-4">
                    <div class="group overflow-hidden">
                        <a href="#" class="flex items-center space-x-4">
                            <img v-if="user.avatar" class="w-12 h-12 rounded-full mb-2 object-cover object-center" :src="user.avatar" alt="Avatar">
                            <img v-else class="w-12 h-12 rounded-full mb-2 object-cover object-center" src="/storage/images/default-avatar.jpeg" alt="Default Avatar">
                            <div class="flex flex-col">
                                <div class="text-base font-bold whitespace-nowrap lg:group-hover:underline">{{ user.name }}</div>
                                <div class="text-base text-gray-500">@{{ user.user_id }}</div>
                            </div>
                        </a>
                    </div>
                    <div type="submit" class="bg-black text-xs transition-all duration-200 text-white font-bold py-2 px-4 rounded-full lg:hover:bg-gray-500 cursor-pointer">
                        See More
                    </div>
                </Link>
            </div>
            <!---
            <form>
                <button type="submit" class="text-base text-gray-500 px-2 transition-all duration-200 rounded-full lg:hover:bg-gray-200 lg:hover:shadow">See All</button>
            </form>-->
        </div>
    </div>
</template>