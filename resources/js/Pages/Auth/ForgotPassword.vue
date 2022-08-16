<template>
    <GuestLayout>

        <Head title="Forgot Password" />
        <q-card class="w-full sm:max-w-md p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <q-card-section class="text-sm text-gray-600 grid grid-col-1 gap-y-4">
                Forgot your password? No problem. Just let us know your email address and
                we will email you a password
                reset link that will allow you to choose a new one.

                <div v-if="status" class="font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="grid grid-col-1 gap-y-4">
                    <q-input v-model="form.email" label="Email" filled lazy-rules :rules="[
                    ]" />

                    <!-- <BreezeInputError class="mt-2" :message="form.errors.email" /> -->

                    <div class="flex items-center justify-end">
                        <q-btn label="Email Password Reset Link" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing" class="bg-black text-white"/>
                    </div>
                </form>
            </q-card-section>
        </q-card>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/Guest.vue';
import { useForm, Head } from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>
