<script setup>
import { PageHead, BreadCrumb, FileUploader } from "@/Components";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { useQuasar } from "quasar";

const props = defineProps({
    status: String,
    product: Object,
});

const breadCrumbs = [
    { label: "", icon: "home", link: route("index") },
    { label: "Products", icon: "inventory_2", link: route("products.index") },
];
const $q = useQuasar();
const form$ = ref(null);
const form = useForm({
    ...props.product,
    photos: [],
    preview: props.product.photos,
    _method: "put",
});

console.log(form);

const submit = () => {
    console.log(form.photos);
    form$.value.validate();
    form.clearErrors();
    $q.loading.show();
    form.post(route("products.update", props.product.id), {
        onFinish: () => $q.loading.hide(),
    });
};
</script>

<template>
    <Head title="Edit Product" />
    <AuthenticatedLayout>
        <PageHead title="Edit Product" :btnAddShow="false" />
        <BreadCrumb :items="breadCrumbs" />
        <q-card
            class="w-full p-4 bg-white shadow-md overflow-hidden !rounded-t-none rounded-b-sm"
        >
            <q-form
                class="grid grid-col-1 gap-y-4"
                @submit.prevent="submit"
                ref="form$"
            >
                <q-input
                    label="Name"
                    type="text"
                    v-model="form.name"
                    lazy-rules
                    :rules="[$rules.required('Name is required')]"
                />
                <q-input
                    label="Title"
                    type="text"
                    v-model="form.title"
                    lazy-rules
                    :rules="[$rules.required('Title is required')]"
                />
                <q-input
                    label="Description"
                    type="textarea"
                    v-model="form.description"
                    autogrow
                    lazy-rules
                    :rules="[$rules.required('Description is required')]"
                />
                <file-uploader
                    label="Photos"
                    v-model="form.photos"
                    v-model:preview="form.preview"
                />
                <div class="flex items-center justify-end">
                    <q-btn
                        type="submit"
                        class="ml-4 bg-black text-white"
                        label="Save"
                        :disabled="form.processing"
                    />
                </div>
            </q-form>
        </q-card>
    </AuthenticatedLayout>
</template>