<script setup>
import { PageHead, BreadCrumb } from "@/Components";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { Loading } from "quasar";
import { useForm } from "vee-validate";
import * as yup from "yup";

const props = defineProps({
    status: {
        type: String,
    },
});

const breadCrumbs = [
    { label: "", icon: "home", link: "/" },
    { label: "Users", icon: "diversity_3", link: route("user.index") },
];

const schema = yup.object({
    name: yup.string().required().label("Name"),
    email: yup.string().required().email().label("Email"),
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
        name: "",
        email: "",
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

const name = defineComponentBinds("name", quasarConfig);
const email = defineComponentBinds("email", quasarConfig);
const password = defineComponentBinds("password", quasarConfig);
const password_confirmation = defineComponentBinds(
    "password_confirmation",
    quasarConfig
);

const onSubmit = handleSubmit((form) => {
    Loading.show();
    router.post(route("user.store"), form);
});
</script>
<template>
    <Head title="Create User" />
    <AuthenticatedLayout>
        <page-head title="Create User" :btnAddShow="false" />
        <bread-crumb :items="breadCrumbs" />
        <q-card
            class="w-full p-4 bg-white shadow-md overflow-hidden !rounded-t-none rounded-b-sm"
        >
            <q-form class="grid grid-col-1 gap-y-4" @submit.prevent="onSubmit">
                <q-input label="Name" type="text" v-bind="name" />
                <q-input label="Email" type="email" v-bind="email" />
                <q-input label="Password" type="password" v-bind="password" />
                <q-input
                    label="Confirm Password"
                    type="password"
                    v-bind="password_confirmation"
                />
                <div class="flex items-center justify-end">
                    <q-btn
                        type="submit"
                        class="ml-4 bg-black text-white"
                        label="Submit"
                        :disable="!meta.valid || isSubmitting"
                    />
                </div>
            </q-form>
        </q-card>
    </AuthenticatedLayout>
</template>
