<template>
    <div class="row">
        <vue-table :title="$t('page.books')" :fields="fields" api-url="book" :item-actions="itemActions"
                   @table-action="tableActions" show-paginate>
            <template slot="buttons">
                <router-link :to="{ name: 'dashboard.book.create' }" class="btn btn-sm btn-success"
                             v-if="checkPermission('CREATE_BOOK')">{{ $t('page.create') }}
                </router-link>
            </template>
        </vue-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fields: [
                    {
                        name: 'id',
                        trans: 'table.id',
                        titleClass: 'width-3-percent text-center',
                        dataClass: 'text-center'
                    },
                    {
                        name: 'title',
                        trans: 'table.title',
                        sortField: 'title'
                    },
                    {
                        name: 'subtitle',
                        trans: 'table.subtitle',
                        sortField: 'subtitle'
                    },
                    {
                        name: 'status',
                        trans: 'table.status',
                        sortField: 'status'
                    },
                    {
                        name: 'author',
                        trans: 'table.author',
                        sortField: 'author'
                    },
                    {
                        name: 'tags',
                        trans: 'table.tags',
                        sortField: 'tags'
                    },
                    {
                        name: 'image_proxy',
                        trans: 'table.image_proxy',
                        titleClass: 'text-center',
                        dataClass: 'text-center',
                        callback: 'image_proxy'
                    },
                    {
                        name: 'publisher',
                        trans: 'table.publisher',
                        sortField: 'publisher'
                    }, {
                        name: 'price',
                        trans: 'table.price',
                        sortField: 'price'
                    },
                    {
                        name: 'sort',
                        trans: 'table.sort',
                        sortField: 'sort'
                    },
                    {
                        name: 'pubdate',
                        trans: 'table.pubdate',
                        titleClass: 'width-10-percent',
                        sortField: 'pubdate'
                    },
                    {
                        name: '__actions',

                        trans: 'table.action',
                        titleClass: 'text-center',
                        dataClass: 'text-center'
                    }
                ],
                itemActions: [
                    {name: 'view-item', icon: 'fas fa-eye', class: 'btn btn-success'},
                    {
                        name: 'edit-item',
                        permission: 'UPDATE_BOOK',
                        icon: 'fas fa-pencil-alt',
                        class: 'btn btn-info'
                    },
                    {
                        name: 'delete-item',
                        permission: 'DESTROY_BOOK',
                        icon: 'fas fa-trash-alt',
                        class: 'btn btn-danger'
                    }
                ]
            }
        },
        methods: {
            image_proxy(value) {
                return '<img src="' + value + '" width="70" height="90">'
            },
            tableActions(action, data) {
                if (action == 'edit-item') {
                    this.$router.push({
                        name: 'dashboard.book.edit',
                        params: {id: data.id}
                    })
                } else if (action == 'delete-item') {
                    this.$http
                        .delete('book/' + data.id)
                        .then(response => {
                            toastr.success('You delete the book success!')

                            this.$emit('reload')
                        })
                        .catch(({response}) => {
                            if (
                                typeof response.data.error !== 'string' &&
                                response.data.error
                            ) {
                                toastr.error(response.data.error.message)
                            } else {
                                toastr.error(
                                    response.status + ' : Resource ' + response.statusText
                                )
                            }
                        })
                } else if (action == 'view-item') {
                    window.open('/' + data.slug, '_blank')
                }
            }
        }
    }
</script>
