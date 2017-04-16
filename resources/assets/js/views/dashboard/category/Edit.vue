<template>
    <vue-form :title="$t('form.edit_category')">
        <div slot="buttons">
            <router-link to="/dashboard/categories" class="btn btn-default" exact>{{ $t('form.back') }}</router-link>
        </div>
        <div slot="content">
            <category-form :category="category"></category-form>
        </div>
    </vue-form>
</template>

<script>
import CategoryForm from './Form'

export default {
    components: { CategoryForm },
    data() {
        return {
            category: undefined
        }
    },
    created() {
        this.loadCategory()
    },
    methods: {
        loadCategory() {
            this.$http.get('category/' + this.$route.params.id + '/edit')
                .then((response) => {
                    this.category = response.data.data
                })
        },
    }
}
</script>
