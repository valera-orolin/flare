<script setup>
    defineProps(['isOpen']);
</script>

<template>
    <div class="lg:hidden">
        <div id="menu" v-show="isOpen" class="absolute flex-col items-center self-end p-8 mt-0 font-bold bg-white left-6 right-6 drop-shadow-md sm:w-auto sm:self-center">
            <div class="space-y-6">
                <a href="profile.html" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'user']" />
                    </div>
                    <div>
                        Profile
                    </div>
                </a>
                <a href="index.html" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'newspaper']" />
                    </div>
                    <div>
                        Feeds
                    </div>
                </a>
                <a href="messages.html" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'envelope']" />
                    </div>
                    <div>
                        Messages
                    </div>
                </a>
                <a href="friends.html" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'users']" />
                    </div>
                    <div>
                        Friends
                    </div>
                </a>
                <a href="notifications.html" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'bell']" />
                    </div>
                    <div>
                        Notifications
                    </div>
                </a>
                <a href="settings.html" class="flex items-center space-x-2">
                    <div class="w-6">
                        <font-awesome-icon :icon="['fas', 'gear']" />
                    </div>
                    <div>
                        Settings
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>