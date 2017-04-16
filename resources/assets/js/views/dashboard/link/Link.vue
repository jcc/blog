<template>
    <div class="row">
        <vue-table :title="$t('page.links')" :fields="fields" api-url="link" show-paginate @table-action="tableActions">
            <div slot="buttons">
                <router-link to="/dashboard/links/create" class="btn btn-success">{{ $t('page.create') }}</router-link>
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
                    name: 'image',
                    trans: 'table.image',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    callback: 'image'
                },
                {
                    name: 'name',
                    trans: 'table.name',
                    titleClass: 'text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'link',
                    trans: 'table.link'
                },
                {
                    name: '__component',
                    trans: 'table.enabled',
                    titleClass: 'width-10-percent text-center',
                    dataClass: 'text-center'
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
        };
    },
    methods: {
        image(value) {
            return '<img src="'+ value +'" width="50" height="50" class="img-circle">'
        },
        tableActions(action, data) {
            if (action == 'edit-item') {
                this.$router.push('/dashboard/links/' + data.id + '/edit')
            } else if (action == 'delete-item') {
                this.$http.delete('link/' + data.id)
                    .then((response) => {
                        toastr.success('You delete the link success!')

                        this.$emit('reload', action)
                    }).catch(({response}) => {
                        toastr.error(response.status + ' : Resource ' + response.statusText)
                    })
            }
        }
    }
}
</script>
