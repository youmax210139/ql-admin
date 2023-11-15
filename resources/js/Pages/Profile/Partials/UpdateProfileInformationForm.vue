<script setup>
import { Link, usePage, router } from "@inertiajs/vue3";
import { useForm } from "vee-validate";
import * as yup from "yup";

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const schema = yup.object({
    name: yup.string().required().label("Name"),
    email: yup.string().required().email().label("Email"),
});

const { meta, defineComponentBinds, handleSubmit, isSubmitting } = useForm({
    validationSchema: schema,
    initialValues: {
        ...props.user,
        _method: "PUT",
    },
});

const quasarConfig = (state) => ({
    props: {
        error: !!state.errors[0],
        "error-message": state.errors[0],
    },
});

const name = defineComponentBinds("name", quasarConfig);
const email = defineComponentBinds("email", quasarConfig);

const onSubmit = handleSubmit((form) => {
    Loading.show();
    router.post(route("profile.update", props.user.id), form);
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <q-form
            class="tw-grid tw-grid-col-1 tw-gap-y-4"
            @submit.prevent="onSubmit"
        >
            <q-input label="Name" type="text" v-bind="name" />
            <q-input label="Email" type="email" v-bind="email" />

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <q-btn
                    type="submit"
                    class="tw-ml-4 tw-bg-black tw-text-white"
                    label="Save"
                    :disable="!meta.valid || isSubmitting"
                />
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </q-form>
    </section>
</template>
