
<template>
    <GuestLayout>

        <Head title="Register" />
        <q-card class="w-full sm:max-w-md p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <q-card-section>
                <q-form class="grid grid-col-1 gap-y-4" @submit.prevent="submit" ref="form$">
                    <alert-error :message="form.errors.password" />
                    <alert-error :message="form.errors.name" />
                    <alert-error :message="form.errors.email" />
                    <alert-error :message="form.errors.password_confirmation" />

                    <q-input label="Name" type="text" v-model="form.name" lazy-rules :rules="[
                        $rules.required('Name is required'),
                    ]" />


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
                        <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                        Already registered?
                        </Link>
                        <q-btn type="submit" class="ml-4 bg-black text-white" label="Register"
                            :disabled="form.processing" />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </GuestLayout>
</template>

<script setup>
import { AlertError } from '@/Components/Alert';
import GuestLayout from '@/Layouts/Guest.vue';
import { ref } from 'vue'
import { useQuasar } from 'quasar'
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const $q = useQuasar();
const form$ = ref(null);
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form$.value.validate();
    form.clearErrors();
    $q.loading.show();
    form.post(route('register'), {
        onFinish: () => $q.loading.hide(),
    });
};
</script>
