<template>
    <div class="compare-badge">
        <span v-if="count > 0" class="count">{{ count }}</span>
    </div>
</template>

<script>
export default {
    data() {
        return {
            count: 0,
            onCompareUpdated: null,
        };
    },

    mounted() {
        this.fetchCount();

        this.onCompareUpdated = () => this.fetchCount();

        if (this.$emitter) {
            this.$emitter.on('after-compare-update', this.onCompareUpdated);
            this.$emitter.on('compare-updated', this.onCompareUpdated);
        }
    },

    beforeUnmount() {
        if (this.$emitter && this.onCompareUpdated) {
            this.$emitter.off('after-compare-update', this.onCompareUpdated);
            this.$emitter.off('compare-updated', this.onCompareUpdated);
        }
    },

    methods: {
        async fetchCount() {
            try {
                const response = await axios.get('/api/enhanced/compare/count');
                this.count = response.data.count;
            } catch (error) {
                console.error("Error fetching compare count", error);
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
    background: #111827;
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    line-height: 1;
    padding: 0 5px;
}
</style>