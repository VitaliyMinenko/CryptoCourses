<template>
  <div class="container main">
    <div class="row mt-5">
      <div class="col text-right">Select Currency</div>
      <div class="col">
        <select class="form-control" v-model="currentCurrency" :change="changeCurrency()">
          <option v-for="option in currency">
            {{ option }}
          </option>
        </select>
      </div>
      <div class="col text-right">Select Date</div>
      <div class="col">
        <date-picker v-if="currentDate.length > 0" v-model="currentDate" valueType="format" :disabled-date="disabledRange"></date-picker>
      </div>
    </div>
    <div class="row mt-5" v-if="loaded">
      <table class="table table-striped">
        <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Symbol</th>
          <th scope="col">Opening Price</th>
          <th scope="col">Closing Price</th>
          <th scope="col">Change %</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="value in currentCrypto">
          <th scope="row">{{ value.name }}</th>
          <td>{{ value.symbol }}</td>
          <td>{{ value.opening_price }}</td>
          <td>{{ value.closing_price }}</td>
          <td>{{ value.change }}</td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-else class="d-flex justify-content-center mt-5 pb-5">
      <pulse-loader class="mt-5" :loading="true"></pulse-loader>
    </div>
    <div v-if="message.length > 0" class="d-flex justify-content-center mt-5">
      <p>{{ message }}</p>
    </div>

  </div>

</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

import moment from 'moment'
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

export default {
  name: 'MainTable',
  components: {
    DatePicker,
    PulseLoader
  },
  data() {
    return {
      crypto: [],
      currency: [],
      currentCurrency: '',
      message: '',
      loaded: false,
      days: [],
      currentDate: '',
      disabledBefore: '',
      disabledAfter: '',
      INIT_URL: '/api/v1/init/date/',
      RELOAD_URL: '/api/v1/crypto/date/',
      ERROR_MESSAGE: 'Ops, something went wrong, try again later.',
      ERROR_STATUS: 'error'
    }
  },
  watch: {
    currentDate: function (newDate, oldDate) {
      if (newDate !== oldDate && oldDate.length > 0) {
        this.reloadCrypto(newDate);
      }
    }
  },
  created() {
    this.currentDate = moment().format("YYYY-MM-DD");
    this.disabledBefore = moment().subtract(365, 'days');
    this.disabledAfter = moment();
    this.message = '';
  },
  mounted() {
    this.init();
  },

  methods: {
    changeCurrency: function () {
      this.currentCrypto = this.crypto[this.currentCurrency];
    },

    disabledRange: function (date) {
      return date <= this.disabledBefore || date > this.disabledAfter;
    },

    init: function () {
      fetch(this.INIT_URL + this.currentDate)
          .then(response => response.json())
          .then(response => {
            if (response.status === this.ERROR_STATUS) {
              this.loaded = true;
              this.message = response.message;
            }
            this.crypto = response.data.crypto;
            this.currency = response.data.currency;
            this.currentCurrency = response.data.currency[0];
            this.currentDate = response.data.current_date;
            this.currentCrypto = this.crypto[this.currentCurrency];
            this.loaded = true;
          }).catch(() => {
        this.loaded = true;
        this.message = this.ERROR_MESSAGE;
      });
    },

    reloadCrypto: function () {
      this.loaded = false;
      this.message = '';
      this.crypto = []; debugger;
      fetch(this.RELOAD_URL + this.currentDate)
          .then(response => response.json())
          .then(response => {
            if (response.status === this.ERROR_STATUS) {
              this.loaded = true;
              this.message = response.message;
            }
            this.crypto = response.data.crypto;
            this.loaded = true;
          }).catch(() => {
        this.loaded = true;
        this.message = this.ERROR_MESSAGE;
      });
    }
  }
}
</script>

<style scoped>

</style>