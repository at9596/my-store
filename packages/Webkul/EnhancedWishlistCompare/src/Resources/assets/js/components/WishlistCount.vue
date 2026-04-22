<template>
    <div class="wishlist-badge">
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
        this.fetchCount();
        
        
        if (window.emitter) {
            window.emitter.on('after-wishlist-update', () => {
                this.fetchCount();
            });
        }
    },
    methods: {
        async fetchCount() {
            try {
                const response = await axios.get('/enhanced/wishlist/count');
                this.count = response.data.count;
            } catch (error) {
                console.error("Error fetching wishlist count", error);
            }
        }
    }
}
</script>

