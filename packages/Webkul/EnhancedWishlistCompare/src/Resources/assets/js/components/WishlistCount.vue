<template>
    <div class="wishlist-badge">
        <span v-if="count > 0" class="count">{{ count }}</span>
    </div>
</template>

<script>
export default {
    data() {
        return {
            count: 0,
            onWishlistUpdated: null,
        };
    },
    mounted() {
        this.fetchCount();

        this.onWishlistUpdated = () => this.fetchCount();

        if (this.$emitter) {
            this.$emitter.on('after-wishlist-update', this.onWishlistUpdated);
        }
    },
    beforeUnmount() {
        if (this.$emitter && this.onWishlistUpdated) {
            this.$emitter.off('after-wishlist-update', this.onWishlistUpdated);
        }
    },
    methods: {
        async fetchCount() {
            try {
                const response = await axios.get('/api/enhanced/wishlist/count');
                this.count = response.data.count;
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
    min-width: 18px;
    height: 18px;
    align-items: center;
    justify-content: center;
    border-radius: 9999px;
    background: #ef4444;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    line-height: 1;
    padding: 0 5px;
}
</style>

