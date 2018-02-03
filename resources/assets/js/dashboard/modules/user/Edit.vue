<template>
  <vue-form :title="$t('form.edit_user')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.user' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <user-form :user="user"></user-form>
    </template>
  </vue-form>
</template>

<script>
import UserForm from './Form'

export default {
  components: { UserForm },
  data() {
    return {
      user: undefined
    }
  },
  created() {
    this.loadUser()
  },
  methods: {
    loadUser() {
      this.$http.get('user/' + this.$route.params.id + '/edit')
        .then((response) => {
          this.user = response.data.data
        })
    },
  }
}
</script>
