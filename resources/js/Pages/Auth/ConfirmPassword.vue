<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    password: "",
});

const submit = () => {
    form.post(route("password.confirm"), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />
        <div class="mb-4 text-sm text-gray-600">
            This is a secure area of the application. Please confirm your
            password before continuing.
        </div>
        <q-form @submit.prevent="submit">
            <q-input label="Password" />
            <q-btn
                class="ml-4"
                label="Confirm"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            />
        </q-form>
    </GuestLayout>
</template>
