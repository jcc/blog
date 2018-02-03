<template>
  <vue-form :title="$t('form.create_article')">
    <template slot="buttons">
      <router-link :to="{ name: 'dashboard.article' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <article-form></article-form>
    </template>
  </vue-form>
</template>

<script>
import ArticleForm from './Form'

export default {
  components: { ArticleForm },
}
</script>
