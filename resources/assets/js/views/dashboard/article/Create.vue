<template>
    <vue-form :title="$t('form.create_article')">
        <div slot="buttons">
            <router-link to="/dashboard/articles" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <article-form></article-form>
        </div>
    </vue-form>
</template>

<script>
import ArticleForm from './Form'

export default {
    components: { ArticleForm },
}
</script>
