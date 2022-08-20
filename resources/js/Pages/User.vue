<template>

  <Head title="User" />
  <AuthenticatedLayout>
    <q-card>
      <app-table :rows="users.data" :columns="columns" :pagination="users.pagination" @btn-add-click="btnAddClick">
        <template v-slot:filter="{ filter }">
          <q-input filled borderless dense debounce="300" v-model="filter.name" placeholder="Name" clearable
            clear-icon="close" />
          <q-input filled borderless dense debounce="300" v-model="filter.email" placeholder="Email" clearable
            clear-icon="close" />
        </template>
        <template v-slot:body-cell-actions="props">
          <q-td :props="props" class="q-gutter-x-sm">
            <q-btn icon="edit" size="md" color="secondary" flat dense @click="" />
            <q-btn icon="delete" size="md" color="negative" flat dense @click="" />
          </q-td>
        </template>
      </app-table>
    </q-card>
  </AuthenticatedLayout>
</template>

<script setup>
import { AlertSuccess, AlertError } from '@/Components/Alert';
import AppTable from '@/Components/AppTable.vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { ref } from "vue";
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
  console.log('hello world');
}

</script>