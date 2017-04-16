<template>
    <vue-form :title="$t('form.create_tag')">
        <div slot="buttons">
            <router-link to="/dashboard/tags" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <tag-form></tag-form>
        </div>
    </vue-form>
</template>

<script>
import TagForm from './Form'

export default {
    components: { TagForm },
}
</script>

