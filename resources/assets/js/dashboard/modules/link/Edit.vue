<template>
  <vue-form :title="$t('form.edit_link')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.link' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <link-form :link="link"></link-form>
    </template>
  </vue-form>
</template>

<script>
import LinkForm from './Form'

export default {
  components: { LinkForm },
  data() {
    return {
      link: undefined
    }
  },
  created() {
    this.loadLink()
  },
  methods: {
    loadLink() {
      this.$http.get('link/' + this.$route.params.id + '/edit')
        .then((response) => {
          this.link = response.data.data
        })
    },
  }
}
</script>
