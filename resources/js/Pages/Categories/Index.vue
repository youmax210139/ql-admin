<template>

  <Head title="Category" />
  <AuthenticatedLayout>
    <PageHead title="Category" @btn-add-click="btnAddClick" />
    <q-card class="!rounded-t-none lg:!rounded-t-sm">
      <app-table :rows="categories.data" :columns="columns" :pagination="categories.pagination" @btn-add-click="btnAddClick"
        @btn-edit-click="btnEditClick" @btn-delete-click="btnDeleteClick">
        <template v-slot:filter="{ filter }">
          <q-input class="w-full md:w-auto" filled borderless dense debounce="300" v-model="filter.name"
            placeholder="Name" clearable clear-icon="close" />
        </template>
      </app-table>
    </q-card>
  </AuthenticatedLayout>
</template>

<script setup>
import AppTable from '@/Components/AppTable.vue';
import PageHead from '@/Components/PageHead.vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia'
import { useQuasar } from "quasar";

const props = defineProps({
  status: String,
  categories: Object
});

const columns = [
  { name: 'name', label: 'Name', field: "name", sortable: true },
  { name: 'created_at', label: 'Created time', field: "created_at", sortable: true },
  { name: 'actions', label: 'Action', field: "actions", sortable: false },
]
const $q = useQuasar();

function btnAddClick() {
  window.location = route('categories.create');
}

function btnEditClick(row) {
  window.location = route('categories.edit', row.id);
}

function btnDeleteClick(row) {
  $q.dialog({
    title: 'Confirm',
    message: `Would you like to remove [${row.name}]?`,
    cancel: true,
    persistent: true
  }).onOk(() => {
    Inertia.post(route('categories.destroy', row.id), {
      _method: "delete",
      last: props.categories.total == props.categories.from
    }, {
      preserveState: false
    });
  });
}
</script>