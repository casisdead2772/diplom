<template>
  <div>
    <va-aside-layout :title="asideTitle">
      <users-show v-if="show" :item="item"></users-show>
      <users-form v-else :id="id" :item="item" @saved="onSaved"></users-form>
    </va-aside-layout>
    <v-card>
      <v-card-title>
        <h1 class="display-1">
          {{ title }}
        </h1>
      </v-card-title>
      <v-card-text>
        <va-list ref="list" disable-create-redirect @action="onAction">
          <va-data-table
            :fields="fields"
            disable-create-redirect
            disable-show-redirect
            disable-edit-redirect
            @item-action="onAction"
          >
          </va-data-table>
        </va-list>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  props: ["resource", "title"],
  data() {
    return {
      fields: [
        { source: "name", sortable: true },
        { source: "email", type: "email" }
      ],
      asideTitle: null,
      id: null,
      item: null,
      show: false
    };
  },
  methods: {
    async onAction({ action, title, id, item }) {
      this.asideTitle = title;
      this.id = id;
      this.show = action === "show";
      this.item = item;
    },
    onSaved() {
      this.asideTitle = null;
      this.$refs.list.fetchData();
    }
  }
};
</script>
