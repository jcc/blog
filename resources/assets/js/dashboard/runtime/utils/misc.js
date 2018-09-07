import permission from 'dashboard/runtime/constants/permission'

/**
 * @desc 权限检查
 *
 * @param {object} permissions - permissions
 * @param {string} perm - permission name
 *
 * @returns {boolean} - return
 */

export const checkPerm = (permissions, perm) => {
  if (!permissions) {
    return false
  }

  return ((permissions).indexOf(permission[perm]) >= 0)
}
