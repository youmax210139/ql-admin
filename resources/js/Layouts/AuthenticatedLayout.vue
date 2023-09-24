<script setup>
import { AppHeader, AppSidebar } from "@/Components";
</script>

<template>
    <q-layout view="lHh Lpr lFf" class="tw-bg-gray-100">
        <AppHeader />
        <AppSidebar />
        <!-- Page Content -->
        <q-page-container>
            <main
                class="tw-full-height tw-py-6 tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-8"
            >
                <slot />
            </main>
        </q-page-container>
    </q-layout>
</template>
