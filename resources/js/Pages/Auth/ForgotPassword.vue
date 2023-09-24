<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { Loading } from "quasar";
import { useForm } from "vee-validate";
import * as yup from "yup";

defineProps({
    status: {
        type: String,
    },
});

const schema = yup.object({
    email: yup.string().required().email().label("Email address"),
});

const { meta, defineComponentBinds, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        email: "",
    },
});

const quasarConfig = (state) => ({
    props: {
        error: !!state.errors[0],
        "error-message": state.errors[0],
    },
});
const email = defineComponentBinds("email", quasarConfig);

const onSubmit = handleSubmit((form) => {
    console.log(form);
    Loading.show();
    router.post(route("password.email"), form);
});
</script>

<template>
    <Head title="Forgot Password" />
    <GuestLayout>
        <q-card
            class="tw-w-full tw-p-4 tw-bg-white tw-shadow-md tw-overflow-hidden sm:tw-rounded-lg sm:tw-max-w-md"
        >
            <div class="tw-mb-4 tw-text-sm tw-text-gray-600">
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </div>

            <div
                v-if="status"
                class="tw-mb-4 tw-font-medium tw-text-sm tw-text-green-600"
            >
                {{ status }}
            </div>

            <q-form @submit.prevent="onSubmit">
                <q-input
                    type="email"
                    label="Email"
                    class="tw-mt-1 tw-block w-full"
                    v-bind="email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <div class="tw-flex tw-items-center tw-justify-end tw-mt-4">
                    <q-btn
                        label="Email Password Reset Link"
                        type="submit"
                        class="tw-bg-black tw-text-white"
                        :disable="!meta.valid || isSubmitting"
                    />
                </div>
            </q-form>
        </q-card>
    </GuestLayout>
</template>
