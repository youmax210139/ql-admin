<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight"
            >
                Dashboard
            </h2>
        </template>

        <div class="tw-py-12">
            <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8">
                <div
                    class="tw-bg-white tw-overflow-hidden tw-shadow-sm sm:tw-rounded-lg"
                >
                    <div class="tw-p-6 tw-text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
