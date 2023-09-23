<script setup>
import { AppTable, PageHead } from "@/Components";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { useQuasar, Loading } from "quasar";

const props = defineProps({
    status: String,
    categories: Object,
});

const columns = [
    { name: "name", label: "Name", field: "name", sortable: true },
    {
        name: "created_at",
        label: "Created time",
        field: "created_at",
        sortable: true,
    },
    { name: "actions", label: "Action", field: "actions", sortable: false },
];

const $q = useQuasar();

function btnAddClick() {
    window.location = route("category.create");
}

function btnEditClick(row) {
    window.location = route("category.edit", row.id);
}

function btnDeleteClick(row) {
    $q.dialog({
        title: "Confirm",
        message: `Would you like to remove [${row.name}]?`,
        cancel: true,
        persistent: true,
    }).onOk(() => {
        Loading.show();
        router.post(
            route("category.destroy", row.id),
            {
                _method: "delete",
                last: props.categories.total == props.categories.from,
            },
            {
                preserveState: false,
            }
        );
    });
}
</script>

<template>
    <Head title="Category" />
    <AuthenticatedLayout>
        <PageHead title="Category" @btn-add-click="btnAddClick" />
        <q-card class="!rounded-t-none lg:!rounded-t-sm">
            <app-table
                :rows="categories.data"
                :columns="columns"
                :pagination="categories.pagination"
                @btn-add-click="btnAddClick"
                @btn-edit-click="btnEditClick"
                @btn-delete-click="btnDeleteClick"
            >
                <template v-slot:filter="{ filter }">
                    <q-input
                        class="w-full md:w-auto"
                        filled
                        borderless
                        dense
                        debounce="300"
                        v-model="filter.name"
                        placeholder="Name"
                        clearable
                        clear-icon="close"
                    />
                </template>
            </app-table>
        </q-card>
    </AuthenticatedLayout>
</template>
