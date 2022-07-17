<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-text-field
      v-model="year"
      :error-messages="errorMessages.year"
      :rules="[v => !!v  || 'Item is required', v => (v && v.length === 4 && !isNaN(v)) || 'Must be 4 digit year']"
      label="Year"
      required
    ></v-text-field>
    <v-text-field
      v-model="make"
      :error-messages="errorMessages.make"
      label="Make"
      required
      :rules="[v => !!v || 'Item is required']"
    ></v-text-field>
    <v-text-field
      v-model="model"
      :error-messages="errorMessages.model"
      label="Model"
      required
      :rules="[v => (!!v) || 'Item is required']"
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

export default {
  data() {
    return {
      isLoading: false,
      valid: true,
      errorMessages: [],
      year: null,
      make: null,
      model: null
    }
  },
  methods: {
    submit() {
      if (this.$refs.form.validate()) {
        this.isLoading = true;

        axios.post(traxAPI.addCarEndpoint(), {
          year: this.year,
          make: this.make,
          model: this.model
        })
          .then(response => {
            this.$router.push('/cars')
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
