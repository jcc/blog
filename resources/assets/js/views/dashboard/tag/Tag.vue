<template>
    <div class="row">
        <vue-table :title="$t('page.tags')" :fields="fields" api-url="tag" show-paginate @table-action="tableActions">
            <div slot="buttons">
                <router-link to="/dashboard/tags/create" class="btn btn-success">{{ $t('page.create') }}</router-link>
            </div>
        </vue-table>
    </div>
</template>

<script>
export default {
    data () {
        return {
            fields: [
                {
                    name: 'id',
                    trans: 'table.id',
                    titleClass: 'width-5-percent text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'tag',
                    trans: 'table.tag'
                },
                {
                    name: 'title',
                    trans: 'table.title'
                },
                {
                    name: 'meta_description',
                    trans: 'table.meta_description'
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
                this.$router.push('/dashboard/tags/' + data.id + '/edit')
            } else if (action == 'delete-item') {
                this.$http.delete('tag/' + data.id)
                    .then((response) => {
                        toastr.success('You delete the tag success!')

                        this.$emit('reload')
                    }).catch(({response}) => {
                        toastr.error(response.status + ' : Resource ' + response.statusText)
                    })
            }
        }
    }
}
</script>
