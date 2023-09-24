<script setup>
import { AppHeader, AppSidebar } from "@/Components";
</script>

<template>
    <q-layout view="lHh Lpr lFf" class="bg-gray-100">
        <AppHeader />
        <AppSidebar />
        <!-- Page Content -->
        <q-page-container>
            <main
                class="full-height py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"
            >
                <slot />
            </main>
        </q-page-container>
    </q-layout>
</template>
