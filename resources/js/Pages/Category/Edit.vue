<script setup>
import { PageHead, BreadCrumb } from "@/Components";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { Loading } from "quasar";
import { useForm } from "vee-validate";
import * as yup from "yup";

const props = defineProps({
    status: String,
    category: Object,
});

const breadCrumbs = [
    { label: "", icon: "home", link: "/" },
    { label: "Category", icon: "category", link: route("category.index") },
];

const schema = yup.object({
    name: yup.string().required().label("Category name"),
});

const { meta, defineComponentBinds, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: props.category,
});

const quasarConfig = (state) => ({
    props: {
        error: !!state.errors[0],
        "error-message": state.errors[0],
    },
});
const name = defineComponentBinds("name", quasarConfig);

const onSubmit = handleSubmit((form) => {
    Loading.show();
    router.put(route("category.update", props.category.id), form);
});
</script>

<template>
    <Head title="Edit Category" />
    <AuthenticatedLayout>
        <PageHead title="Edit Category" :btnAddShow="false" />
        <BreadCrumb :items="breadCrumbs" />
        <q-card
            class="tw-w-full tw-p-4 tw-bg-white tw-shadow-md tw-overflow-hidden !tw-rounded-t-none tw-rounded-b-sm"
        >
            <q-form
                class="tw-grid tw-grid-col-1 tw-gap-y-4"
                @submit.prevent="onSubmit"
            >
                <q-input label="Name" type="text" v-bind="name" />
                <div class="tw-flex tw-items-center tw-justify-end">
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
