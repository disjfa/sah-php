<template>
  <div class="container py-3" v-if="currentVideo.id">
    <h1>{{currentVideo.title}}</h1>
    {{currentVideo.video}}
    <YoutubeVideo :video-id="currentVideo.video"></YoutubeVideo>
  </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import {mapState} from "vuex";
import YoutubeVideo from "../components/YoutubeVideo.vue";

export default defineComponent({
  name: 'Video',
  components: {
    YoutubeVideo,
  },
  data() {
    return {
      videoId: false
    }
  },
  mounted() {
    this.videoId = this.$route.params.video;
    this.loadCurrentVideo();
  },
  methods: {
    loadCurrentVideo() {
      this.$store.dispatch('loadVideo', this.videoId);
    }
  },
  computed: {
    ...mapState([
       'currentVideo'
    ]),
  },
  watch: {
    $route(to) {
      this.videoId = to.params.video;
      this.loadCurrentVideo();
    },
  }
});
</script>
