
<template>
    <GuestLayout>

        <Head title="Confirm Password" />

        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form @submit.prevent="submit">
            <alert-error :message="form.errors.password" />
            <q-input label="Password" type="password" v-model="form.password" />
            <div class="flex justify-end mt-4">
                <q-btn class="ml-4" label="Confirm" :disabled="form.processing" />
            </div>
        </form>
    </GuestLayout>
</template>
<script setup>
import { AlertError } from '@/Components/Alert';
import GuestLayout from '@/Layouts/Guest.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    })
};
</script>
