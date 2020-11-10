<template>
  <div class="embed-responsive embed-responsive-16by9">
    <div ref="video"></div>
  </div>
</template>

<script lang="ts">
import {ref, defineComponent} from 'vue';
import YouTubePlayer from 'youtube-player';

export default defineComponent({
  name: 'YoutubeVideo',
  props: {
    videoId: String,
  },
  setup() {
    const video = ref(null)
    return {
      video
    }
  },
  mounted() {
    console.log(this.videoId);
    const player = YouTubePlayer(this.$refs.video, {
      videoId: this.videoId,
    });
    // player.loadVideoById('M7lc1UVf-VE');
    // player.stopVideo();
  }
});
</script>
