<template>
  <section>
    <v-row no-gutters>
      <v-col cols="12">
        <component
          :is="`section-${section}`"
          v-for="section in sections"
          :key="section"
        />
      </v-col>
    </v-row>
  </section>
</template>
<script>
import LoadSections from '@/mixins/load-sections'
export default {
  name: 'Home',
  middleware: 'guest',
  metaInfo: { title: 'Home' },
  mixins: [
    LoadSections([
      'search'
    ])
  ]
}
</script>
