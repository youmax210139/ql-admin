<template>
    <q-drawer
        v-model="store.show"
        show-if-above
        elevated
        side="left"
    >
        <div
            class="h-full"
            :class="$q.dark.isActive ? 'bg-black text-white' : 'bg-white text-black'"
        >
            <Link
                :href="route('index')"
                class="flex items-center px-6 py-4"
            >
            <app-logo
                class="mr-3 w-6 h-6 sm:h-8 sm:w-8 filter-white"
                alt="Logo"
            />
            <span class="ml-3 text-xl font-semibold whitespace-nowrap">{{ $page.props.appName }}</span>
            </Link>
            <q-scroll-area class="h-screen">
                <q-list>
                    <q-item
                        v-for="(item, k) in menus"
                        :key="k"
                        active-class="tab-active"
                        class="q-ma-sm navigation-item"
                        :href="route(item.link, item.params)"
                        :class="{ 'bg-green-800 rounded-sm text-white': route().current() == item.link }"
                        clickable
                        v-ripple
                    >
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
import { ref } from 'vue';
import AppLogo from '@/Components/AppLogo.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { useSidebarStore } from '@/Stores/sidebar';

const store = useSidebarStore();
const menus = ref([
    { icon: "dashboard", title: "Home", link: 'index' },
    { icon: "account_circle", title: "Profile", link: 'profiles.index' },
    { icon: "diversity_3", title: "User", link: 'users.index', params: { perPage: 10 } },
    { icon: "category", title: "Categories", link: 'categories.index', params: { perPage: 10 } },
    { icon: "inventory_2", title: "Products", link: 'products.index', params: { perPage: 10 } },
]);
</script>
<style lang="scss" scoped>
.bg-black.text-white {
    .filter-white {
        filter: invert(100%) sepia(10%) saturate(0%) hue-rotate(0deg) brightness(100%) contrast(100%);
    }
}
</style>
