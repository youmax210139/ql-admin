<template>
    <q-card class="flex !rounded-b-none !rounded-t-sm p-2 items-center justify-center lg:!hidden">
        <h2 class="ml-4  text-2xl font-bold leading-7 text-gray-900">
            {{ title }} Page
        </h2>
        <q-btn v-show="btnAddShow" icon-right="add" label="Add" no-caps
            class="!bg-gray-700 text-white ml-auto md:!hidden" @click="$emit('btn-add-click')" />
    </q-card>
</template>
<script setup>
defineProps({
    title: {
        type: String,
        required: true
    },
    btnAddShow: {
        type: Boolean,
        default: true
    }
});
</script>