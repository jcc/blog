<template>
  <div class="row">
    <div class="box box-radius shadow-sm">
      <div class="box-title d-flex justify-content-between align-items-center">
        <h5 class="m-0">{{ $t('form.set_permissions') }}</h5>
        <small>
          <button class="btn btn-sm btn-primary mr-2" @click="savePermissions">{{ $t('form.submit') }}</button>
          <router-link :to="{ name: 'dashboard.role' }" class="btn btn-sm btn-secondary" exact>{{ $t('form.back') }}</router-link>
        </small>
      </div>
      <div class="box-content p-0">
        <div class="row m-0">
          <div class="card col-md-12 p-3 border-0" v-for="module in modules">
            <h6 class="card-title font-weight-bold text-upper">{{ module.name }}</h6>
            <div class="card-body p-0">
              <div class="custom-control custom-checkbox d-inline-block pr-3" v-for="permission in module.permissions">
                <input type="checkbox" class="custom-control-input" :id="permission.name" :value="permission.id" v-model="selectedPermissions">
                <label class="custom-control-label" :for="permission.name">{{ permission.label }}</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        modules: [],
        selectedPermissions: []
      }
    },
    async created () {
      Promise.all([
        this.loadRole(),
        this.loadPermissions()
      ])
    },
    methods: {
      savePermissions () {
        this.$http.post(`role/${this.$route.params.id}/permissions`, {
          permissions: this.selectedPermissions
        }).then(() => {
          this.$router.push({ name: 'dashboard.role' })
        })
      },

      loadRole () {
        this.$http.get(`role/${this.$route.params.id}/edit`).then(({data}) => {
          this.selectedPermissions = data.data.permission_ids
        })
      },

      loadPermissions () {
        let names = ['user', 'article', 'discussion', 'comment', 'file', 'tag', 'category', 'link', 'role', 'visitor', 'system']
        let modules = {}

        names.forEach((item) => {
          modules[item] = {
            name: this.$t(`permission.${item}`),
            permissions: []
          }
        })

        this.$http.get('permissions').then(({data}) => {
          data.data.forEach((item) => {
            let type = item.name.split('_')[1]

            Object.keys(modules).forEach(function (key) {
              if (type == key) {
                modules[key].permissions.push(item)
              }
            })
          })

          this.modules = modules
        })
      },
    }
  }
</script>

<style lang="scss" scoped>
  .card {
    border-radius: 0;
    border-bottom: 1px solid #e7eaec !important;

    &:last-child {
      border-bottom: 0 !important;
      border-radius: 5px;
    }
    .custom-control input,
    .custom-control label{
      cursor: pointer;
    }
  }
</style>
