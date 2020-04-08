<template>
  <section class="home-header" :style="{'background-image': `url(${background})`}">
    <div class="overlay">
      <div class="container py-5">
        <div class="row align-items-center">
          <div class="col-md-5 col-xs-12">
            <img :src="menova_img" alt="Menova" width="100%" />
          </div>
          <div class="col-md-7 col-xs-12">
            <div class="header-heading">{{header_heading}}</div>
            <div class="header-sub-heading text-white">{{header_sub}}</div>
            <br>
            <Search></Search>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Search from "../global/search";

export default {
  components: {
    Search
  },

  props: ["background", "menova_img", "header_heading", "header_sub"],

  mounted() {
    console.log("Component mounted.");
  }
};
</script>

<style scoped lang="scss">
section.home-header {
  background-repeat: no-repeat;
  background-position: center center;
  background-size: cover;

  .header-heading {
    color: #fff;
    font-size: 50px;
  }

  .header-sub-heading {
      font-size: 18px;
  }
}
</style>
