<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <date-picker
      :error-messages="errorMessages.date"
      :rules="[v => !!v  || 'Item is required']"
      @dateChanged="dateChanged"
    ></date-picker>

    <v-select
      v-model="car"
      :error-messages="errorMessages.car"
      :items="cars"
      item-text="text"
      item-value="value"
      label="Car Driven"
      :rules="[v => !!v  || 'Item is required']"
    ></v-select>

    <v-text-field
      v-model="miles"
      :error-messages="errorMessages.miles"
      label="Miles Driven"
      required
      :rules="[v => !!v  || 'Item is required', v => (v && !isNaN(v)) || 'Must be a number']"
    ></v-text-field>

    <v-btn
      :loading="isLoading"
      :disabled="!valid"
      @click="submit"
    >
      submit
    </v-btn>
    <v-btn @click="clear">clear</v-btn>

  </v-form>
</template>

<script>
import {traxAPI} from "../../traxAPI";
import DatePicker from "../common/DatePicker";

export default {
  components: {
    DatePicker,
  },
  mounted() {
    this.fetchCars();
  },
  data() {
    return {
      isLoading: false,
      valid: true,
      errorMessages: [],
      cars: [],
      date: null,
      car: null,
      miles: null
    }
  },
  methods: {
    dateChanged(date) {
      this.date = date;
    },
    fetchCars() {
      axios.get(traxAPI.getCarsEndpoint())
        .then(response => {
          let cars = [];
          for (let i = 0; i < response.data.data.length; i++) {
            let car = response.data.data[i];
            cars.push({
              text: car.year + ' ' + car.make + ' ' + car.model,
              value: car.id
            });
          }
          this.cars = cars;
        })
        .catch(e => {
          console.log(e);
        });
    },
    submit() {
      if (this.$refs.form.validate()) {
        this.isLoading = true;

        axios.post(traxAPI.addTripEndpoint(), {
          date: this.date.toISOString(),
          car_id: this.car,
          miles: this.miles
        })
          .then(response => {
            this.$router.push('/trips')
          })
          .catch(e => {
            console.log(e);
            this.errorMessages = e.response.data.errors ?? [];
          })
          .finally(() => {
            this.isLoading = false;
          });
      }
    },
    clear() {
      this.$refs.form.reset();
      this.errorMessages = [];
    }
  },
}
</script>
