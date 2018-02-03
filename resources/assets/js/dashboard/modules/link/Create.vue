<template>
  <vue-form :title="$t('form.create_link')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.link' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <link-form></link-form>
    </template>
  </vue-form>
</template>

<script>
import LinkForm from './Form'

export default {
  components: { LinkForm },
}
</script>
