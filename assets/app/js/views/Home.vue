<template>
  <div class="container py-3">
    <VideoList :videos="videos"></VideoList>
  </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import {mapState} from "vuex";
import VideoList from "../components/VideoList.vue";

export default defineComponent({
  name: 'Home',
  components: {
    VideoList,
  },
  mounted() {
    this.$store.dispatch('loadVideos');
  },
  computed: {
    ...mapState([
      'videos',
    ]),
  }
});
</script>
