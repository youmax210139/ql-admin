<template>
    <q-drawer v-model="leftDrawerOpen" show-if-above elevated side="left">
        <div class="h-full" :class="$q.dark.isActive ? 'bg-black text-white' : 'bg-white text-black'">
            <Link :href="route('dashboard')" class="flex items-center px-6 py-4">
                <app-logo class="mr-3 w-6 h-6 sm:h-8 sm:w-8 filter-white" alt="Logo" />
                <span class="ml-3 text-xl font-semibold whitespace-nowrap">{{ $page.props.appName }}</span>
            </Link>
            <q-scroll-area class="h-screen">
                <q-list>
                    <q-item v-for="(item, k) in menus" :key="k" active-class="tab-active"
                        class="q-ma-sm navigation-item" clickable v-ripple>
                        <q-item-section avatar>
                            <q-icon :name="item.icon" />
                        </q-item-section>
                        <q-item-section>
                            {{ item.title }}
                        </q-item-section>
                    </q-item>
                </q-list>
            </q-scroll-area>
        </div>
    </q-drawer>
</template>
<script setup>
import { ref, computed } from 'vue';
import AppLogo from '@/Components/AppLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';

const leftDrawerOpen = ref(true);
const menus = ref([
    { icon: "dashboard", title: "Home" },
    { icon: "person", title: "Profile" },
]);
</script>
<style lang="scss" scoped>
.bg-black.text-white {
    .filter-white {
        filter: invert(100%) sepia(10%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);
    }
}
</style>
