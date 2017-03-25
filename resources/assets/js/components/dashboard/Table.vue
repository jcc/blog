<template>
    <div :class="wrapperClass" class="ibox">
        <div class="ibox-title">
            <small class="pull-right" style="margin-top: 7px;">
                <slot name="buttons"></slot>
            </small>
            <h5>{{ title }}</h5>
        </div>
        <div class="ibox-content no-padding">
            <table :class="tableClass">
                <thead>
                    <tr>
                        <template v-for="field in fields">
                            <template v-if="isSpecialField(field.name)">
                                <th v-if="field.name == '__actions'" :class="field.titleClass">
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
                                    <template v-if="field.name == '__actions'">
                                        <td :class="field.dataClass" class="actions">
                                            <template v-for="action in itemActions">
                                                <a @click="callAction(action.name, item)" :class="action.class">
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
    import CustomAction from './CustomAction.vue'
    import TablePagination from './TablePagination.vue'

    export default{
        props: {
            wrapperClass: {
                type: String,
                default() {
                    return null
                }
            },
            tableClass: {
                type: String,
                default() {
                    return 'table table-striped table-hover'
                }
            },
            title: {
                type: String,
                default() {
                    return ''
                }
            },
            showPaginate: {
                type: Boolean,
                dafault() {
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
                default() {
                    return 'disabled'
                }
            },
            itemActions: {
                type: Array,
                default() {
                    return [
                        { name: 'edit-item', icon: 'ion-edit', class: 'btn btn-info' },
                        { name: 'delete-item', icon: 'ion-trash-b', class: 'btn btn-danger' }
                    ]
                }
            }
        },
        components: {
            TablePagination,
            CustomAction
        },
        data() {
            return{
                items: [],
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
            this.currentPage = this.$route.query.page

            this.loadData()
        },
        mounted() {
            this.$parent.$on('reload', () => {
                this.loadData()
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
            loadData() {
                var url = this.apiUrl;

                if (this.currentPage) {
                    let page = ''
                    if (url.indexOf('?') != -1) {
                        page = '&page='
                    } else {
                        page = '?page='
                    }
                    url = url + page + this.currentPage
                    this.$router.push(page + this.currentPage)
                }

                this.$http.get(url)
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
                if (! this.hasCallback(field)) return

                var args = field.callback.split('|')
                var func = args.shift()

                if (typeof this.$parent[func] == 'function') {
                    return (args.length > 0)
                        ? this.$parent[func].apply(this.$parent, [this.getObjectValue(item, field.name)].concat(args))
                        : this.$parent[func].call(this.$parent, this.getObjectValue(item, field.name))
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
      border-radius: 50%;
      margin-left: 5px;
      margin-right: 5px;
    }
    .active {
      background-color: #3d4e60;
      border-right: none;
    }
    .pagination li {
      cursor: pointer;
    }
</style>
