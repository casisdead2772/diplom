
/**
 * @param {Array} value
 * @returns {Boolean}
 */
export default function checkPermission (value) {
  if (value && Array.isArray(value) && value.length > 0) {
    const roles = this.$store.getters && this.$store.getters.roles
    const permissionRoles = value
    return roles.some((role) => {
      return permissionRoles.includes(role)
    })
  } else {
    // eslint-disable-next-line no-console
    console.error('need roles! Like v-permission="[\'admin\',\'editor\']"')
    return false
  }
}
