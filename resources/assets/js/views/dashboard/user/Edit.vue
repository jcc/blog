<template>
    <vue-form :title="$t('form.edit_user')">
        <div slot="buttons">
            <router-link to="/dashboard/users" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <user-form :user="user"></user-form>
        </div>
    </vue-form>
</template>

<script>
import UserForm from './Form'

export default{
    components: { UserForm },
    data() {
        return {
            user: undefined
        }
    },
    created() {
        this.loadUser()
    },
    methods: {
        loadUser() {
            this.$http.get('user/' + this.$route.params.id + '/edit')
                .then((response) => {
                    this.user = response.data.data
                })
        },
    }
}
</script>
