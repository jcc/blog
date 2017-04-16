<template>
    <vue-form :title="$t('form.create_user')">
        <div slot="buttons">
            <router-link to="/dashboard/users" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <user-form></user-form>
        </div>
    </vue-form>
</template>

<script>
import UserForm from './Form'

export default {
    components: { UserForm },
}
</script>
