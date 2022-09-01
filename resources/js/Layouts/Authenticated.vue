<template>
    <q-layout
        view="lHh Lpr lFf"
        class="bg-gray-100"
    >
        <app-header />
        <app-sidebar />
        <!-- Page Content -->
        <q-page-container>
            <main class="full-height py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </q-page-container>
    </q-layout>
</template>

<script setup>
import AppHeader from '@/Layouts/AppHeader.vue';
import AppSidebar from '@/Layouts/AppSidebar.vue';

</script>