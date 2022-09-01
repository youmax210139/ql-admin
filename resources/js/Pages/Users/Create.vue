<template>

  <Head title="Create User" />
  <AuthenticatedLayout>
    <page-head
      title="Create User"
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
        <alert-error v-model="form.errors.email" />
        <q-input
          label="Name"
          type="text"
          v-model="form.name"
          lazy-rules
          :rules="[
            $rules.required('Name is required'),
          ]"
        />
        <q-input
          label="Email"
          type="email"
          v-model="form.email"
          lazy-rules
          :rules="[
            $rules.required('Email is required'),
            $rules.email('should be email format'),
          ]"
        />
        <q-input
          label="Password"
          type="password"
          v-model="form.password"
          lazy-rules
          :rules="[
            $rules.required('Password is required'),
          ]"
        />
        <q-input
          label="Confirm Password"
          type="password"
          v-model="form.password_confirmation"
          lazy-rules
          :rules="[
            $rules.required('Confirm Password is required'),
            $rules.sameAs(form.password, 'Confirm Password should be same as password field'),
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
  { label: "Users", icon: "diversity_3", link: route('users.index') },
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
  form.post(route('users.store'), {
    onFinish: () => $q.loading.hide(),
  });
};
</script>