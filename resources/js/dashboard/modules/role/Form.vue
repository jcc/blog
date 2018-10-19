<template>
  <div class="row">
    <form class="col-sm-4 offset-sm-4" role="form" @submit.prevent="onSubmit" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">{{ $t('form.role_name') }}</label>
        <input type="text" class="form-control" id="name" name="name" :placeholder="$t('form.role_name')" v-model="role.name">
      </div>
      <div class="form-group">
        <label for="role">{{ $t('form.guard_name') }}</label>
        <multiselect v-model="role.guard_name" :options="options" :placeholder="$t('form.select_guard_name')"></multiselect>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-info">{{ role.id ? $t('form.edit') : $t('form.create') }}</button>
      </div>
    </form>
  </div>
</template>

<script>
import { stack_error } from 'config/helper'
import Multiselect from 'vue-multiselect'

export default {
  components: { Multiselect },
  props: {
    role: {
      type: Object,
      default () {
        return {}
      }
    },
  },
  data() {
    return {
      options: ['api', 'web'],
    }
  },
  watch: {
    role() {
      return this.role
    },
  },
  computed: {
    mode() {
      return this.role.id ? 'update' : 'create'
    },
  },
  methods: {
    onSubmit() {
      let url = 'role' + (this.role.id ? '/' + this.role.id : '')
      let method = this.role.id ? 'patch' : 'post'

      this.$http[method](url, this.role)
        .then((response) => {
          toastr.success('You ' + this.mode + 'd the role success!')

          this.$router.push({ name: 'dashboard.role' })
        }).catch(({ response }) => {
          stack_error(response)
        })
    }
  },
}
</script>
