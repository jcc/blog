<template>
    <div class="row">
        <vue-table :title="$t('page.users')" :fields="fields" api-url="user" @table-action="tableActions" show-paginate>
            <div slot="buttons">
                <router-link to="/dashboard/users/create" class="btn btn-success">{{ $t('page.create') }}</router-link>
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
                    name: 'avatar',
                    trans: 'table.avatar',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    callback: 'avatar'
                },
                {
                    name: 'name',
                    trans: 'table.username'
                },
                {
                    name: 'email',
                    trans: 'table.email'
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
            ]
        }
    },
    methods: {
        avatar(value) {
            return '<img src="' + value + '" class="avatar img-responsive img-circle" />'
        },
        tableActions(action, data) {
            if (action == 'edit-item') {
                this.$router.push('/dashboard/users/' + data.id + '/edit')
            } else if (action == 'delete-item') {
                this.$http.delete('user/' + data.id)
                    .then((response) => {
                        toastr.success('You delete the user success!')

                        this.$emit('reload')
                    }, (response) => {
                        if ((typeof response.data.error !== 'string') && response.data.error) {
                            toastr.error(response.data.error.message)
                        } else {
                            toastr.error(response.status + ' : Resource ' + response.statusText)
                        }
                    })
            }
        }
    }
}
</script>
