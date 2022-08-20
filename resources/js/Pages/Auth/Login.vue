<template>
    <GuestLayout>
        <q-card class="w-full sm:max-w-md p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <q-card-section>
                <h3 class="text-sm text-center">Log in</h3>
            </q-card-section>
            <q-card-section>
                <q-form class="grid grid-col-1 gap-y-4" @submit.prevent="submit" ref="form$">
                    <alert-error v-model="form.errors.email" />
                    <alert-error v-model="form.errors.password" />
                    <alert-success v-model="status" />
                    <q-input v-model="form.email" label="Email" lazy-rules :rules="[
                        $rules.required('email is required'),
                        $rules.email('should be email format'),
                    ]" />
                    <q-input v-model="form.password" label="Password" type="password" lazy-rules :rules="[
                        $rules.required('password is required'),
                    ]" />
                    <q-checkbox v-model="form.remember" label="Remember me" />
                    <div class="text-right">
                        <a v-if="canResetPassword" :href="route('password.request')"
                            class="mr-4 underline underline-offset-1 hover:cursor-pointer">
                            Forgot your password?
                        </a>
                        <q-btn label="Log in" type="submit" :disable="form.processing"
                            class="bg-black text-white login" />
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
import { useForm } from '@inertiajs/inertia-vue3';
import { useQuasar } from 'quasar'


defineProps({
    canResetPassword: Boolean,
    status: String,
});
const $q = useQuasar();
const form$ = ref(null);
const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form$.value.validate();
    form.clearErrors();
    $q.loading.show();
    form.post(route('login'), {
        onFinish: () => $q.loading.hide()
    });

};
</script>

<style lang="scss" scoped>
h3.text-sm {
    font-size: 20px;
}

.q-btn.login {
    padding-left: 1.4rem;
    padding-right: 1.4rem;
    border-radius: 0.5rem;
}
</style>