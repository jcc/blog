<template>
    <vue-form :title="$t('form.edit_discussion')">
        <div slot="buttons">
            <router-link to="/dashboard/discussions" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <discussion-form :discussion="discussion"></discussion-form>
        </div>
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
