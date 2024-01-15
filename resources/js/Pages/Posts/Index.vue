<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import Post from '@/Components/Post.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
 
defineProps(['posts']);

const form = useForm({
    message: '',
});
</script>
 
<template>
    <Head title="Posts" />
 
    <AuthenticatedLayout>

        <!-- Scrollable bottom -->
        <div class="my-4 space-y-4">

            <!-- Post writing area -->
            <div class="w-full bg-blue-100 rounded-lg p-6 space-y-2">
                <form @submit.prevent="form.post(route('posts.store'), { onSuccess: () => form.reset() })">
                    <textarea id="post-area" maxlength="350"
                        v-model="form.message"
                        class="w-full p-1 bg-transparent resize-none border-none focus:outline-none" rows="4"
                        placeholder="What's up??"></textarea>
                    <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center">
                        <div class="flex items-center space-x-8">
                            <div>
                                <input type="file" id="post-media" class="hidden" accept="image/*">
                                <font-awesome-icon :icon="['fas', 'image']" class="fas fa-image text-gray-500 cursor-pointer transition-all duration-200 lg:hover:text-black" id="post-media-icon" />
                            </div>
                            <div
                                class="flex items-center text-gray-500 space-x-2 transition-all duration-200 lg:hover:text-black">
                                <font-awesome-icon :icon="['fas', 'globe']" id="globe-icon" />
                                <font-awesome-icon :icon="['fas', 'users']" class="hidden" id="users-icon" />
                                <select id="visibility-select"
                                    class="text-gray-500 bg-transparent border-none focus:outline-none">
                                    <option value="public">Public</option>
                                    <option value="friends">Only friends</option>
                                </select>
                            </div>
                            <div class="relative inline-block z-10">
                                <font-awesome-icon :icon="['fas', 'smile']" class="fas fa-smile text-gray-500 transition-all duration-200 cursor:pointer lg:hover:text-black" id="emoji-icon" />
                                <emoji-picker id="emoji-picker"
                                    class="absolute left-[-250px] scale-75 transform top-full mt-1 hidden shadow-2xl md:left-0 md:scale-100"></emoji-picker>
                            </div>
                        </div>
                        <button
                            class="self-end mt-2 rounded-full text-white bg-black py-2 px-4 transition-all duration-200 lg:mt-0 lg:hover:bg-gray-500"
                            type="submit">Publish post</button>
                    </div>
                </form>
            </div>

            <Post
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
            />
        </div>

        <!--
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('posts.store'), { onSuccess: () => form.reset() })">
                <textarea
                    v-model="form.message"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <InputError :message="form.errors.message" class="mt-2" />
                <PrimaryButton class="mt-4">Post</PrimaryButton>
            </form>
            
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Post
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
                />
            </div>
        </div>
        -->
    </AuthenticatedLayout>
</template>