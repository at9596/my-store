@pushOnce('scripts')
    @if (config('enhanced_wishlist.wishlist.enabled'))
    <!-- Wishlist Badge Template -->
    <script type="text/x-template" id="v-wishlist-badge-template">
        <div 
            class="wishlist-badge inline-flex"
            :class="{'pill': isPill, 'hidden': count <= 0}"
        >
            <span v-if="count > 0" :class="isPill ? '' : 'count'">
                @{{ count }} 
                <template v-if="showText">
                    <span v-if="count == 1">{{ __('enhanced::app.wishlist.item') }}</span>
                    <span v-else>{{ __('enhanced::app.wishlist.items') }}</span>
                </template>
            </span>
        </div>
    </script>
    @endif

    @if (config('enhanced_wishlist.compare.enabled'))
    <!-- Compare Badge Template -->
    <script type="text/x-template" id="v-compare-badge-template">
        <div 
            class="compare-badge inline-flex"
            :class="{'pill': isPill, 'hidden': count <= 0}"
        >
            <span v-if="count > 0" :class="isPill ? '' : 'count'">
                @{{ count }} 
                <template v-if="showText">
                    <span v-if="count == 1">{{ __('enhanced::app.compare.item') }}</span>
                    <span v-else>{{ __('enhanced::app.compare.items') }}</span>
                </template>
            </span>
        </div>
    </script>
    @endif

    <script type="module">
        @if (config('enhanced_wishlist.wishlist.enabled'))
        /**
         * Wishlist Badge Component
         */
        app.component("wishlist-count", {
            template: '#v-wishlist-badge-template',

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

                this.$emitter.on('after-wishlist-update', (data) => {
                    this.onUpdate(data);
                });

                this.$emitter.on('wishlist-updated', (data) => {
                    this.onUpdate(data);
                });

                window.addEventListener('storage', (e) => {
                    if (e.key === 'enhanced_wishlist_count') {
                        this.count = parseInt(e.newValue) || 0;
                    }
                });
            },

            methods: {
                onUpdate(data) {
                    let next = null;
                    if (data && typeof data === "object") {
                        next = data.count ?? data.wishlist_count;
                    }

                    if (next !== null) {
                        this.count = next;
                        localStorage.setItem('enhanced_wishlist_count', next);
                    } else {
                        this.fetchCount();
                    }
                },

                fetchCount() {
                    this.$axios.get('{{ route('api.enhanced.wishlist.count') }}')
                        .then(response => {
                            this.count = response.data.count;
                            localStorage.setItem('enhanced_wishlist_count', this.count);
                        })
                        .catch(error => {});
                }
            }
        });
        @endif

        @if (config('enhanced_wishlist.compare.enabled'))
        /**
         * Compare Badge Component
         */
        app.component("compare-count", {
            template: '#v-compare-badge-template',

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

                this.$emitter.on('after-compare-update', (data) => {
                    this.onUpdate(data);
                });

                this.$emitter.on('compare-updated', (data) => {
                    this.onUpdate(data);
                });

                window.addEventListener('storage', (e) => {
                    if (e.key === 'enhanced_compare_count') {
                        this.count = parseInt(e.newValue) || 0;
                    }
                });
            },

            methods: {
                onUpdate(data) {
                    let next = null;
                    if (data && typeof data === "object") {
                        next = data.count ?? data.compare_count;
                    }

                    if (next !== null) {
                        this.count = next;
                        localStorage.setItem('enhanced_compare_count', next);
                    } else {
                        this.fetchCount();
                    }
                },

                fetchCount() {
                    this.$axios.get('{{ route('api.enhanced.compare.count') }}')
                        .then(response => {
                            this.count = response.data.count;
                            localStorage.setItem('enhanced_compare_count', this.count);
                        })
                        .catch(error => {});
                }
            }
        });
        @endif
    </script>

    <style>
        .wishlist-badge .count, .compare-badge .count {
            display: inline-flex;
            border-radius: 44px;
            background: #060C3B;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            line-height: 9px;
            padding: 1px 1px;
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
@endpushOnce
