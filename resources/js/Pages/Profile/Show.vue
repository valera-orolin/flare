<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProfileHeader from './Partials/ProfileHeader.vue';
import Post from '../Posts/Partials/Post.vue';
import Pagination from '@/Components/Pagination.vue';
import { ref } from 'vue';
 
const props = defineProps(['posts', 'user']);

const posts = ref(props.posts);
const user = ref(props.user);

</script>
 
<template>
    <AuthenticatedLayout>
        <div class="my-4 space-y-4">

            <ProfileHeader :user="user" />

            <Post
                v-for="post in posts.data"
                :key="post.id"
                :post="post"
            />

            <Pagination :posts="posts" />
        </div>
    </AuthenticatedLayout>
</template>