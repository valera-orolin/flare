<script setup>
import { ref } from 'vue';

const props = defineProps(['user']);

const user = ref(props.user);

</script>

<template>
    <div class="pb-2 lg:pt-8">
        <div class="flex flex-col h-auto w-full">
            <div class="flex flex-col rounded-lg">
                <img v-if="user.avatar" class="w-36 h-36 rounded-full object-cover object-center" :src="user.avatar" alt="Avatar">
                <img v-else class="w-36 h-36 rounded-full object-cover object-center" src="/storage/images/default-avatar.jpeg" alt="Default Avatar">
                <div class="flex justify-between">
                    <div>
                        <div class="text-2xl font-bold">{{ user.name }}</div>
                        <div class="text-xl text-gray-500 font-bold">{{ user.user_id }}</div>
                    </div>
                    <div class="flex space-x-2">
                        <form>
                            <button type="submit"
                                class="text-xs transition-all duration-20 font-bold py-2 px-4 rounded-full lg:hover:bg-gray-300">
                                Block
                            </button>
                        </form>
                        <form>
                            <button type="submit"
                                class="bg-black text-xs transition-all duration-200 text-white font-bold py-2 px-4 rounded-full lg:hover:bg-gray-500">
                                Follow
                            </button>
                        </form>
                    </div>
                </div>
                <div v-if="user.description" class="mt-4">{{ user.description }}</div>
            </div>
            <div class="flex flex-row mt-4 space-x-4">
                <div class="flex space-x-1">
                    <div class="font-bold">138</div>
                    <div>followers</div>
                </div>
                <div class="flex space-x-1">
                    <div class="font-bold">54</div>
                    <div>following</div>
                </div>
            </div>
        </div>
    </div>
</template>