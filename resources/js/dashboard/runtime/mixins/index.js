import Vue from 'vue'
import {
  checkPerm
} from 'dashboard/runtime/utils'

Vue.mixin({
  methods: {

    /**
     * @desc Check the user if has the permission
     *
     * @param {string} permission
     *
     * @returns {boolean}
     */
    checkPermission(permission) {
      let data = window.Permissions

      if (window.isSuperAdmin) {
        return true
      }

      return checkPerm(data, permission)
    },

    /**
     * @desc Check the user if has the permissions
     *
     * @param {string} permissions
     *
     * @returns {boolean}
     */
    checkPermissions(permissions) {
      let i = 0,
          data = window.Permissions

      if (window.isSuperAdmin) {
        return true
      }

      permissions.forEach((item) => {
        if (item.permission) {
          i = checkPerm(data, item.permission) ? i + 1 : i
        }
      })

      return i > 0
    }
  }
})
