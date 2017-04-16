<template>
    <div class="row">
        <vue-table :title="$t('page.discussions')" :fields="fields" api-url="discussion"  :item-actions="itemActions" @table-action="tableActions" show-paginate>
            <div slot="buttons">
                <router-link to="/dashboard/discussions/create" class="btn btn-success">{{ $t('page.create') }}</router-link>
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
                    name: 'user',
                    trans: 'table.username',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    callback: 'username'
                },
                {
                    name: 'title',
                    trans: 'table.title'
                },
                {
                    name: '__component',
                    trans: 'table.status',
                    titleClass: 'text-center',
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
            ],
            itemActions: [
                { name: 'view-item', icon: 'ion-eye', class: 'btn btn-success' },
                { name: 'edit-item', icon: 'ion-edit', class: 'btn btn-info' },
                { name: 'delete-item', icon: 'ion-trash-b', class: 'btn btn-danger' }
            ]
        };
    },
    methods: {
        username(value) {
            return value.name
        },
        tableActions(action, data) {
            if (action == 'edit-item') {
                this.$router.push('/dashboard/discussions/' + data.id + '/edit')
            } else if (action == 'delete-item') {
                this.$http.delete('discussion/' + data.id)
                    .then((response) => {
                        toastr.success('You delete the discussion success!')

                        this.$emit('reload')
                    }).catch(({response}) => {
                        toastr.error(response.status + ' : Resource ' + response.statusText)
                    })
            } else if (action == 'view-item') {
                window.open('/discussion/' + data.id, '_blank');
            }
        }
    }
}
</script>
