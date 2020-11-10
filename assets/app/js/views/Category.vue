<template>
  <div class="container py-3" v-if="category">
    <h1>{{category.title}}</h1>
  </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue';

export default defineComponent({
  name: 'Category',
  data() {
    return {
      categoryId: false
    }
  },
  mounted() {
    this.categoryId = this.$route.params.category;
  },
  computed: {
    category() {
      return this.$store.state.categories.find(cat => cat.id === this.categoryId);
    }
  },
  watch: {
    $route(to) {
      this.categoryId = to.params.category;
    },
  }
});
</script>
