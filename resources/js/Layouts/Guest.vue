<template>
    <q-layout class="min-h-screen flex flex-col items-center pt-6 px-4 bg-gray-100 sm:justify-center sm:pt-0">
        <div class="mb-6">
            <Link :href="route('dashboard')">
                <app-logo class="w-20 h-20 mx-auto text-gray-500" />
            </Link>
        </div>
        <slot />
    </q-layout>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import AppLogo from '@/Components/AppLogo.vue';
</script>