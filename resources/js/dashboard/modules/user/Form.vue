<template>
  <div class="row">
    <form class="form col-md-4 offset-md-4" role="form" @submit.prevent="onSubmit">
      <div class="form-group text-center">
        <img :src="user.avatar ? user.avatar : '/images/default.png'" id="avatar" class="rounded-circle" width="100" :alt="user.name">
      </div>
      <div class="form-group">
        <label for="name">{{ $t('form.name') }}</label>
        <input type="text" class="form-control" id="name" :placeholder="$t('form.name')" v-model="user.name" :disabled="user.id ? true : false">
      </div>
      <div class="form-group">
        <label for="email">{{ $t('form.email') }}</label>
        <input type="email" class="form-control" id="email" :placeholder="$t('form.email')" v-model="user.email">
      </div>
      <div class="form-group">
        <label for="nickname">{{ $t('form.nickname') }}</label>
        <input type="text" class="form-control" id="nickname" :placeholder="$t('form.nickname')" v-model="user.nickname">
      </div>
      <div class="form-group">
        <label for="website">{{ $t('form.website') }}</label>
        <input type="text" class="form-control" id="website" :placeholder="$t('form.website')" v-model="user.website">
      </div>
      <div class="form-group">
        <label for="description">{{ $t('form.description') }}</label>
        <input type="text" class="form-control" id="description" :placeholder="$t('form.description')" v-model="user.description">
      </div>
      <template v-if="!user.id">
        <div class="form-group">
          <label for="password">{{ $t('form.password') }}</label>
          <input type="password" class="form-control" id="password" :placeholder="$t('form.password')" name="password" v-model="user.password">
        </div>
        <div class="form-group">
          <label for="password_confirmation">{{ $t('form.confirm_password') }}</label>
          <input type="password" class="form-control" id="password_confirmation" :placeholder="$t('form.confirm_password')" name="password_confirmation" v-model="user.password_confirmation">
        </div>
      </template>
      <div class="form-group">
        <div class="custom-control custom-checkbox d-inline-block pr-3">
          <input type="checkbox" class="custom-control-input" id="is-admin" v-model="user.is_admin">
          <label class="custom-control-label" for="is-admin">Set Admin</label>
        </div>
      </div>
      <div class="form-group" v-if="user.is_admin">
        <label>Roles</label>
        <multiselect v-model="roles" :options="allRoles" multiple searchable hide-selected :close-on-select="false" :clear-on-select="false" :limit="5" :placeholder="$t('form.select_tag')" label="name" track-by="name"></multiselect>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ user.id ? $t('form.edit') : $t('form.create') }}</button>
      </div>
    </form>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import { stack_error } from 'config/helper'

export default {
  components: {
    Multiselect
  },
  props: {
    user: {
      type: Object,
      default () {
        return {}
      }
    },
  },

  data: () => ({
    roles: [],
    allRoles: [],
    isAdmin: false
  }),

  computed: {
    mode() {
      return this.user.id ? 'update' : 'create'
    },
  },

  watch: {
    user(val) {
      this.roles = val.roles.data
    }
  },

  async created() {
    await this.loadRoles()
  },

  methods: {
    loadRoles() {
      this.$http.get('role', {
        params: {
          per_page: 100
        }
      }).then(({data}) => {
        this.allRoles = data.data
      })
    },

    onSubmit() {
      let url = 'user' + (this.user.id ? '/' + this.user.id : '')
      let method = this.user.id ? 'patch' : 'post'
      let roleIds = []

      this.roles.forEach((item) => {
        roleIds.push(item.id)
      })

      this.user.roles = roleIds

      this.$http[method](url, this.user)
        .then((response) => {
          toastr.success('You ' + this.mode + 'd a new account information!')

          this.$router.push({ name: 'dashboard.user' })
        }).catch(({ response }) => {
          stack_error(response)
        })
    }
  },
}
</script>
