<script setup>
import { Link } from "@inertiajs/vue3";
import { ApplicationLogo } from "@/Components";
</script>
<template>
    <q-layout
        class="tw-min-h-screen tw-flex tw-flex-col tw-items-center tw-pt-6 tw-px-4 tw-bg-gray-100 sm:tw-justify-center sm:tw-pt-0"
    >
        <div class="tw-mb-6">
            <Link href="/">
                <ApplicationLogo
                    class="tw-w-20 tw-h-20 tw-mx-auto tw-text-gray-500"
                />
            </Link>
        </div>
        <slot />
    </q-layout>
</template>
