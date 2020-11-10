<template>
  <div class="row">
    <div class="col-12 col-lg-3 py-2" v-for="video in videos" :key="video.id">
      <router-link :to="{name: 'video', params: {video: video.id}}" class="card h-100">
        <img :src="'https://img.youtube.com/vi/'+video.video+'/hqdefault.jpg'" alt="" class="card-img-top">
        <div class="card-body">
          <h6 class="card-title">{{ video.title }}</h6>
        </div>
      </router-link>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue';

export default defineComponent({
  name: 'VideoList',
  props: {
    videos: Object,
  }
});
</script>
