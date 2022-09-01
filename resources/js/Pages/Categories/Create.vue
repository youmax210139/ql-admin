<template>

  <Head title="Create Category" />
  <AuthenticatedLayout>
    <page-head
      title="Create Category"
      :btnAddShow="false"
    />
    <bread-crumb :items="breadCrumbs" />
    <q-card class="w-full p-4 bg-white shadow-md overflow-hidden !rounded-t-none rounded-b-sm">
      <q-form
        class="grid grid-col-1 gap-y-4"
        @submit.prevent="submit"
        ref="form$"
      >
        <alert-success
          v-model="form.recentlySuccessful"
          :message="status"
        />
        <alert-error v-model="form.errors.name" />
        <q-input
          label="Name"
          type="text"
          v-model="form.name"
          lazy-rules
          :rules="[
            $rules.required('Name is required'),
          ]"
        />
        <div class="flex items-center justify-end">
          <q-btn
            type="submit"
            class="ml-4 bg-black text-white"
            label="Submit"
            :disabled="form.processing"
          />
        </div>
      </q-form>
    </q-card>
  </AuthenticatedLayout>
</template>

<script setup>
import { AlertSuccess, AlertError, PageHead, BreadCrumb } from '@/Components';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref } from "vue";
import { useQuasar } from "quasar";

const props = defineProps({
  status: String,
});

const breadCrumbs = [
  { label: "", icon: "home", link: route('index') },
  { label: "Categories", icon: "category", link: route('categories.index') },
];

const $q = useQuasar();
const form$ = ref(null);
const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form$.value.validate();
  form.clearErrors();
  $q.loading.show();
  form.post(route('categories.store'), {
    onFinish: () => $q.loading.hide(),
  });
};
</script>