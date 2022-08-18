<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <q-card>
            <q-card-section>
                You're logged in!
            </q-card-section>
        </q-card>

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
</script>