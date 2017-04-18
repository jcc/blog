<template>
    <vue-form :title="$t('form.create_category')">
        <div slot="buttons">
            <router-link to="/dashboard/categories" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <category-form></category-form>
        </div>
    </vue-form>
</template>

<script>
import CategoryForm from './Form'

export default {
    components: { CategoryForm },
}
</script>
