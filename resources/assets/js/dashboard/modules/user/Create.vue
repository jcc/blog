<template>
  <vue-form :title="$t('form.create_user')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.user' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <user-form></user-form>
    </template>
  </vue-form>
</template>

<script>
import UserForm from './Form'

export default {
  components: { UserForm },
}
</script>
