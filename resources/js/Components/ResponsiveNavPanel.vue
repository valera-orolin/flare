<script setup>
import { Link, usePage } from '@inertiajs/vue3';

defineProps(['isOpen']);

const user = usePage().props.auth.user;
</script>

<template>
    <div class="lg:hidden">
        <div id="menu" v-show="isOpen" class="absolute flex-col items-center self-end p-8 mt-0 font-bold bg-white left-6 right-6 drop-shadow-md sm:w-auto sm:self-center">
            <div class="space-y-6">
                <Link :href="route('profile.show', user.id)" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'user']" />
                    </div>
                    <div>
                        Profile
                    </div>
                </Link>
                <Link :href="route('posts.index')" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'newspaper']" />
                    </div>
                    <div>
                        Feeds
                    </div>
                </Link>
                <a href="messages.html" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'envelope']" />
                    </div>
                    <div>
                        Messages
                    </div>
                </a>
                <Link :href="route('follows.friends')" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'users']" />
                    </div>
                    <div>
                        Friends
                    </div>
                </Link>
                <a href="notifications.html" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'bell']" />
                    </div>
                    <div>
                        Notifications
                    </div>
                </a>
                <Link :href="route('profile.edit')" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'gear']" />
                    </div>
                    <div>
                        Settings
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>