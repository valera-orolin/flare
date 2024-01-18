<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Post from '@/Components/Post.vue';
import PostForm from '@/Components/PostForm.vue';
import Pagination from '@/Components/Pagination.vue';
 
defineProps(['posts']);
</script>
 
<template>
    <Head title="Posts" />
 
    <AuthenticatedLayout>
        <!-- Scrollable bottom -->
        <div class="my-4 space-y-4">

            <PostForm/>

            <Post
                v-for="post in posts.data"
                :key="post.id"
                :post="post"
            />

            <Pagination :posts="posts" />
        </div>
    </AuthenticatedLayout>
</template>