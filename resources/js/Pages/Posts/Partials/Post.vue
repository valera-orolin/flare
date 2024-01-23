<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { useForm, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
 
dayjs.extend(relativeTime);

const props = defineProps(['post']);

const emit = defineEmits(['post-updated']);
 
const form = useForm({
    message: props.post.message,
    image: null,
    visibility: props.post.visibility
});

const previewImage = ref(props.post.image);

const handleFileUpload = (event) => {
    form.image = event.target.files[0];
    previewImage.value = URL.createObjectURL(form.image);
};

let postMedia;
const triggerFileInput = () => {
    postMedia.click();
};

const editing = ref(false);

let submitForm = () => {
    let formData = new FormData();
    formData.append('message', form.message);
    if (form.image) {
        formData.append('image', form.image);
    }
    formData.append('visibility', form.visibility);
    formData.append('_method', 'PUT');

    axios.post(route('posts.update', props.post.id), formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        },
    }).then((response) => {
        form.reset(); 
        form.clearErrors();
        editing.value = false;
        emit('post-updated', response.data);
    }).catch(error => {
        console.error(error);
    });
};

const showMore = ref(false);
const liked = ref(props.post.isLikedByUser);
const likesCount = ref(props.post.likes_count);
const likePost = async (event) => {
    event.preventDefault();
    const response = await axios.post(route('likes.store', { post_id: props.post.id }));
    if (response.status === 200) {
        liked.value = !liked.value;
        if (liked.value) {
            likesCount.value++;
        } else {
            likesCount.value--;
        }
    }
}

const colors = ['rgb(255 228 230)', 'rgb(252 231 243)', 'rgb(250 232 255)', 'rgb(243 232 255)', 'rgb(237 233 254)', 'rgb(224 231 255)', 'rgb(224 242 254)', 'rgb(207 250 254)', 'rgb(204 251 241)', 'rgb(209 250 229)', 'rgb(220 252 231)', 'rgb(236 252 203)', 'rgb(254 249 195)', 'rgb(254 243 199)', 'rgb(255 237 213)', 'rgb(254 226 226)'];
const randomIndex = Math.floor(Math.random() * colors.length);
let color = colors[randomIndex];

const showEmojiPicker = ref(false);

const addEmoji = (event) => {
    form.message += event.detail.unicode;
};

const toggleMore = (event) => {
    event.stopPropagation();
    showMore.value = !showMore.value;
};

const toggleEmojiPicker = (event) => {
    event.stopPropagation();
    showEmojiPicker.value = !showEmojiPicker.value;
};

let handleClickOutside;
onMounted(() => {
    handleClickOutside = (event) => {
        const dropdownMenu = document.querySelector('.dropdown-menu');
        if (dropdownMenu && !dropdownMenu.contains(event.target)) {
            showMore.value = false;
        }
        const emojiPicker = document.querySelector('.emoji-picker');
        if (emojiPicker && !emojiPicker.contains(event.target)) {
            showEmojiPicker.value = false;
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
            <Link :href="route('profile.show', post.user.id)" class="flex items-center space-x-4 group">
                <img v-if="post.user.avatar" class="w-12 h-12 rounded-full object-cover object-center" :src="post.user.avatar" alt="Avatar">
                <img v-else class="w-12 h-12 rounded-full object-cover object-center" src="/storage/images/default-avatar.jpeg" alt="Default Avatar">
                <div class="flex flex-col overflow-hidden">
                    <a href="#" class="text-base flex flex-col space-x-1 md:flex-row">
                        <div class="font-bold max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap lg:group-hover:underline">{{ post.user.name }}</div>
                        <div class="text-gray-500 hidden md:block">•</div>
                        <div class="text-gray-500 max-w-[150px] overflow-hidden overflow-ellipsis whitespace-nowrap hidden md:block">{{ post.user.user_id }}</div>
                    </a>
                    <div class="text-sm text-gray-500">{{ dayjs(post.created_at).fromNow() }}</div>
                </div>
            </Link>
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
                        <Link :href="route('posts.destroy', post.id)" method="delete" as="button" class="whitespace-nowrap lg:hover:underline">
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
        <form v-if="editing" @submit.prevent="submitForm">
            <textarea maxlength="350" v-model="form.message" class="w-full p-1 bg-transparent resize-none border-none focus:outline-none" rows="4"></textarea>
            <img :src="previewImage" v-if="previewImage" class="max-h-[30em] object-cover" />
            <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center mt-1">
                <div class="flex items-center space-x-8">
                    <div>
                        <input type="file" ref="postMedia" class="hidden" accept="image/*" @change="handleFileUpload">
                        <font-awesome-icon :icon="['fas', 'image']" class="fas fa-image text-gray-500 cursor-pointer transition-all duration-200 lg:hover:text-black" @click="triggerFileInput"/>
                    </div>
                    <div
                        class="flex items-center text-gray-500 space-x-2 transition-all duration-200 lg:hover:text-black">
                        <font-awesome-icon :icon="['fas', 'globe']" id="globe-icon" />
                        <font-awesome-icon :icon="['fas', 'users']" class="hidden" id="users-icon" />
                        <select v-model="form.visibility" class="text-gray-500 bg-transparent border-none focus:outline-none">
                            <option value="public">Public</option>
                            <option value="only_friends">Only friends</option>
                        </select>
                    </div>
                    <div class="relative inline-block z-10 emoji-picker">
                        <font-awesome-icon :icon="['fas', 'smile']" class="fas fa-smile text-gray-500 transition-all duration-200 cursor:pointer lg:hover:text-black" @click="toggleEmojiPicker" />
                        <emoji-picker v-show="showEmojiPicker" @emoji-click="addEmoji"
                            class="absolute left-[-250px] scale-75 transform top-full mt-1 shadow-2xl md:left-0 md:scale-100"></emoji-picker>
                    </div>
                </div>
                <div class="space-x-2">
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </div>
        </form>
        <div v-else>
            {{ post.message }}
            <img :src="post.image" v-if="post.image" class="mt-2 max-h-[30em] object-cover"/>
        </div>

        <div class="flex items-center space-x-8">
            <div class="flex items-center text-gray-500 space-x-2">
                <font-awesome-icon :icon="['fas', 'eye']" />
                <div>{{ post.views_count }}</div>
            </div>
            <form @submit.prevent="likePost">
                <button type="submit"
                    class="flex items-center space-x-2 transition-all duration-200 lg:hover:text-black"
                    :class="{'text-red-400': liked, 'text-gray-500': !liked}">
                    <font-awesome-icon :icon="['fas', 'heart']" />
                    <div>{{ likesCount }}</div>
                </button>
            </form>
            <a :href="'/posts/' + post.id + '/comments'"
                class="flex items-center text-gray-500 space-x-2 transition-all duration-200 lg:hover:text-black">
                <font-awesome-icon :icon="['fas', 'comment']" />
                <div>{{ post.comments_count }}</div>
            </a>
        </div>
    </div>
</template>