<template>
  <div>
    <v-layout style="margin-bottom: 20px">
      <v-flex xs12 style="text-align: right">
        <v-btn class="success" @click="addTripSelected">Add Trip</v-btn>
      </v-flex>
    </v-layout>
    <v-layout>
      <v-flex xs12>
        <v-data-table
          :loading="isLoading"
          :headers="headers"
          :items="items"
          :disable-initial-sort="true"
          class="elevation-1"
          hide-actions
        >
          <template slot="items" slot-scope="props">
            <td>{{ props.item.date }}</td>
            <td>{{ props.item.car.year + ' ' + props.item.car.make + ' ' + props.item.car.model }}</td>
            <td>{{ props.item.miles }}</td>
            <td>{{ props.item.total }}</td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import { traxAPI } from "@/traxAPI";

export default {
  mounted() {
    this.fetch();
  },
  data() {
    return {
      isLoading: false,
      items: [],
      headers: [
        {text: 'Date', value: 'date'},
        {text: 'Car', value: 'car'},
        {text: 'Miles', value: 'miles'},
        {text: 'Miles Balance', value: 'total'},
      ]
    }
  },
  watch: {},
  computed: {},
  methods: {
    fetch() {
      this.isLoading = true;

      axios.get(traxAPI.getTripsEndpoint())
        .then(response => {
          this.items = response.data.data;
        })
        .catch(e => {
          console.log(e);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    addTripSelected() {
      this.$router.push('new-trip')
    }
  },
}
</script>
