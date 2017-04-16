<template>
    <vue-form :title="$t('form.create_link')">
        <div slot="buttons">
            <router-link to="/dashboard/links" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <link-form></link-form>
        </div>
    </vue-form>
</template>

<script>
import LinkForm from './Form'

export default{
    components: { LinkForm },
}
</script>
