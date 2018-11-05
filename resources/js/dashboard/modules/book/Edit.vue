<template>
  <vue-form :title="$t('form.edit_article')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.article' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <article-form :article="article"></article-form>
    </template>
  </vue-form>
</template>

<script>
import ArticleForm from './Form'

export default {
  components: { ArticleForm },
  data() {
    return {
      article: undefined
    }
  },
  created() {
    this.$http.get('article/' + this.$route.params.id + '/edit?include=category,tags')
      .then((response) => {
        this.article = response.data.data
      })
  },
}
</script>
