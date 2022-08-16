
<template>
    <GuestLayout>

        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <q-input label="Name" type="text" class="mt-1 block w-full" v-model="form.name" />
                <BreezeInputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <q-input label="Email" type="email" class="mt-1 block w-full" v-model="form.email" required
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
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Already registered?
                </Link>

                <q-btn class="ml-4" label="Register" :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing" />

            </div>
        </form>
    </GuestLayout>
</template>
<script setup>
import GuestLayout from '@/Layouts/Guest.vue';
import BreezeInputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>
