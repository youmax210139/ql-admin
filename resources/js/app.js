import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, router } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createPinia } from "pinia";
import { Quasar, Loading, Dialog, Notify } from "quasar";
// Import icon libraries
import "@quasar/extras/material-icons/material-icons.css";

// Import Quasar css
import "quasar/src/css/index.sass";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

router.on("success", (e) => {
    console.log(e);
    let msg = "Success";
    switch (e.constructor) {
        case CustomEvent: {
            msg = e.detail.page.props.status;
            break;
        }
    }
    if (!msg) {
        return;
    }
    Notify.create({
        message: msg,
        type: "positive",
    });
});

router.on("error", (e) => {
    console.log(e);
    let msg = "Error";
    switch (e.constructor) {
        case CustomEvent: {
            msg = Object.values(e.detail.errors)[0];
            break;
        }
        // default:
        //     msg = Object.values(e)[0];
    }
    Notify.create({
        message: msg,
        type: "negative",
    });
});

router.on("finish", () => {
    Loading.hide();
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const myapp = createApp({ render: () => h(App, props) });
        myapp.use(plugin);
        myapp.use(ZiggyVue, Ziggy);
        const pinia = createPinia();
        myapp.use(pinia);
        myapp.use(Quasar, {
            plugins: {
                Loading,
                Dialog,
                Notify,
            },
            config: {
                notify: {
                    position: "center",
                    timeout: 2500,
                    textColor: "white",
                    actions: [{ icon: "close", color: "white" }],
                },
            },
        });
        myapp.mount(el);
        myapp.config.errorHandler = function (err, vm, info) {
            console.log(err);
            Notify.create({
                message: info,
                type: "negative",
            });
            Loading.hide();
        };

        return myapp;
    },
    progress: {
        color: "#4B5563",
    },
});
