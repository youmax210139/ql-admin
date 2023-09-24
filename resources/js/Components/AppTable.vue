<script setup>
import { ref } from "vue";

const filter = ref({ ...route().params.filter });

const props = defineProps({
    rows: {
        type: Array,
        default: [],
    },
    columns: {
        type: Array,
        default: ["Name"],
    },
    rowKey: {
        type: String,
        default: "id",
    },
    rowsPerPageOptions: {
        type: Array,
        default: [10, 20, 0],
    },
    selection: {
        type: String,
        default: "none",
    },
    loading: {
        type: Boolean,
        default: false,
    },
    binaryStateSort: {
        type: Boolean,
        default: true,
    },
    paginationLabel: {
        type: Function,
        default: (firstRowIndex, endRowIndex, totalRowsNumber) => {
            return `${firstRowIndex}-${endRowIndex} of ${totalRowsNumber}`;
        },
    },
    filter: {
        type: [String, Object],
        default: null,
    },
    filterMethod: {
        type: Function,
        default(rows, terms, cols, getCellValue) {},
    },
    onRequest: {
        type: Function,
        default: function (requestProp) {
            const parser = new URL(window.location);
            const pagination = requestProp.pagination;
            parser.searchParams.set("page", pagination.page);
            parser.searchParams.set("perPage", pagination.rowsPerPage);
            parser.searchParams.set(
                "sort",
                (pagination.descending ? "-" : "") + pagination.sortBy
            );
            for (const [key, value] of Object.entries(requestProp.filter)) {
                parser.searchParams.set(`filter[${key}]`, value || "");
            }
            window.location = parser.href;
        },
    },
});
</script>

<style lang="scss" scoped>
.q-table__container:deep(.q-table__top) {
    padding-left: 0px;
    padding-right: 0px;

    .q-table__separator.col {
        display: none;
    }

    .q-table__control {
        width: 100%;
    }
}

.q-table__container:deep(.q-table__bottom) {
    font-size: 1rem;
    line-height: 1.5rem;
}

@media (min-width: 768px) {
    .md\:\!tw-inline-flex {
        display: inline-flex !important;
    }

    .q-table__container:deep(.q-table__bottom) {
        font-size: 12px;
    }
}
</style>

<template>
    <q-table
        v-bind="props"
        :dense="$q.screen.lt.md"
        :grid="$q.screen.lt.sm"
        :filter="props.filter || filter"
        class="tw-p-2 !tw-text-base"
    >
        <template v-slot:loading>
            <q-inner-loading showing />
        </template>

        <template v-slot:no-data="{ message }">
            <div v-if="!loading" class="tw-w-full tw-p-4 tw-text-center">
                <span>{{ message }}</span>
            </div>
        </template>

        <template v-slot:top-right v-bind="props">
            <div
                class="tw-grid tw-gap-2 tw-flex tw-items-center tw-justify-center tw-w-full md:tw-flex md:!tw-justify-end md:tw-q-gutter-sm"
            >
                <slot name="filter" :filter="filter">
                    <q-input
                        filled
                        borderless
                        dense
                        debounce="300"
                        placeholder="Search"
                        v-model="filter.name"
                        clearable
                        clear-icon="close"
                    >
                        <template v-slot:append>
                            <q-icon name="search" />
                        </template>
                    </q-input>
                </slot>
                <slot name="top-right-buttons">
                    <q-btn
                        icon-right="add"
                        label="Add"
                        no-caps
                        class="!tw-bg-gray-700 tw-text-white tw-hidden md:!tw-inline-flex"
                        @click="$emit('btn-add-click')"
                    />
                </slot>
            </div>
        </template>

        <template v-slot:body-cell-status="props">
            <q-td :props="props">
                <q-badge
                    rounded
                    :color="props.value ? 'teal' : 'grey-13'"
                    :label="props.value ? 'Active' : 'Inactive'"
                />
            </q-td>
        </template>

        <template #body-cell-actions="props">
            <q-td :props="props" class="q-gutter-x-sm">
                <slot name="actions" v-bind="props">
                    <q-btn
                        icon="edit"
                        size="md"
                        color="secondary"
                        flat
                        dense
                        @click="$emit('btn-edit-click', props.row)"
                    />
                    <q-btn
                        icon="delete"
                        size="md"
                        color="negative"
                        flat
                        dense
                        @click="$emit('btn-delete-click', props.row)"
                    />
                </slot>
            </q-td>
        </template>

        <template #item="props">
            <q-card class="tw-w-full tw-my-2 !tw-text-base">
                <q-list>
                    <q-item
                        v-for="col in props.cols.filter(
                            (col) => col.name !== 'actions'
                        )"
                        :key="col.name"
                    >
                        <q-item-section :class="col.classes">
                            <q-item-label>{{ col.label }}</q-item-label>
                        </q-item-section>
                        <q-item-section side>
                            <q-item-label>{{ col.value }}</q-item-label>
                        </q-item-section>
                    </q-item>
                    <q-item>
                        <q-item-section>
                            <q-item-label>Actions</q-item-label>
                        </q-item-section>
                        <q-item-section>
                            <div class="tw-text-right q-gutter-x-md">
                                <slot name="actions" v-bind="props">
                                    <q-btn
                                        icon="edit"
                                        size="md"
                                        color="secondary"
                                        flat
                                        dense
                                        round
                                        @click="
                                            $emit('btn-edit-click', props.row)
                                        "
                                    />
                                    <q-btn
                                        icon="delete"
                                        size="md"
                                        color="negative"
                                        flat
                                        dense
                                        round
                                        @click="
                                            $emit('btn-delete-click', props.row)
                                        "
                                    />
                                </slot>
                            </div>
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-card>
        </template>

        <template v-for="slot in Object.keys($slots)" v-slot:[slot]="props">
            <slot :name="slot" v-bind="props" />
        </template>
    </q-table>
</template>
