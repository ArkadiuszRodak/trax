<template>
  <div>
    <v-layout style="margin-bottom: 20px">
      <v-flex xs12 style="text-align: right">
        <v-btn class="success" @click="addCarSelected">Add Car</v-btn>
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
            <tr @click="rowClicked(props.item.id)">
              <td>{{ props.item.year }}</td>
              <td>{{ props.item.make }}</td>
              <td>{{ props.item.model }}</td>
            </tr>
          </template>
        </v-data-table>
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
      items: [],
      headers: [
        {text: 'Year', value: 'date'},
        {text: 'Make', value: 'make'},
        {text: 'Model', value: 'model'},
      ]
    }
  },
  watch: {},
  computed: {},
  methods: {
    fetch() {
      this.isLoading = true;

      axios.get(traxAPI.getCarsEndpoint())
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
    rowClicked(id) {
      this.$router.push('/cars/' + id);
    },
    addCarSelected() {
      this.$router.push('/new-car');
    }
  },
}
</script>
