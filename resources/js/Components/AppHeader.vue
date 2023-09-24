<script setup>
import { router } from "@inertiajs/vue3";
import { useQuasar, Loading } from "quasar";
import { useSidebarStore } from "@/Stores/sidebar";

const $q = useQuasar();
const store = useSidebarStore();

function logout() {
    Loading.show();
    router.post(route("logout"));
}
</script>

<template>
    <q-header reveal :class="$q.dark.isActive ? 'bg-black' : '!bg-gray-600'">
        <q-toolbar>
            <q-btn flat round dense icon="menu" @click="store.toggle()" />
            <q-toolbar-title>Admin Panel</q-toolbar-title>
            <q-btn
                class="mr-xs"
                flat
                round
                @click="$q.dark.toggle()"
                :icon="$q.dark.isActive ? 'nights_stay' : 'wb_sunny'"
            />
            <q-btn flat round dense icon="logout" @click="logout" />
        </q-toolbar>
    </q-header>
</template>
