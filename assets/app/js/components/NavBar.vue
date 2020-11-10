<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <router-link :to="{name:'home'}" class="navbar-brand">sah</router-link>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Navigatie omschakelen">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main-navbar">
        <ul class="navbar-nav mr-auto">
          <li v-for="category in categories" class="nav-item">
            <router-link :to="{name: 'category', params: {category: category.id}}" class="nav-link">{{category.title}}</router-link>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="/login" class="nav-link">
              <i class="fa fa-user"></i>
              Inloggen
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import {mapState} from "vuex";

export default defineComponent({
  name: 'NavBar',
  created() {
    this.$store.dispatch('loadCategories');
  },
  computed: {
    ...mapState([
      'categories',
    ]),
  }
});
</script>
