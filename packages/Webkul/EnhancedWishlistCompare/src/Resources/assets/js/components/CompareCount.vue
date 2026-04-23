<template>
    <div 
        class="compare-badge inline-flex"
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
            count: parseInt(localStorage.getItem('enhanced_compare_count')) || 0,
        };
    },

    mounted() {
        this.fetchCount();

        this.onCompareUpdated = (data) => {
            let next = null;

            if (data && typeof data === "object") {
                if (typeof data.count === "number") {
                    next = data.count;
                } else if (typeof data.compare_count === "number") {
                    next = data.compare_count;
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
            emitter.on("after-compare-update", this.onCompareUpdated);
            emitter.on("compare-updated", this.onCompareUpdated);
        }

        window.addEventListener('storage', this.handleStorageEvent);
    },

    beforeUnmount() {
        const emitter = this.$emitter || window.emitter;

        if (emitter && this.onCompareUpdated) {
            emitter.off("after-compare-update", this.onCompareUpdated);
            emitter.off("compare-updated", this.onCompareUpdated);
        }

        window.removeEventListener('storage', this.handleStorageEvent);
    },

    methods: {
        updateCount(newCount) {
            if (this.count === newCount) return;

            this.count = newCount;
            localStorage.setItem('enhanced_compare_count', newCount);
        },

        handleStorageEvent(event) {
            if (event.key === 'enhanced_compare_count') {
                const newCount = parseInt(event.newValue) || 0;
                this.count = newCount;
            }
        },

        async fetchCount() {
            try {
                const axiosInstance = this.$axios || window.axios;
                
                const response = await axiosInstance.get('/api/enhanced/compare/count', {
                    params: { _: Date.now() }
                });

                const count = response?.data?.count ?? 0;
                this.updateCount(count);
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