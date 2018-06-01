<template>
  <vue-form :title="$t('form.create_role')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.role' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <role-form></role-form>
    </template>
  </vue-form>
</template>

<script>
import RoleForm from './Form'

export default {
  components: { RoleForm },
}
</script>
