<template>
  <vue-form :title="$t('form.edit_discussion')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.discussion' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <discussion-form :discussion="discussion"></discussion-form>
    </template>
  </vue-form>
</template>

<script>
import DiscussionForm from './Form'

export default {
  components: { DiscussionForm },
  data() {
    return {
      discussion: undefined,
    }
  },
  mounted() {
    this.loadDiscussion()
  },
  methods: {
    loadDiscussion() {
      this.$http.get('discussion/' + this.$route.params.id + '/edit?include=tags')
        .then((response) => {
          this.discussion = response.data.data
        })
    },
  }
}
</script>
