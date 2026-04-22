console.log('--- SUCCESS: Enhanced Wishlist Script Loaded ---');

// php artisan vendor:publish  --tag=public --force

import { createApp } from "vue";
import CompareCount from "./components/CompareCount.vue";
import WishlistCount from "./components/WishlistCount.vue";

const createEmitter = () => {
    const listeners = {};

    return {
        on(event, handler) {
            listeners[event] = listeners[event] ?? [];
            listeners[event].push(handler);
        },
        off(event, handler) {
            listeners[event] = (listeners[event] ?? []).filter((item) => item !== handler);
        },
        emit(event, payload) {
            (listeners[event] ?? []).forEach((handler) => handler(payload));
        },
    };
};

const emitter = window.emitter ?? createEmitter();
window.emitter = emitter;

const mountComponent = (selector, component, name) => {
    const targets = document.querySelectorAll(selector);

    if (! targets.length) {
        return;
    }

    targets.forEach((target) => {
        const app = createApp(component);
        app.config.globalProperties.$emitter = emitter;
        app.component(name, component);
        app.mount(target);
    });
};

mountComponent(".enhanced-wishlist-app", WishlistCount, "wishlist-count");
mountComponent(".enhanced-compare-app", CompareCount, "compare-count");

console.log('--- SUCCESS: Enhanced Wishlist & Compare Script Loaded ---');