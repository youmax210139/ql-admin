<template>

  <Head title="User" />
  <AuthenticatedLayout>
    <PageHead title="User" @btn-add-click="btnAddClick" />
    <q-card class="!rounded-t-none lg:!rounded-t-sm">
      <alert-success v-model="status" />
      <app-table :rows="users.data" :columns="columns" :pagination="users.pagination" @btn-add-click="btnAddClick"
        @btn-edit-click="btnEditClick" @btn-delete-click="btnDeleteClick">
        <template v-slot:filter="{ filter }">
          <q-input class="w-full md:w-auto" filled borderless dense debounce="300" v-model="filter.name"
            placeholder="Name" clearable clear-icon="close" />
          <q-input class="w-full md:w-auto" filled borderless dense debounce="300" v-model="filter.email"
            placeholder="Email" clearable clear-icon="close" />
        </template>
      </app-table>
    </q-card>
  </AuthenticatedLayout>
</template>

<script setup>
import { AlertSuccess, AlertError } from '@/Components/Alert';
import AppTable from '@/Components/AppTable.vue';
import PageHead from '@/Components/PageHead.vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
import { useQuasar } from "quasar";

const props = defineProps({
  status: String,
  users: Object
});

const columns = [
  { name: 'name', label: 'Name', field: "name", sortable: true },
  { name: 'email', label: 'Email', field: "email", sortable: true },
  { name: 'created_at', label: 'Created time', field: "created_at", sortable: true },
  { name: 'actions', label: 'Action', field: "actions", sortable: false },
]
const $q = useQuasar();

function btnAddClick() {
  window.location = route('users.create');
}

function btnEditClick(row) {
  window.location = route('users.edit', row.id);
}

function btnDeleteClick(row) {
  $q.dialog({
    title: 'Confirm',
    message: `Would you like to remove [${row.name}]?`,
    cancel: true,
    persistent: true
  }).onOk(() => {
    Inertia.post(route('users.destroy', row.id), {
      _method: "delete",
      last: props.users.total == props.users.from
    }, {
      preserveState: false
    });
  });
}
</script>