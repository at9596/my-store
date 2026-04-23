import WishlistCount from "./components/WishlistCount.vue";
import CompareCount from "./components/CompareCount.vue";

/**
 * Register components on the main Bagisto application.
 * Bagisto v2 uses a global window.app instance.
 * 
 * Note: By registering here, we become part of the main reactivity system.
 * The Blade templates now use <wishlist-count> and <compare-count> tags directly.
 */
const integrateWithMainApp = () => {
    if (window.app) {
        window.app.component("wishlist-count", WishlistCount);
        window.app.component("compare-count", CompareCount);
    } else {
        // Fallback or wait for window.app to be available
        setTimeout(integrateWithMainApp, 50);
    }
};

// Start integration
integrateWithMainApp();
