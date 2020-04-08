<template>
  <div class="search-form row">
    <div class="col-md-5 col-xs-12 p-0 m-0">
      <multiselect
        :multiple="true"
        v-model="value"
        :options="options"
        :close-on-select="false"
        :searchable="false"
      ></multiselect>
    </div>
    <div class="col-md-7 col-xs-12 p-0 m-0">
      <div class="search-wrapper panel-heading col-sm-12 m-0 p-0">
        <form action>
          <input
            type="text"
            name="search"
            class="search form-control border-0"
            placeholder="I'm Looking For"
          />
          <button class="btn" type="submit">
            <icon class="fa fa-search text-white"></icon>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
  name: "search",
  components: { Multiselect },
  data() {
    return {
      value: null,
      options: ["Freelancer", "Jobs", "Employer"],
      searchQuery: null,
      resources: [
        {
          title: "ABE Attendance",
          uri: "aaaa.com",
          category: "a",
          icon: null
        },
        {
          title: "Accounting Services",
          uri: "aaaa.com",
          category: "a",
          icon: null
        },
        {
          title: "Administration",
          uri: "aaaa.com",
          category: "a",
          icon: null
        }
      ]
    };
  },
  computed: {
    resultQuery() {
      if (this.searchQuery) {
        return this.resources.filter(item => {
          return this.searchQuery
            .toLowerCase()
            .split(" ")
            .every(v => item.title.toLowerCase().includes(v));
        });
      } else {
        return this.resources;
      }
    }
  }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style lang="scss" scoped>
.search-form {
  background: #fff;
  border-radius: 5px;
  overflow: hidden;

  .search-wrapper {
    form {
      position: relative;

      .search {
        height: 45px;
      }

      button {
        height: 45px;
        position: absolute;
        top: 0;
        right: 0;
        background-color: #3490dc;
        color: #fff;
        font-size: 18px;
        border-radius: 0;
      }
    }
  }

  .multiselect__tags {
    border-radius: 0 !important;
    padding: 0;
  }
}
</style>