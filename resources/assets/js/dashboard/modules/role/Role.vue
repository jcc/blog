<template>
  <div class="row">
    <vue-table :title="$t('page.roles')" :fields="fields" api-url="role" :item-actions="itemActions" @table-action="tableActions" show-paginate>
      <template slot="buttons">
        <router-link :to="{ name: 'dashboard.role.create' }" class="btn btn-sm btn-success" v-if="checkPermission('CREATE_ROLE')">{{ $t('page.create') }}</router-link>
      </template>
    </vue-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      fields: [{
          name: 'id',
          trans: 'table.id',
          titleClass: 'width-5-percent text-center',
          dataClass: 'text-center'
        }, {
          name: 'name',
          trans: 'table.name',
          titleClass: 'text-center',
          dataClass: 'text-center'
        }, {
          name: 'guard_name',
          trans: 'table.guard_name'
        }, {
          name: 'created_at',
          trans: 'table.created_at'
        }, {
          name: '__actions',
          trans: 'table.action',
          titleClass: 'text-center',
          dataClass: 'text-center'
        }
      ],
      itemActions: [
        { name: 'set-permission-item', permission: 'UPDATE_ROLE_PERMISSIONS', icon: 'fas fa-cogs', class: 'btn btn-success' },
        { name: 'edit-item', permission: 'UPDATE_ROLE', icon: 'fas fa-pencil-alt', class: 'btn btn-info' },
        { name: 'delete-item', permission: 'DESTROY_ROLE', icon: 'fas fa-trash-alt', class: 'btn btn-danger' }
      ]
    };
  },
  methods: {
    image(value) {
      return '<img src="' + value + '" width="50" height="50" class="rounded-circle">'
    },
    tableActions(action, data) {
      if (action == 'edit-item') {
        this.$router.push({ name: 'dashboard.role.edit', params: { id: data.id } })
      } else if (action == 'delete-item') {
        this.$http.delete('role/' + data.id)
          .then((response) => {
            toastr.success('You delete the role success!')

            this.$emit('reload', action)
          }).catch(({ response }) => {
            toastr.error(response.status + ' : Resource ' + response.statusText)
          })
      } else if (action == 'set-permission-item') {
        this.$router.push({ name: 'dashboard.role.permission', params: { id: data.id } })
      }
    }
  }
}
</script>
