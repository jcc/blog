<template>
  <div class="row">
    <vue-table :title="$t('page.articles')" :fields="fields" api-url="article" :item-actions="itemActions" @table-action="tableActions" show-paginate>
      <template slot="buttons">
        <router-link :to="{ name: 'dashboard.article.create' }" class="btn btn-sm btn-success">{{ $t('page.create') }}</router-link>
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
          name: 'title',
          trans: 'table.title',
          sortField: 'title',
        }, {
          name: 'subtitle',
          trans: 'table.subtitle',
          sortField: 'subtitle',
        }, {
          name: 'published_at',
          trans: 'table.published_at',
          titleClass: 'width-10-percent',
          sortField: 'created_at'
        }, {
          name: '__actions',
          trans: 'table.action',
          titleClass: 'text-center',
          dataClass: 'text-center',
        }
      ],
      itemActions: [
        { name: 'view-item', icon: 'fas fa-eye', class: 'btn btn-success' },
        { name: 'edit-item', icon: 'fas fa-pencil-alt', class: 'btn btn-info' },
        { name: 'delete-item', icon: 'fas fa-trash-alt', class: 'btn btn-danger' }
      ]
    }
  },
  methods: {
    tableActions(action, data) {
      if (action == 'edit-item') {
        this.$router.push({ name: 'dashboard.article.edit', params: { id: data.id } })
      } else if (action == 'delete-item') {
        this.$http.delete('article/' + data.id)
          .then((response) => {
            toastr.success('You delete the article success!')

            this.$emit('reload')
          }).catch(({ response }) => {
            if ((typeof response.data.error !== 'string') && response.data.error) {
              toastr.error(response.data.error.message)
            } else {
              toastr.error(response.status + ' : Resource ' + response.statusText)
            }
          })
      } else if (action == 'view-item') {
        window.open('/' + data.slug, '_blank');
      }
    }
  }
}
</script>
