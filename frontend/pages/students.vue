<template>
  <div>students</div>
</template>

<script>
export default {
  name: 'Students',
  middleware: ['auth', 'teacher']
}
</script>

<style scoped>

</style>
