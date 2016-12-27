<script>
    export default {
        props: {
            disabledClass: {
                type: String,
                default() {
                    return 'disabled'
                }
            },
            onEachSide: {
                type: Number,
                coerce: function(value) {
                    return parseInt(value)
                },
                default: function() {
                    return 2
                }
            }
        },
        data() {
            return {
                pagination: null
            }
        },
        computed: {
            totalPage() {
                return this.pagination == null
                        ? 0
                        : this.pagination.total_pages
            },
            isOnFirstPage() {
                return this.pagination == null
                        ? false
                        : this.pagination.current_page == 1
            },
            isOnLastPage() {
                return this.pagination == null
                        ? false
                        : this.pagination.current_page == this.pagination.total_pages
            },
            notEnoughPages() {
                return this.totalPage < (this.onEachSide * 2) + 1
            },
            windowSize() {
                return this.onEachSide * 2 +1;
            },
            windowStart() {
                if (!this.pagination || this.pagination.current_page <= this.onEachSide) {
                    return 0
                } else if (this.pagination.current_page >= (this.totalPage - this.onEachSide)) {
                    return this.totalPage - this.onEachSide*2 - 1
                }
                return this.pagination.current_page - this.onEachSide - 1
            },
        },
        methods: {
            loadPage(page) {
                this.$emit('loadPage', page)
            },
            isCurrentPage(page) {
                return page == this.pagination.current_page
            }
        }
    }
</script>