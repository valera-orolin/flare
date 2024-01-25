<script setup>
import { ref, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps(['user']);

const { props: pageProps } = usePage();

const isCurrentUsersPage = ref(false);

onMounted(() => {
    isCurrentUsersPage.value = props.user.id == pageProps.auth.user.id;
});

const followed = ref(props.user.isFollowedByUser);
const followUser = async (event) => {
    event.preventDefault();
    const response = await axios.post(route('follows.store', { followee_id: props.user.id }));
    if (response.status === 200) {
        followed.value = !followed.value;
    }
}
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
                    <div v-show="!isCurrentUsersPage" class="flex space-x-2">
                        <form>
                            <button type="submit"
                                class="text-xs transition-all duration-20 font-bold py-2 px-4 rounded-full lg:hover:bg-gray-300">
                                Block
                            </button>
                        </form>
                        <form @submit.prevent="followUser">
                            <button  type="submit" class="bg-black text-xs transition-all duration-200 text-white font-bold py-2 px-4 rounded-full lg:hover:bg-gray-500">
                                {{ followed ? 'Unfollow' : 'Follow' }}
                            </button>
                        </form>
                    </div>
                </div>
                <div v-if="user.description" class="mt-4">{{ user.description }}</div>
            </div>
            <div class="flex flex-row mt-4 space-x-4">
                <Link :href="route('follows.followers', user.id)" class="flex space-x-1">
                    <div class="font-bold">{{ user.followersCount }}</div>
                    <div>followers</div>
                </Link>
                <Link :href="route('follows.followees', user.id)" class="flex space-x-1">
                    <div class="font-bold">{{ user.followeesCount }}</div>
                    <div>following</div>
                </Link>
            </div>
        </div>
    </div>
</template>