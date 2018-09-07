import Vue from 'vue'
import {
  checkPerm
} from 'runtime/utils'

Vue.mixin({
  methods: {

    /**
     * @desc Check the user if has the permission
     *
     * @param {string} permission
     * @param {string} type
     *
     * @returns {boolean}
     */
    checkPermission(permission, type = 'api') {
      let data = this.$store.state.auth.user

      if (data.is_super_admin) {
        return true
      }

      return checkPerm(data, permission)
    },
  }
})
