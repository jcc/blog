<template>
    <vue-form :title="$t('form.edit_tag')">
        <div slot="buttons">
            <router-link to="/dashboard/tags" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <tag-form :tag="tag"></tag-form>
        </div>
    </vue-form>
</template>

<script>
import TagForm from './Form'

export default {
    components: { TagForm },
    data() {
        return {
            tag: undefined
        }
    },
    created() {
        this.loadTag()
    },
    methods: {
        loadTag() {
            this.$http.get('tag/' + this.$route.params.id + '/edit')
                .then((response) => {
                    this.tag = response.data.data
                })
        },
    }
}
</script>
