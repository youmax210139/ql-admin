<script setup>
import { ref } from "vue";
import { ApplicationLogo } from "@/Components";
import { Link } from "@inertiajs/vue3";
import { useSidebarStore } from "@/Stores/sidebar";

const store = useSidebarStore();
const menus = ref([
    { icon: "dashboard", title: "Home", link: "dashboard.index" },
    {
        icon: "diversity_3",
        title: "User",
        link: "user.index",
        params: { perPage: 10 },
    },
    {
        icon: "category",
        title: "Category",
        link: "category.index",
        params: { perPage: 10 },
    },
    {
        icon: "inventory_2",
        title: "Product",
        link: "product.index",
        params: { perPage: 10 },
    },
]);
</script>

<template>
    <q-drawer v-model="store.show" show-if-above elevated side="left">
        <div
            class="tw-h-full"
            :class="
                $q.dark.isActive
                    ? 'tw-bg-black tw-text-white'
                    : 'tw-bg-white tw-text-black'
            "
        >
            <Link href="/" class="tw-flex tw-items-center tw-px-6 tw-py-4">
                <ApplicationLogo
                    class="tw-mr-3 tw-w-6 tw-h-6 sm:tw-h-8 sm:tw-w-8"
                    alt="Logo"
                />
                <span
                    class="tw-ml-3 tw-text-xl tw-font-semibold tw-whitespace-nowrap"
                    >{{ $appName }}</span
                >
            </Link>
            <q-scroll-area class="tw-h-screen">
                <q-list>
                    <q-item
                        v-for="(item, k) in menus"
                        :key="k"
                        active-class="tw-tab-active"
                        class="q-ma-sm tw-navigation-item"
                        :href="route(item.link, item.params)"
                        :class="{
                            'tw-bg-green-800 tw-rounded-sm tw-text-white':
                                route().current() == item.link,
                        }"
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
