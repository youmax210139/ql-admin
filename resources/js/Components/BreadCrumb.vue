<template>
    <q-card class="flex !rounded-none p-2 items-center justify-center lg:!rounded-t-sm">
        <q-breadcrumbs>
            <q-breadcrumbs-el class="!text-gray-700" v-for="item in items" :key="item.label" :icon="item.icon"
                :label="item.label" :href="item.link" />
        </q-breadcrumbs>
    </q-card>
</template>
<script setup>
defineProps({
    items: {
        type: Array,
        default: []
    }
});
</script>