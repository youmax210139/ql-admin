<template>

  <Head title="Profile" />
  <AuthenticatedLayout>
    <q-card>
      <q-item class="!p-4">
        <q-item-section avatar>
          <img class="w-28 h-28 !rounded-lg" src="avatar.png">
        </q-item-section>
        <q-item-section>
          <q-item-label class="text-2xl text-bold">
            {{ $page.props.auth.user.name }}
          </q-item-label>
          <q-item-label class="text-lg">
            {{ $page.props.auth.user.email }}
          </q-item-label>
        </q-item-section>
      </q-item>
    </q-card>

    <q-card class="mt-6">
      <q-form ref="form$" @submit.prevent="submit" class="p-4 grid grid-col-1 gap-y-4">
        <alert-error v-model="form.errors.password" />
        <alert-error v-model="form.errors.password_confirmation" />
        <alert-success v-model="form.recentlySuccessful" :message="status" />
        <q-input label="Password" type="password" v-model="form.password" lazy-rules :rules="[
          $rules.required('Password is required'),
        ]" />

        <q-input label="Confirm Password" type="password" v-model="form.password_confirmation" lazy-rules :rules="[
          $rules.required('Confirm Password is required'),
          $rules.sameAs(form.password, 'Confirm Password should be same as password field'),
        ]" />

        <div class="flex items-center justify-end">
          <q-btn type="submit" label="Save" class="!bg-gray-700 text-white" :disabled="form.processing" />
        </div>
      </q-form>
    </q-card>
  </AuthenticatedLayout>
</template>

<script setup>
import { AlertSuccess, AlertError } from '@/Components/Alert';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { ref } from "vue";
import { useQuasar } from "quasar";

defineProps({
  status: String,
});

const $q = useQuasar();
const form$ = ref(null);
const form = useForm({
  password: '',
  password_confirmation: '',
});

function submit() {
  form$.value.validate();
  form.clearErrors();
  $q.loading.show();
  form.post(route('profiles.store'), {
    onFinish: () => $q.loading.hide(),
  });
}

</script>