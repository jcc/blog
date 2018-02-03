<template>
  <vue-form :title="$t('form.create_category')">
    <template slot="buttons">
      <router-link to="/dashboard/categories" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
    </template>
    <template slot="content">
      <category-form></category-form>
    </template>
  </vue-form>
</template>

<script>
import CategoryForm from './Form'

export default {
  components: { CategoryForm },
}
</script>
