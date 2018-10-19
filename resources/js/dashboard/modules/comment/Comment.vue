<template>
  <div class="row">
    <vue-table :title="$t('page.comments')" :fields="fields" api-url="comment" show-paginate @table-action="tableActions"></vue-table>
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
          name: 'username',
          trans: 'table.username'
        }, {
          name: 'type',
          trans: 'table.comment_type'
        }, {
          name: 'commentable',
          trans: 'table.comment_title'
        }, {
          name: 'created_at',
          trans: 'table.created_at'
        }, {
          name: '__actions',
          trans: 'table.action',
          titleClass: 'text-center',
          dataClass: 'text-center'
        }
      ]
    }
  },
  methods: {
    username(value) {
      return value.data.name
    },
    tableActions(action, data) {
      if (action == 'edit-item') {
        this.$router.push({ name: 'dashboard.comment.edit', params: { id: data.id } })
      } else if (action == 'delete-item') {
        this.$http.delete('comment/' + data.id)
          .then((response) => {
            toastr.success('You delete the comment success!')

            this.$emit('reload')
          }).catch(({ response }) => {
            toastr.error(response.status + ' : Resource ' + response.statusText)
          })
      }
    }
  }
}
</script>
