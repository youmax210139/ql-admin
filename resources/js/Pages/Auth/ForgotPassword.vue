<template>
    <GuestLayout>

        <Head title="Forgot Password" />
        <q-card class="w-full sm:max-w-md p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <q-card-section class="text-sm text-gray-600 grid grid-col-1 gap-y-4">
                Forgot your password? No problem. Just let us know your email address and
                we will email you a password
                reset link that will allow you to choose a new one.
                <q-form class="grid grid-col-1 gap-y-4" @submit.prevent="submit" ref="form$">
                    <alert-error :message="form.errors.email" />
                    <alert-success :message="status" />
                    <q-input v-model="form.email" label="Email" filled lazy-rules :rules="[
                        $rules.required('Email is required'),
                        $rules.email('should be email format'),
                    ]" />

                    <div class="flex items-center justify-end">
                        <q-btn type="submit" label="Email Password Reset Link"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            class="bg-black text-white" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </GuestLayout>
</template>

<script setup>
import { AlertError, AlertSuccess } from '@/Components/Alert';
import GuestLayout from '@/Layouts/Guest.vue';
import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { useForm, Head } from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const $q = useQuasar();
const form$ = ref(null);
const form = useForm({
    email: '',
});

const submit = () => {
    form$.value.validate();
    form.clearErrors();
    $q.loading.show();
    form.post(route('password.email'), {
        onFinish: () => $q.loading.hide(),
    });
};
</script>
