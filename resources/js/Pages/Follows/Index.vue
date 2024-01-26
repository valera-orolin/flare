<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Follow from './Partials/Follow.vue';
import BackButton from '@/Components/BackButton.vue';
import Pagination from '@/Components/Pagination.vue';
 
const props = defineProps(['users']);
</script>
 
<template>
    <AuthenticatedLayout>
        <div class="my-4 space-y-4">

            <BackButton />

            <Follow
                v-for="user in users.data"
                :key="user.id"
                :user="user"
            />

            <Pagination :items="users" />
        </div>
    </AuthenticatedLayout>
</template>