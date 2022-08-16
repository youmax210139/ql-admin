<template>
    <GuestLayout>

        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <div>
                <q-input label="Email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />
                <BreezeInputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <q-input label="Password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password" />
                <BreezeInputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <q-input label="Confirm Password" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password" />
                <BreezeInputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <q-btn label="Reset Password" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" />
            </div>
        </form>
    </GuestLayout>
</template>
<script setup>
import GuestLayout from '@/Layouts/Guest.vue';
import BreezeInputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>


