<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    btnAddShow: {
        type: Boolean,
        default: true,
    },
});
</script>
<template>
    <q-card
        class="tw-flex !tw-rounded-b-none !tw-rounded-t-sm tw-px-2 tw-py-4 tw-items-center tw-justify-center lg:!tw-hidden"
    >
        <h2
            class="tw-ml-4 tw-text-2xl tw-font-bold tw-leading-7 tw-text-gray-900"
        >
            {{ title }} Page
        </h2>
        <q-btn
            v-show="btnAddShow"
            icon-right="add"
            label="Add"
            no-caps
            class="!tw-bg-gray-700 tw-text-white tw-ml-auto md:!tw-hidden"
            @click="$emit('btn-add-click')"
        />
    </q-card>
</template>
