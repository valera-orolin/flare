<script setup>
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
 
dayjs.extend(relativeTime);

const props = defineProps(['post']);
 
const form = useForm({
    message: props.post.message,
});
 
const editing = ref(false);
const showMore = ref(false);

const colors = ['rgb(255 228 230)', 'rgb(252 231 243)', 'rgb(250 232 255)', 'rgb(243 232 255)', 'rgb(237 233 254)', 'rgb(224 231 255)', 'rgb(224 242 254)', 'rgb(207 250 254)', 'rgb(204 251 241)', 'rgb(209 250 229)', 'rgb(220 252 231)', 'rgb(236 252 203)', 'rgb(254 249 195)', 'rgb(254 243 199)', 'rgb(255 237 213)', 'rgb(254 226 226)'];
const randomIndex = Math.floor(Math.random() * colors.length);
let color = colors[randomIndex];

const toggleMore = (event) => {
    event.stopPropagation();
    showMore.value = !showMore.value;
};

let handleClickOutside;
onMounted(() => {
    handleClickOutside = (event) => {
        const dropdownMenu = document.querySelector('.dropdown-menu');
        if (dropdownMenu && !dropdownMenu.contains(event.target)) {
            showMore.value = false;
        }
    };
    document.addEventListener('click', handleClickOutside);
});
onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>

    <div class="w-full rounded-lg p-6 space-y-2" :style="{background: color}">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4 group">
                <img class="w-12 h-12 rounded-full object-cover object-center" src=""
                    alt="Avatar">
                <div class="flex flex-col overflow-hidden">
                    <a href="#" class="text-base flex flex-col space-x-1 md:flex-row">
                        <div class="font-bold max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap lg:group-hover:underline">{{ post.user.name }}</div>
                        <div class="text-gray-500 hidden md:block">•</div>
                        <div class="text-gray-500 max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap hidden md:block">@someusersidsomeusersidsomeusersid</div>
                    </a>
                    <div class="text-sm text-gray-500">{{ dayjs(post.created_at).fromNow() }}</div>
                </div>
            </div>
            <div class="relative inline-block z-10">
                <button @click="toggleMore" class="flex space-x-1 border-gray-500 rounded-full py-4 px-2 transition-all duration-200 group lg:hover:bg-gray-300 lg:hover:shadow">
                    <div class="w-1 h-1 bg-gray-500 rounded-full lg:group-hover:bg-white"></div>
                    <div class="w-1 h-1 bg-gray-500 rounded-full lg:group-hover:bg-white"></div>
                    <div class="w-1 h-1 bg-gray-500 rounded-full lg:group-hover:bg-white"></div>
                </button>
                <div v-show="showMore" class="dropdown-menu bg-white absolute flex flex-col right-0 top-full p-4 rounded-lg shadow-lg font-bold space-y-2">
                    <div v-if="post.user.id === $page.props.auth.user.id" class="flex flex-col items-start">
                        <button @click="editing = true" class="whitespace-nowrap lg:hover:underline">
                            Edit
                        </button>
                        <Link :href="route('posts.destroy', post.id)" method="delete" class="whitespace-nowrap lg:hover:underline">
                            Delete
                        </Link>
                        </div>
                    <div v-else class="flex flex-col items-start">
                        <a href="#" class="whitespace-nowrap lg:hover:underline">
                            Follow @{{ post.user.name }}
                        </a>
                        <a href="#" class="whitespace-nowrap lg:hover:underline">
                            Block @{{ post.user.name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <form v-if="editing" @submit.prevent="form.put(route('posts.update', post.id), { onSuccess: () => editing = false })">
            <textarea maxlength="350" v-model="form.message" class="w-full p-1 bg-transparent resize-none border-none focus:outline-none" rows="4"></textarea>
            <InputError :message="form.errors.message" class="mt-2" />
            <div class="space-x-2">
                <PrimaryButton class="mt-4">Save</PrimaryButton>
                <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
            </div>
        </form>
        <div v-else>
            {{ post.message }}
            <img :src="post.image" v-if="post.image" class="mt-2"/>
        </div>

        <div class="flex items-center space-x-8">
            <div class="flex items-center text-gray-500 space-x-2">
                <i class="fas fa-eye"></i>
                <div>6355</div>
            </div>
            <form>
                <button type="submit"
                    class="flex items-center text-red-400 space-x-2 transition-all duration-200 lg:hover:text-black">
                    <i class="fas fa-heart"></i>
                    <div>536</div>
                </button>
            </form>
            <a href="#"
                class="flex items-center text-gray-500 space-x-2 transition-all duration-200 lg:hover:text-black">
                <i class="fas fa-comment"></i>
                <div>82</div>
            </a>
        </div>
    </div>

</template>