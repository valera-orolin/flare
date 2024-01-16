<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
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
    <!-- Post examples -->
    <div class="w-full bg-fuchsia-100 rounded-lg p-6 space-y-2">
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
        <div v-else>{{ post.message }}</div>

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

<!---
<template>
    <div class="p-6 flex space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-gray-800">{{ post.user.name }}</span>
                    <small class="ml-2 text-sm text-gray-600">{{ dayjs(post.created_at).fromNow() }}</small>
                    <small v-if="post.created_at !== post.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                </div>
                <Dropdown v-if="post.user.id === $page.props.auth.user.id">
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <template #content>
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>
                        <DropdownLink as="button" :href="route('posts.destroy', post.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <form v-if="editing" @submit.prevent="form.put(route('posts.update', post.id), { onSuccess: () => editing = false })">
                <textarea v-model="form.message" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <p v-else class="mt-4 text-lg text-gray-900">{{ post.message }}</p>
        </div>
    </div>
</template>
-->