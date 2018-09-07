import permission from 'runtime/constants/permission'

/**
 * @desc 权限检查
 *
 * @param {object} data - 权限信息
 * @param {string} perm - 待检查的权限的名称
 *
 * @returns {boolean} - 返回是否具有权限
 */

export const checkPerm = (data, perm) => {
  // 获取当前用户所拥有的全部权限
  let perms = data.permissions ? data.permissions : ''

  if (!perms) {
    return false
  }

  let allowed = false

  for (let i in perms) {
    let permissionName = permission[perm]

    if (perms[i].name === permissionName) {
      allowed = true
      break
    }
  }

  return allowed
}
