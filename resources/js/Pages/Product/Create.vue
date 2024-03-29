<script setup>
import { PageHead, BreadCrumb, FileUploader } from "@/Components";
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
    { label: "Products", icon: "inventory_2", link: route("product.index") },
];

const schema = yup.object({
    name: yup.string().required().label("Name"),
    title: yup.string().required().min(10).label("Title"),
    description: yup.string().min(20).label("Description"),
});

const { meta, defineComponentBinds, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        name: "",
        title: "",
        description: "",
        photos: [],
    },
});

const quasarConfig = (state) => ({
    props: {
        error: !!state.errors[0],
        "error-message": state.errors[0],
    },
});
const name = defineComponentBinds("name", quasarConfig);
const title = defineComponentBinds("title", quasarConfig);
const description = defineComponentBinds("description", quasarConfig);
const photos = defineComponentBinds("photos", quasarConfig);

const onSubmit = handleSubmit((form) => {
    Loading.show();
    router.post(route("product.store"), form);
});
</script>

<template>
    <Head title="Create Product" />
    <AuthenticatedLayout>
        <PageHead title="Create Product" :btnAddShow="false" />
        <BreadCrumb :items="breadCrumbs" />
        <q-card
            class="tw-w-full tw-p-4 tw-bg-white tw-shadow-md tw-overflow-hidden !tw-rounded-t-none tw-rounded-b-sm"
        >
            <q-form
                class="tw-grid tw-grid-col-1 tw-gap-y-4"
                @submit.prevent="onSubmit"
            >
                <q-input label="Name" type="text" v-bind="name" />
                <q-input label="Title" type="text" v-bind="title" />
                <q-input
                    label="Description"
                    type="textarea"
                    v-bind="description"
                    autogrow
                />
                <file-uploader label="Photos" v-bind="photos" />
                <div class="tw-flex tw-items-center tw-justify-end">
                    <q-btn
                        label="Submit"
                        type="submit"
                        class="tw-ml-4 tw-bg-black tw-text-white"
                        :disable="!meta.valid || isSubmitting"
                    />
                </div>
            </q-form>
        </q-card>
    </AuthenticatedLayout>
</template>
