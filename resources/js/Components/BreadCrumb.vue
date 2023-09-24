<script setup>
defineProps({
    items: {
        type: Array,
        default: [],
    },
});
</script>
<template>
    <q-card
        class="tw-flex !tw-rounded-none tw-p-2 tw-items-center tw-justify-center lg:!tw-rounded-t-sm"
    >
        <q-breadcrumbs>
            <q-breadcrumbs-el
                class="!tw-text-gray-700"
                v-for="item in items"
                :key="item.label"
                :icon="item.icon"
                :label="item.label"
                :href="item.link"
            />
        </q-breadcrumbs>
    </q-card>
</template>
