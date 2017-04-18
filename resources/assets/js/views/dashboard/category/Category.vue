<template>
    <div class="row">
        <vue-table :title="$t('page.categories')" :fields="fields" api-url="category" show-paginate @table-action="tableActions">
            <div slot="buttons">
                <router-link to="/dashboard/categories/create" class="btn btn-success">{{ $t('page.create') }}</router-link>
            </div>
        </vue-table>
    </div>
</template>

<script>
export default {
    data () {
        return {
            categories: [],
            fields: [
                {
                    name: 'id',
                    trans: 'table.id',
                    titleClass: 'width-5-percent text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'name',
                    trans: 'table.name'
                },
                {
                    name: 'path',
                    trans: 'table.path'
                },
                {
                    name: 'created_at',
                    trans: 'table.created_at'
                },
                {
                    name: '__actions',
                    trans: 'table.action',
                    titleClass: 'text-center',
                    dataClass: 'text-center'
                }
            ]
        }
    },
    methods: {
        tableActions(action, data) {
            if (action == 'edit-item') {
                this.$router.push('/dashboard/categories/' + data.id + '/edit')
            } else if (action == 'delete-item') {
                this.$http.delete('category/' + data.id)
                    .then((response) => {
                        toastr.success('You delete the category success!')

                        this.$emit('reload')
                    }).catch(({response}) => {
                        toastr.error(response.status + ' : Resource ' + response.statusText)
                    })
            }
        }
    }
}
</script>
