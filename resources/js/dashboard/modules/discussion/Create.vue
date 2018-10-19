<template>
  <vue-form :title="$t('form.create_discussion')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.discussion' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <discussion-form></discussion-form>
    </template>
  </vue-form>
</template>

<script>
import DiscussionForm from './Form'

export default {
  components: { DiscussionForm }
}
</script>
