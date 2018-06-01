<template>
  <vue-form :title="$t('form.edit_link')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.role' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <role-form :role="role"></role-form>
    </template>
  </vue-form>
</template>

<script>
import RoleForm from './Form'

export default {
  components: { RoleForm },
  data() {
    return {
      role: undefined
    }
  },
  created() {
    this.loadLink()
  },
  methods: {
    loadLink() {
      this.$http.get('role/' + this.$route.params.id + '/edit')
        .then((response) => {
          this.role = response.data.data
        })
    },
  }
}
</script>
