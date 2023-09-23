<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { useQuasar, Notify } from "quasar";
import { useForm } from "vee-validate";
import * as yup from "yup";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
const $q = useQuasar();

const schema = yup.object({
    email: yup.string().required().email().label("Email address"),
    password: yup.string().required().min(6).label("Password"),
    remember: yup.boolean().label("Remember"),
});

const { meta, defineComponentBinds, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        email: "",
        password: "",
        remember: false,
    },
});

const quasarConfig = (state) => ({
    props: {
        error: !!state.errors[0],
        "error-message": state.errors[0],
    },
});
const email = defineComponentBinds("email", quasarConfig);
const password = defineComponentBinds("password", quasarConfig);
const remember = defineComponentBinds("remember", quasarConfig);

const onSubmit = handleSubmit((form) => {
    $q.loading.show();
    router.post(route("login"), form, {
        onFinish: () => {
            $q.loading.hide();
        },
        onError(err) {
            Notify.create({
                message: Object.values(err)[0],
                type: "negative",
            });
        },
    });
});
</script>

<template>
    <Head title="Login" />
    <GuestLayout>
        <q-card
            class="w-full sm:max-w-md p-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <q-card-section>
                <h3 class="text-sm text-center">Log in</h3>
            </q-card-section>
            <q-card-section>
                <q-form
                    class="grid grid-col-1 gap-y-4"
                    @submit.prevent="onSubmit"
                >
                    <q-input v-bind="email" label="Email" />
                    <q-input
                        v-bind="password"
                        label="Password"
                        type="password"
                    />
                    <q-checkbox v-bind="remember" label="Remember me" />
                    <div class="text-right">
                        <a
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="mr-4 underline underline-offset-1 hover:cursor-pointer"
                        >
                            Forgot your password?
                        </a>
                        <q-btn
                            label="Log in"
                            type="submit"
                            :disable="!meta.valid || isSubmitting"
                            class="bg-black text-white"
                        />
                    </div>
                </q-form>
            </q-card-section>
        </q-card>
    </GuestLayout>
</template>
