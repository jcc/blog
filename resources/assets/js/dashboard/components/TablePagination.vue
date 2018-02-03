<template>
  <nav class="d-flex justify-content-center">
    <ul class="pagination">
      <li class="page-item" :class="isOnFirstPage ? disabledClass : ''">
        <a class="page-link" @click="loadPage('prev')"><i class="fas fa-chevron-left"></i></a>
      </li>
      <template v-if="notEnoughPages">
        <template v-for="n in totalPage">
          <li class="page-item" :class="isCurrentPage(n) ? 'active' : ''">
            <a class="page-link" @click="loadPage(n)"> {{ n }} </a>
          </li>
        </template>
      </template>
      <template v-else>
        <template v-for="n in windowSize">
          <li class="page-item" :class="isCurrentPage(windowStart+n) ? 'active' : ''">
            <a class="page-link" @click="loadPage(windowStart+n)">
              {{ windowStart+n }}
            </a>
          </li>
        </template>
      </template>
      <li class="page-item" :class="isOnLastPage ? disabledClass : ''">
        <a class="page-link" @click="loadPage('next')"><i class="fas fa-chevron-right"></i></a>
      </li>
    </ul>
  </nav>
</template>
<script>
import PaginationMixin from 'dashboard/components/TablePaginationMixin.vue'

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

.pagination {
  li {
    cursor: pointer;
  }
}
</style>
