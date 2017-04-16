<template>
    <vue-form :title="$t('form.edit_article')">
        <div slot="buttons">
            <router-link to="/dashboard/articles" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <article-form :article="article"></article-form>
        </div>
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
