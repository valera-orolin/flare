<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Follow from './Partials/Follow.vue';
 
const props = defineProps(['users']);

console.log(props.users);
</script>
 
<template>
    <AuthenticatedLayout>
        <div class="my-4 space-y-4">

            <Follow
                v-for="user in users"
                :key="user.id"
                :user="user"
            />

        </div>
    </AuthenticatedLayout>
</template>