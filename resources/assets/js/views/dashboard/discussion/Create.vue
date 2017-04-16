<template>
    <vue-form :title="$t('form.create_discussion')">
        <div slot="buttons">
            <router-link to="/dashboard/discussions" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <discussion-form></discussion-form>
        </div>
    </vue-form>
</template>

<script>
import DiscussionForm from './Form'

export default {
    components: { DiscussionForm }
}
</script>

