<template>
    <GuestLayout>

        <Head title="Reset Password" />
        <q-card class="w-full sm:max-w-md p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <q-form class="grid grid-col-1 gap-y-4" @submit.prevent="submit" ref="form$">
                <alert-error v-model="form.errors.email" />
                <alert-error v-model="form.errors.password" />
                <alert-error v-model="form.errors.password_confirmation" />
                <q-input label="Email" type="email" v-model="form.email" lazy-rules :rules="[
                    $rules.required('Email is required'),
                    $rules.email('should be email format'),
                ]" />

                <q-input label="Password" type="password" v-model="form.password" lazy-rules :rules="[
                    $rules.required('Password is required'),
                ]" />

                <q-input label="Confirm Password" type="password" v-model="form.password_confirmation" lazy-rules
                    :rules="[
                        $rules.required('Confirm Password is required'),
                        $rules.sameAs(form.password, 'Confirm Password should be same as password field'),
                    ]" />

                <div class="flex items-center justify-end">
                    <q-btn type="submit" label="Reset Password" class="bg-black text-white"
                        :disabled="form.processing" />
                </div>
            </q-form>
        </q-card>
    </GuestLayout>
</template>
<script setup>
import { AlertError } from '@/Components/Alert';
import GuestLayout from '@/Layouts/Guest.vue';
import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
});

const $q = useQuasar();
const form$ = ref(null);
const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form$.value.validate();
    form.clearErrors();
    $q.loading.show();
    form.post(route('password.update'), {
        onFinish: () => $q.loading.hide(),
    });
};
</script>


