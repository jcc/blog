<template>
  <div :class="wrapperClass" class="box box-radius shadow-sm">
    <div class="box-title d-flex">
      <h5 class="align-self-center font-weight-normal m-0">{{ title }}</h5>
      <small class="ml-auto d-flex flex-row">
        <div class="input-group input-group-sm mr-2">
          <input type="text" class="form-control" v-model="searchable[searchKey]" :placeholder="searchPlaceholder" @keyup.enter="onSearch()">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" @click="onSearch()"><span class="fa fa-search"></span></button>
          </div>
        </div>
        <slot name="buttons"></slot>
      </small>
    </div>
    <div class="box-content p-0 border-0 table-responsive">
      <table :class="tableClass">
        <thead>
          <tr>
            <template v-for="field in fields">
              <template v-if="isSpecialField(field.name)">
                <th v-if="field.name == '__actions' && checkPermissions(itemActions)" :class="field.titleClass">
                  <template v-if="field.trans">
                    {{ $t(field.trans) }}
                  </template>
                  <template v-else>
                    {{ field.title ? field.title : '' }}
                  </template>
                </th>
                <th v-if="field.name == '__component'" :class="field.titleClass">
                  <template v-if="field.trans">
                    {{ $t(field.trans) }}
                  </template>
                  <template v-else>
                    {{ field.title ? field.title : field.name }}
                  </template>
                </th>
              </template>
              <template v-else>
                <th :class="field.titleClass">
                  <template v-if="field.trans">
                    {{ $t(field.trans) }}
                  </template>
                  <template v-else>
                    {{ field.title ? field.title : field.name }}
                  </template>
                </th>
              </template>
            </template>
          </tr>
        </thead>
        <tbody v-cloak>
          <template v-if="items.length > 0">
            <tr v-for="item in items">
              <template v-for="field in fields">
                <template v-if="isSpecialField(field.name)">
                  <template v-if="field.name == '__actions' && checkPermissions(itemActions)">
                    <td :class="field.dataClass" class="actions">
                      <template v-for="action in itemActions">
                        <a @click="callAction(action.name, item)" :class="action.class" v-if="!action.permission || checkPermission(action.permission)">
                          <i :class="action.icon"></i>
                          {{ action.label }}
                        </a>
                      </template>
                    </td>
                  </template>
                  <template v-if="field.name == '__component'">
                    <td :class="field.dataClass" class="component">
                      <custom-action :api-url="apiUrl" :row-data="item"></custom-action>
                    </td>
                  </template>
                </template>
                <template v-else>
                  <td v-if="hasCallback(field)" :class="field.dataClass" v-html="callCallback(field, item)">
                  </td>
                  <td :class="field.dataClass" v-else>
                    {{ item[field.name] }}
                  </td>
                </template>
              </template>
            </tr>
          </template>
        </tbody>
      </table>
      <h3 class="none text-center" v-if="items.length == 0">{{ $t('page.nothing') }}</h3>
      <table-pagination ref="pagination" v-on:loadPage="loadPage" v-if="showPaginate && items.length > 0"></table-pagination>
    </div>
  </div>
</template>
<script>
import CustomAction from 'dashboard/components/CustomAction'
import TablePagination from 'dashboard/components/TablePagination'

