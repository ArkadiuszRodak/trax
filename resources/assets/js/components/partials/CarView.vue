<template>
  <div>
    <v-layout row style="margin-bottom: 20px">
      <v-flex xs10>
        <h1>
          <span v-if="isLoading">Loading...</span>
          <template v-else>
            {{ year }} {{ make }} {{ model }}
          </template>
        </h1>
      </v-flex>
      <v-flex xs2 style="text-align: right">
        <v-btn class="error" @click="deleteSelected">Delete</v-btn>
      </v-flex>
    </v-layout>
    <v-layout row>
      <v-flex xs3>
        <h3>Number of Trips</h3>
      </v-flex>
      <v-flex xs9>
        <h3>{{ isLoading ? 'Loading...' : trip_count }}</h3>
      </v-flex>
    </v-layout>
    <v-layout row>
      <v-flex xs3>
        <h3>Total Trip Miles</h3>
      </v-flex>
      <v-flex xs9>
        <h3>{{ isLoading ? 'Loading...' : trip_miles }}</h3>
      </v-flex>
    </v-layout>

  </div>
</template>

<script>
import { traxAPI } from "@/traxAPI";

export default {
  props: [],
  mounted() {
    this.fetch();
  },
  data() {
    return {
      isLoading: false,
      year: null,
      make: null,
      model: null,
      trip_count: null,
      trip_miles: null
    }
  },
  methods: {
    fetch() {
      this.isLoading = true;

      axios.get(traxAPI.getCarEndpoint(this.$route.params.id))
        .then(response => {
          this.year = response.data.data.year;
          this.make = response.data.data.make;
          this.model = response.data.data.model;
          this.trip_count = response.data.data.trip_count;
          this.trip_miles = response.data.data.trip_miles;
        })
        .catch(e => {
          console.log(e);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    deleteSelected() {
      axios.delete(traxAPI.deleteCarEndpoint(this.$route.params.id))
        .then(response => {
          this.$router.push('/cars');
        }).catch(e => {
        alert('Failed To Delete')
      });
    }
  },
  components: {}
}
</script>
