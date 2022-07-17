<template>
 <v-menu
    ref="datePicker"
    v-model="showPicker"
    :disabled="disabled"
    :close-on-content-click="false"
    :nudge-right="40"
    transition="scale-transition"
    lazy
    offset-y

  >
    <template #activator="{ on }">
      <v-text-field
        v-model="textFieldValue"
        :error-messages="errorMessages"
        v-on="on"
        :label="label"
        :rules="rules"
        :disabled="disabled"
        :clearable="!disabled"
        slot="activator"
        append-icon="event"
        persistent-hint
        readonly
      />
    </template>
    <v-date-picker
      v-model="pickerValue"
      no-title
      @input="showPicker = false"
    />
  </v-menu>
</template>

<script>
import moment from 'moment';

export default {
  props: {
    disabled: {
      default: false
    },
    label: {
      default: 'Select Date'
    },
    initialDate: {
      default: null
    },
    rules: {
      default: null
    },
    errorMessages: {
      type: [String, Array],
      default: null
    }
  },
  mounted() {
    // don't emit events until after
    // this component is mounted
    this.$nextTick(function () {
      this.eventsEnabled = true;
    })
  },
  created() {
    if (this.initialDate) {
      this.date = this.initialDate;
    }
  },
  data() {
    return {
      showPicker: false,
      pickerValue: null,
      textFieldValue: null,
      date: null,
      eventsEnabled: false
    }
  },
  watch: {
    date() {
      if (this.date === null) {
        return;
      }
      // any change in date we observed must
      // have happened from the outside world
      // hence no event generation is needed.
      this.eventsEnabled = false;
      if (this.date.isValid()) {
        this.textFieldValue = this.date.format('MM/DD/YYYY');
        this.pickerValue = this.date.format('YYYY-MM-DD');
      } else {
        this.textFieldValue = null;
        this.pickerValue = null;
      }
      // enable event generation now that we've set
      // all the values
      this.$nextTick(function () {
        this.eventsEnabled = true;
      })

    },
    pickerValue(val) {
      this.date = moment(val, 'YYYY-MM-DD');
      if (this.date.isValid()) {
        this.textFieldValue = this.date.format('MM/DD/YYYY');
      } else {
        this.date = null;
        this.textFieldValue = null;
      }
      if (this.eventsEnabled) {
        this.$emit('dateChanged', this.date);
      }
    },
    textFieldValue(val) {
      this.date = moment(val, 'MM/DD/YYYY');
      if (this.date.isValid()) {
        this.pickerValue = this.date.format('YYYY-MM-DD');
      } else {
        this.date = null;
        this.textFieldValue = null;
      }
      if (this.eventsEnabled) {
        this.$emit('dateChanged', this.date);
      }
    }

  },
}
</script>

<style scoped>
.v-menu__content {
  /* Fix too wide menu container (Is it Vuetify old version bug?) */
  min-width: 0 !important;
}
</style>
