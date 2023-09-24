<script setup>
import { AppTable, PageHead } from "@/Components";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { useQuasar } from "quasar";

const props = defineProps({
    status: String,
    users: Object,
});

const columns = [
    { name: "name", label: "Name", field: "name", sortable: true },
    { name: "email", label: "Email", field: "email", sortable: true },
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
    window.location = route("user.create");
}

function btnEditClick(row) {
    window.location = route("user.edit", row.id);
}

function btnDeleteClick(row) {
    $q.dialog({
        title: "Confirm",
        message: `Would you like to remove [${row.name}]?`,
        cancel: true,
        persistent: true,
    }).onOk(() => {
        router.post(
            route("user.destroy", row.id),
            {
                _method: "delete",
                last: props.users.total == props.users.from,
            },
            {
                preserveState: false,
            }
        );
    });
}
</script>

<template>
    <Head title="User" />
    <AuthenticatedLayout>
        <PageHead title="User" @btn-add-click="btnAddClick" />
        <q-card class="!tw-rounded-t-none lg:!tw-rounded-t-sm">
            <AppTable
                :rows="users.data"
                :columns="columns"
                :pagination="users.pagination"
                @btn-add-click="btnAddClick"
                @btn-edit-click="btnEditClick"
                @btn-delete-click="btnDeleteClick"
            >
                <template v-slot:filter="{ filter }">
                    <q-input
                        class="tw-w-full md:tw-w-auto"
                        filled
                        borderless
                        dense
                        debounce="300"
                        v-model="filter.name"
                        placeholder="Name"
                        clearable
                        clear-icon="close"
                    />
                    <q-input
                        class="tw-w-full md:tw-w-auto"
                        filled
                        borderless
                        dense
                        debounce="300"
                        v-model="filter.email"
                        placeholder="Email"
                        clearable
                        clear-icon="close"
                    />
                </template>
            </AppTable>
        </q-card>
    </AuthenticatedLayout>
</template>
