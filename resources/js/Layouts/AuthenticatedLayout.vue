<script setup>
import NavPanel from '@/Components/NavPanel.vue';
import Suggestions from '@/Components/Suggestions.vue';
import HamburgerButton from '@/Components/HamburgerButton.vue';
import ResponsiveNavPanel from '@/Components/ResponsiveNavPanel.vue';
import PageHeader from '@/Components/PageHeader.vue';
import { ref, onMounted } from 'vue';
import {Head, Link} from '@inertiajs/vue3';

const isOpen = ref(false);

const updateIsOpen = (value) => {
    isOpen.value = value;
};

const users = ref([]);

onMounted(async () => {
    const response = await axios.get('/api/suggested-users');
    users.value = response.data;
});
</script>

<template>

    <Head title="Flare" />

    <div class="container mx-auto px-4">

        <!-- Menu section -->
        <div class="grid gap-10 lg:grid-cols-4">

            <NavPanel />

            <!-- Feeds section -->
            <div class="lg:col-span-2">

                <!-- Sticky top -->
                <div class="sticky top-0 bg-white pt-4 pb-2 z-20 lg:pt-8">
                    <div class="flex items-center mb-4 lg:hidden">
                        <Link :href="route('posts.index')" class="text-3xl font-bold absolute left-1/2 transform -translate-x-1/2">
                            Flare
                        </Link>

                        <HamburgerButton @update:isOpen="updateIsOpen"/>
                    </div>

                    <ResponsiveNavPanel :isOpen="isOpen"/>

                    <PageHeader />
                </div>

                <main>
                    <slot />
                </main>

            </div>

            <Suggestions :users="users" />
        </div>
    </div>

</template>
