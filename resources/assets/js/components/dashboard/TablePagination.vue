<template>
    <nav class="text-center">
        <ul class="pagination">
            <li :class="isOnFirstPage ? disabledClass : ''">
                <a @click="loadPage('prev')"><i class="ion-chevron-left"></i></a>
            </li>
            <template v-if="notEnoughPages">
                <template v-for="n in totalPage">
                    <li :class="isCurrentPage(n) ? 'active' : ''">
                        <a @click="loadPage(n)"> {{ n }} </a>
                    </li>
                </template>
            </template>
            <template v-else>
                <template v-for="n in windowSize">
                    <li :class="isCurrentPage(windowStart+n) ? 'active' : ''">
                        <a @click="loadPage(windowStart+n)">
                            {{ windowStart+n }}
                        </a>
                    </li>
                </template>
            </template>
            <li :class="isOnLastPage ? disabledClass : ''">
                <a @click="loadPage('next')"><i class="ion-chevron-right"></i></a>
            </li>
        </ul>
    </nav>
</template>

<script>
    import PaginationMixin from './TablePaginationMixin.vue'

    export default {
        mixins: [PaginationMixin],
        methods: {
            loadPage(page) {
                this.$emit('loadPage', page)
            }
        }
    }
</script>

<style lang="scss" scoped>
    .active {
      background-color: #3d4e60;
      border-right: none;
    }
    .pagination li {
      cursor: pointer;
    }
</style>
