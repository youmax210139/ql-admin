<template>
    <q-layout view="lHh Lpr lFf" class="bg-gray-100">
        <app-header />
        <app-sidebar />
        <!-- Page Content -->
        <q-page-container>
            <main class="full-height py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </q-page-container>
    </q-layout>

</template>

<script setup>
import { ref } from 'vue';
import AppLogo from '@/Components/AppLogo.vue';
import AppHeader from '@/Components/AppHeader.vue';
import AppSidebar from '@/Components/AppSidebar.vue';
import { Link } from '@inertiajs/inertia-vue3';

const showingNavigationDropdown = ref(false);
</script>