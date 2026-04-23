<template>
    <div 
        class="wishlist-badge inline-flex"
        :class="{'pill': isPill, 'hidden': count <= 0}"
    >
        <span v-if="count > 0" :class="isPill ? '' : 'count'">
            {{ count }} 
            <template v-if="showText">
                {{ count == 1 ? 'Item' : 'Items' }}
            </template>
        </span>
    </div>
</template>

<script>
export default {
    props: {
        showText: {
            type: Boolean,
            default: false
        },
        isPill: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            count: parseInt(localStorage.getItem('enhanced_wishlist_count')) || 0,
        };
    },

    mounted() {
        this.fetchCount();
         
        this.onWishlistUpdated = (data) => {
            let next = null;

            if (data && typeof data === "object") {
                if (typeof data.count === "number") {
                    next = data.count;
                } else if (typeof data.wishlist_count === "number") {
                    next = data.wishlist_count;
                }
            }

            if (next !== null) {
                this.updateCount(next);
            } else {
                this.fetchCount();
            }
        };

        const emitter = this.$emitter || window.emitter;

        if (emitter) {
            emitter.on("after-wishlist-update", this.onWishlistUpdated);
            emitter.on("wishlist-updated", this.onWishlistUpdated);
        }

        window.addEventListener('storage', this.handleStorageEvent);
    },

    beforeUnmount() {
        const emitter = this.$emitter || window.emitter;

        if (emitter && this.onWishlistUpdated) {
            emitter.off("after-wishlist-update", this.onWishlistUpdated);
            emitter.off("wishlist-updated", this.onWishlistUpdated);
        }

        window.removeEventListener('storage', this.handleStorageEvent);
    },

    methods: {
        updateCount(newCount) {
            if (this.count === newCount) return;

            this.count = newCount;
            localStorage.setItem('enhanced_wishlist_count', newCount);
        },

        handleStorageEvent(event) {
            if (event.key === 'enhanced_wishlist_count') {
                const newCount = parseInt(event.newValue) || 0;
                this.count = newCount;
            }
        },

        async fetchCount() {
            try {
                // Use global axios if available, otherwise fallback
                const axiosInstance = this.$axios || window.axios;
                
                const response = await axiosInstance.get('/api/enhanced/wishlist/count', {
                    params: { _: Date.now() }
                });

                const count = response?.data?.count ?? 0;
                this.updateCount(count);
            } catch (error) {
                console.error("Error fetching wishlist count", error);
            }
        }
    }
};
</script>

<style scoped>
.count {
    display: inline-flex;
    border-radius: 44px;
    background: #060C3B;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    line-height: 9px;
    padding: 6px 8px;
}

.pill {
    background: #FDE68A;
    color: #92400E;
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 500;
    line-height: 1;
}
</style>
