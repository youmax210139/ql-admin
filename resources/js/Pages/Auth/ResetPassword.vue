<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { Loading } from "quasar";
import { useForm } from "vee-validate";
import * as yup from "yup";

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const schema = yup.object({
    email: yup.string().required().email().label("Email address"),
    password: yup.string().required().min(8).label("Password"),
    password_confirmation: yup
        .string()
        .required()
        .min(8)
        .oneOf([yup.ref("password"), null], "Does not match with password!")
        .label("Password confirmation"),
});

const { meta, defineComponentBinds, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        token: props.token,
        email: props.email,
        password: "",
        password_confirmation: "",
    },
});

const quasarConfig = (state) => ({
    props: {
        error: !!state.errors[0],
        "error-message": state.errors[0],
    },
});
const email = defineComponentBinds("email", quasarConfig);
const password = defineComponentBinds("password", quasarConfig);
const password_confirmation = defineComponentBinds(
    "password_confirmation",
    quasarConfig
);

const onSubmit = handleSubmit((form) => {
    router.post(route("password.store"), form);
});
</script>

<template>
    <Head title="Reset Password" />
    <GuestLayout>
        <q-card
            class="tw-w-full tw-p-4 tw-bg-white tw-shadow-md tw-overflow-hidden sm:tw-rounded-lg sm:tw-max-w-md"
        >
            <q-form @submit.prevent="onSubmit">
                <q-input
                    type="email"
                    label="Email"
                    class="tw-mt-1 tw-block w-full"
                    :model-value="email.modelValue"
                    readonly
                    required
                    autofocus
                    autocomplete="username"
                />
                <q-input
                    label="Password"
                    type="password"
                    class="tw-mt-1 tw-block tw-w-full"
                    v-bind="password"
                    required
                    autocomplete="new-password"
                />
                <q-input
                    label="Confirm Password"
                    type="password"
                    class="tw-mt-1 tw-block tw-w-full"
                    v-bind="password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <div class="tw-flex tw-items-center tw-justify-end mt-4">
                    <q-btn
                        label="Reset Password"
                        type="submit"
                        class="tw-bg-black tw-text-white"
                        :disable="!meta.valid || isSubmitting"
                    />
                </div>
            </q-form>
        </q-card>
    </GuestLayout>
</template>
