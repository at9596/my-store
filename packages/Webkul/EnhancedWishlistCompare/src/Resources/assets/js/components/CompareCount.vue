<template>
    <div class="compare-badge">
        <span v-if="count > 0" class="count">{{ count }}</span>
    </div>
</template>

<script>
export default {
    data() {
        return {
            count: 0
        }
    },

    mounted() {
        console.log("✅ CompareCount mounted");

        this.fetchCount();

        this.$emitter.on('after-compare-update', () => {
            console.log("🎯 EVENT RECEIVED");
            this.fetchCount();
        });
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
}
</script>