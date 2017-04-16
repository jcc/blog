<template>
    <vue-form :title="$t('form.edit_link')">
        <div slot="buttons">
            <router-link to="/dashboard/links" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <link-form :link="link"></link-form>
        </div>
    </vue-form>
</template>

<script>
import LinkForm from './Form'

export default{
    components: { LinkForm },
    data(){
        return{
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