export default {
  props: {
    wrapperClass: {
      type: String,
      default () {
        return null
      }
    },
    tableClass: {
      type: String,
      default () {
        return 'table table-hover'
      }
    },
    title: {
      type: String,
      default () {
        return ''
      }
    },
    showPaginate: {
      type: Boolean,
      default () {
        return false
      }
    },
    fields: {
      type: Array,
      required: true
    },
    apiUrl: {
      type: String,
      required: true
    },
    disabledClass: {
      type: String,
      default () {
        return 'disabled'
      }
    },
    itemActions: {
      type: Array,
      default () {
        return [
          { name: 'edit-item', permission: `UPDATE_${this.apiUrl.toUpperCase()}`, icon: 'fas fa-pencil-alt', class: 'btn btn-info' },
          { name: 'delete-item', permission: `DESTROY_${this.apiUrl.toUpperCase()}`, icon: 'fas fa-trash-alt', class: 'btn btn-danger' }
        ]
      }
    },
    moreParams: {
      type: Object,
      default() {
        return {}
      },
    },
    canSearch: {
      type: Boolean,
      default: true,
    },
    searchKey: {
      type: String,
      default: 'keyword'
    },
    searchPlaceholder: {
      type: String,
      default: '',
    }
  },
  components: {
    TablePagination,
    CustomAction,
  },
  data() {
    return {
      items: [],
      params: this.moreParams || {},
      searchable: {
        [this.searchKey]: ''
      },
      totalPage: 0,
      currentPage: 0,
      pagination: null
    }
  },
  watch: {
    $route() {
      let pageNum = 1

      if (this.$route.query.page) {
        pageNum = this.$route.query.page
      }

      this.loadPage(pageNum)
    }
  },
  created() {
    if (this.$route.query[this.searchKey]) {
      this.searchable[this.searchKey] = this.$route.query[this.searchKey]
    }

    this.onSearch()
  },
  mounted() {
    this.$parent.$on('reload', () => {
      this.onSearch(this.$route.query.page)
    })
  },
  methods: {
    loadPage(page) {
      if (page == 'prev') {
        this.goPreviousPage()
      } else if (page == 'next') {
        this.goNextPage()
      } else {
        this.goPage(page)
      }
    },
    onSearch(page) {
      this.currentPage = page ? page : 1

      this.params = this.searchable

      setTimeout(() => {
        this.loadData()
      }, 10)
    },
    loadData() {
      let url = this.apiUrl
      let params = {}

      if (this.currentPage) {
        params = Object.assign(this.params, {
          page: this.currentPage
        })
      } else {
        params = this.params
      }

      this.$router.push({ name: this.$route.name, query: params })

      this.$http.get(url, { params: params })
        .then(response => {
          this.pagination = response.data.meta.pagination
          this.items = response.data.data
          this.totalPage = response.data.meta.pagination.total_pages
          this.currentPage = response.data.meta.pagination.current_page

          if (this.showPaginate && this.items.length != 0) {
            this.$nextTick(() => {
              this.$refs.pagination.$data.pagination = this.pagination
            })
          }
        })
    },
    goPreviousPage() {
      if (this.currentPage > 1) {
        this.currentPage--
          this.loadData()
      }
    },
    goNextPage() {
      if (this.currentPage < this.totalPage) {
        this.currentPage++
          this.loadData()
      }
    },
    goPage(page) {
      if (page != this.currentPage && (page > 0 && page <= this.totalPage)) {
        this.currentPage = page
        this.loadData()
      }
    },
    hasCallback(item) {
      return item.callback ? true : false
    },
    callCallback(field, item) {
      if (!this.hasCallback(field)) return

      var args = field.callback.split('|')
      var func = args.shift()

      if (typeof this.$parent[func] == 'function') {
        return (args.length > 0) ?
          this.$parent[func].apply(this.$parent, [this.getObjectValue(item, field.name)].concat(args)) :
          this.$parent[func].call(this.$parent, this.getObjectValue(item, field.name))
      }

      return null
    },
    getObjectValue(object, path, defaultValue) {
      defaultValue = (typeof defaultValue == 'undefined') ? null : defaultValue

      var obj = object
      if (path.trim() != '') {
        var keys = path.split('.')
        keys.forEach((key) => {
          if (obj !== null && typeof obj[key] != 'undefined' && obj[key] !== null) {
            obj = obj[key]
          } else {
            obj = defaultValue
            return
          }
        })
      }
      return obj
    },
    isSpecialField(name) {
      return name.slice(0, 2) === '__'
    },
    callAction(action, data) {
      this.$emit('table-action', action, data)
    },
    reload() {
      this.loadData()
    }
  }
}
</script>

<style lang="scss" scoped>
.btn {
  outline: none;
}

.table {
  border-bottom: 1px solid #e7eaec;
}

.none {
  color: #ECF0F1;
  padding-bottom: 20px;
}

.actions {
  width: 15%;
  padding: 12px 0px;
  text-align: center;
}

.actions a {
  display: inline-block;
  border-radius: 50%;
  width: 2.2rem;
  height: 2.2rem;
  line-height: 2rem;
  padding: 0;
  margin-left: 5px;
  margin-right: 5px;

  i {
    font-size: 0.8rem;
  }
}
</style>
