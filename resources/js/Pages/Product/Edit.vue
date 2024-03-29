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
    product: {
        type: Object,
    },
});

const breadCrumbs = [
    { label: "", icon: "home", link: "/" },
    { label: "Products", icon: "inventory_2", link: route("product.index") },
];

const schema = yup.object({
    name: yup.string().required().label("Name"),
    title: yup.string().required().label("Title"),
    description: yup.string().label("Description"),
});

const { meta, defineComponentBinds, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        ...props.product,
        uploads: [],
        _method: "put",
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
const uploads = defineComponentBinds("uploads", quasarConfig);

const onSubmit = handleSubmit((form) => {
    Loading.show();
    router.post(route("product.update", props.product.id), form);
});
</script>

<template>
    <Head title="Edit Product" />
    <AuthenticatedLayout>
        <PageHead title="Edit Product" :btnAddShow="false" />
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
                <file-uploader
                    label="Photos"
                    v-bind="uploads"
                    v-bind:preview="photos.modelValue"
                />
                <div class="flex items-center justify-end">
                    <q-btn
                        type="submit"
                        class="tw-ml-4 tw-bg-black tw-text-white"
                        label="Save"
                        :disable="!meta.valid || isSubmitting"
                    />
                </div>
            </q-form>
        </q-card>
    </AuthenticatedLayout>
</template>
