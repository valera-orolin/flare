<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
</script>

<template>

    <div class="font-medium hidden lg:col-span-1 lg:block">
        <div class="sticky top-0 pt-8">
            <div class="flex flex-col items-start">
                <Link :href="route('posts.index')" class="text-3xl font-bold px-5 mb-4">
                    Flare
                </Link>
                <Link :href="route('profile.show', user.id)" class="nav-link">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'user']" />
                    </div>
                    <div>
                        Profile
                    </div>
                </Link>
                <Link :href="route('posts.index')" class="nav-link">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'newspaper']" />
                    </div>
                    <div>
                        Feeds
                    </div>
                </Link>
                <Link :href="route('chats.index')" class="nav-link">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'envelope']" />
                    </div>
                    <div>
                        Messages
                    </div>
                </Link>
                <Link :href="route('follows.friends')" class="nav-link">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'users']" />
                    </div>
                    <div>
                        Friends
                    </div>
                </Link>
                <a href="notifications.html" class="nav-link">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'bell']" />
                    </div>
                    <div>
                        Notifications
                    </div>
                </a>
                <Link :href="route('profile.edit')" class="nav-link">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'gear']" />
                    </div>
                    <div>
                        Settings
                    </div>
                </Link>
                <Link :href="route('posts.index')" class="font-bold w-full mt-4 rounded-full text-white bg-black py-4 px-6 transition-all duration-200 hover:bg-gray-500">Publish post</Link>
            </div>
        </div>
    </div>

</template>
