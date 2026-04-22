console.log('--- SUCCESS: Enhanced Wishlist Loaded ---');

import CompareCount from './components/CompareCount.vue';


// ✅ register into existing app
if (window.app) {
    window.app.component('compare-count', CompareCount);
}