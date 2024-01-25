<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3'

const props = defineProps(['user']);

const followed = ref(props.user.isFollowedByUser);
console.log(props.user);
const followUser = async (event) => {
    event.preventDefault();
    const response = await axios.post(route('follows.store', { followee_id: props.user.id }));
    if (response.status === 200) {
        followed.value = !followed.value;
    }
}
</script>

<template>
    <div class="flex items-center justify-between space-x-4">
        <div class="group overflow-hidden">
            <Link :href="route('profile.show', user.id)" class="flex items-center space-x-4">
                <img v-if="user.avatar" class="w-16 h-16 rounded-full object-cover object-center" :src="user.avatar" alt="Avatar">
                <img v-else class="w-16 h-16 rounded-full object-cover object-center" src="/storage/images/default-avatar.jpeg" alt="Default Avatar">
                <div class="flex flex-col overflow-hidden">
                    <div class="text-base font-bold whitespace-nowrap overflow-hidden overflow-ellipsis lg:group-hover:underline">{{ user.name }}</div>
                    <div class="text-base text-gray-500 overflow-hidden overflow-ellipsis">@someusersid</div>
                </div>
            </Link>
        </div>
        <form @submit.prevent="followUser">
            <button  type="submit" class="bg-black text-xs transition-all duration-200 text-white font-bold py-2 px-4 rounded-full lg:hover:bg-gray-500">
                {{ followed ? 'Unfollow' : 'Follow' }}
            </button>
        </form>
    </div>
</template>