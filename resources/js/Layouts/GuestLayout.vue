<script setup>
import { Link } from "@inertiajs/vue3";
import { ApplicationLogo } from "@/Components";
</script>
<template>
    <q-layout
        class="min-h-screen flex flex-col items-center pt-6 px-4 bg-gray-100 sm:justify-center sm:pt-0"
    >
        <div class="mb-6">
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 mx-auto text-gray-500" />
            </Link>
        </div>
        <slot />
    </q-layout>
</template>
