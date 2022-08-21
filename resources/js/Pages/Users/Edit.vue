<template>

  <Head title="Edit User" />
  <AuthenticatedLayout>
    <page-head title="Edit User" :btnAddShow="false" />
    <bread-crumb :items="breadCrumbs" />
    <q-card class="w-full p-4 bg-white shadow-md overflow-hidden !rounded-t-none rounded-b-sm">
      <q-form class="grid grid-col-1 gap-y-4" @submit.prevent="submit" ref="form$">
        <alert-success v-model="status" />
        <alert-error v-model="form.errors.name" />
        <alert-error v-model="form.errors.email" />

        <q-input label="Name" type="text" v-model="form.name" lazy-rules :rules="[
          $rules.required('Name is required'),
        ]" />

        <q-input label="Email" type="email" v-model="form.email" lazy-rules :rules="[
          $rules.required('Email is required'),
          $rules.email('should be email format'),
        ]" />

        <div class="flex items-center justify-end">
          <q-btn type="submit" class="ml-4 bg-black text-white" label="Save" :disabled="form.processing" />
        </div>
      </q-form>
    </q-card>
  </AuthenticatedLayout>
</template>

<script setup>
import { AlertSuccess, AlertError } from '@/Components/Alert';
import PageHead from '@/Components/PageHead.vue';
import BreadCrumb from '@/Components/BreadCrumb.vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref } from "vue";
import { useQuasar } from "quasar";

const props = defineProps({
  status: String,
  user: Object
});

const breadCrumbs = [
  { label: "", icon: "home", link: route('index') },
  { label: "Users", icon: "diversity_3", link: route('users.index') },
];

const $q = useQuasar();
const form$ = ref(null);
const form = useForm({
  name: props.user.name,
  email: props.user.email,
});

const submit = () => {
  form$.value.validate();
  form.clearErrors();
  $q.loading.show();
  form.put(route('users.update', props.user.id), {
    onFinish: () => $q.loading.hide(),
  });
};
</script>