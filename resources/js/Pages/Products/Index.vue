<template>

  <Head title="Product" />
  <AuthenticatedLayout>
    <PageHead title="Product" @btn-add-click="btnAddClick" />
    <q-card class="!rounded-t-none lg:!rounded-t-sm">
      <app-table :rows="products.data" :columns="columns" :pagination="products.pagination"
        @btn-add-click="btnAddClick">
        <template v-slot:filter="{ filter }">
          <q-input class="w-full md:w-auto" filled borderless dense debounce="300" v-model="filter.name"
            placeholder="Name" clearable clear-icon="close" />
          <q-input class="w-full md:w-auto" filled borderless dense debounce="300" v-model="filter.title"
            placeholder="Title" clearable clear-icon="close" />
        </template>
        <template #actions="props">
          <q-btn icon="edit" size="md" color="secondary" flat dense @click="btnEditClick(props.row)" />
          <q-btn icon="delete" size="md" color="negative" flat dense round @click="btnDeleteClick(props.row)" />
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
  products: Object
});

const columns = [
  { name: 'name', label: 'Name', field: "name", sortable: true },
  { name: 'title', label: 'Title', field: "title", sortable: true },
  { name: 'description', label: 'Description', field: "description", sortable: false, classes: "text-ellipsis overflow-hidden max-w-xs" },
  { name: 'price', label: 'Price', field: "price", sortable: true },
  { name: 'published_at', label: 'Published time', field: "published_at", sortable: true },
  { name: 'created_at', label: 'Created time', field: "created_at", sortable: true },
  { name: 'actions', label: 'Action', field: "actions", sortable: false },
]
const $q = useQuasar();

function btnAddClick() {
  window.location = route('products.create');
}

function btnEditClick(row) {
  window.location = route('products.edit', row.id);
}

function btnDeleteClick(row) {
  $q.dialog({
    title: 'Confirm',
    message: `Would you like to remove [${row.name}]?`,
    cancel: true,
    persistent: true
  }).onOk(() => {
    Inertia.post(route('products.destroy', row.id), {
      _method: "delete",
      last: props.products.total == props.products.from
    }, {
      preserveState: false
    });
  });
}
</script>