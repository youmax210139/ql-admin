<template>
    <q-uploader
        v-bind="props"
        class="!w-full"
        @added="(e) => $emit('update:modelValue', e)"
        @removed="(e) => $emit('update:modelValue', e)"
    >
        <template v-slot:header="scope">
            <div class="row no-wrap items-center p-2 q-gutter-xs bg-gray-600">
                <q-btn
                    v-if="scope.queuedFiles.length > 0"
                    icon="playlist_remove"
                    @click="scope.removeQueuedFiles"
                    round
                    dense
                    flat
                >
                    <q-tooltip>Clear All</q-tooltip>
                </q-btn>
                <q-btn
                    v-if="scope.uploadedFiles.length > 0"
                    icon="done_all"
                    @click="scope.removeUploadedFiles"
                    round
                    dense
                    flat
                >
                    <q-tooltip>Remove Uploaded Files</q-tooltip>
                </q-btn>
                <q-spinner
                    v-if="scope.isUploading"
                    class="q-uploader__spinner"
                />
                <div class="col">
                    <div class="q-uploader__title">Upload your files</div>
                    <div class="q-uploader__subtitle">
                        {{ scope.uploadSizeLabel }} /
                        {{ scope.uploadProgressLabel }}
                    </div>
                </div>
                <q-btn
                    v-if="scope.canAddFiles"
                    type="a"
                    icon="add_box"
                    @click="scope.pickFiles"
                    round
                    dense
                    flat
                >
                    <q-uploader-add-trigger />
                    <q-tooltip>Pick Files</q-tooltip>
                </q-btn>
                <q-btn
                    v-if="props.url && scope.canUpload"
                    icon="cloud_upload"
                    @click="scope.upload"
                    round
                    dense
                    flat
                >
                    <q-tooltip>Upload Files</q-tooltip>
                </q-btn>
                <q-btn
                    v-if="scope.isUploading"
                    icon="clear"
                    @click="scope.abort"
                    round
                    dense
                    flat
                >
                    <q-tooltip>Abort Upload</q-tooltip>
                </q-btn>
            </div>
        </template>
        <template v-slot:list="scope">
            <q-list separator>
                <q-item
                    v-for="file in props.preview?.filter((v) => !v.__removed)"
                    :key="file.__key"
                >
                    <q-item-section>
                        <q-item-label class="full-width ellipsis">
                            {{ file.name }}
                        </q-item-label>
                        <q-item-label caption>
                            {{ file.__sizeLabel }}
                        </q-item-label>
                    </q-item-section>

                    <q-item-section v-if="file.__img" thumbnail>
                        <img
                            :src="file.__img.src"
                            class="!min-h-full !h-auto"
                        />
                    </q-item-section>

                    <q-item-section side>
                        <q-btn
                            size="12px"
                            flat
                            dense
                            round
                            icon="delete"
                            @click="file.__removed = true"
                        />
                    </q-item-section>
                </q-item>
                <q-item v-for="file in scope.files" :key="file.__key">
                    <q-item-section>
                        <q-item-label class="full-width ellipsis">
                            {{ file.name }}
                        </q-item-label>
                        <q-item-label caption>
                            {{ file.__sizeLabel }}
                        </q-item-label>
                    </q-item-section>

                    <q-item-section v-if="file.__img" thumbnail>
                        <img
                            :src="file.__img.src"
                            class="!min-h-full !h-auto"
                        />
                    </q-item-section>

                    <q-item-section side>
                        <q-btn
                            size="12px"
                            flat
                            dense
                            round
                            icon="delete"
                            @click="scope.removeFile(file)"
                        />
                    </q-item-section>
                </q-item>
            </q-list>
        </template>
    </q-uploader>
</template>
<script setup>
const props = defineProps({
    modelValue: {
        type: Array,
        default: [],
    },
    preview: {
        type: Array,
        default: [],
    },
    accept: {
        type: String,
        default: ".jpg,.png",
    },
    label: {
        type: String,
        default: "Pick one file",
    },
    clearable: {
        type: Boolean,
        default: true,
    },
    maxFiles: {
        type: [Number, String],
        default: 5,
    },
    maxFileSize: {
        type: [Number, String],
        default: 5 * 1024 * 1024,
    },
    maxTotalSize: {
        type: [Number, String],
        default: 25 * 1024 * 1024,
    },
    multiple: {
        type: Boolean,
        default: true,
    },
    flat: {
        type: Boolean,
        default: true,
    },
});
</script>
