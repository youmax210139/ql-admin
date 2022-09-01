<template>
    <div>
        <q-file v-model="image" label="Pick one file" filled style="max-width: 300px" @change="updateFile()" />
    </div>
    <div>
        <q-img :src="imageUrl" spinner-color="white" style="height: 140px; max-width: 150px" />
    </div>
</template>
<script setup>
import { ref } from 'vue';
const image = ref(null);
const imageUrl = ref('');

function updateFile() {
    imageUrl.value = URL.createObjectURL(image.value);
}
</script>