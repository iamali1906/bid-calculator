<template>
  <v-app>
    <v-main>
      <BidCalculator/>
    </v-main>
  </v-app>
</template>

<script>
import BidCalculator from './components/BidCalculator.vue'

export default {
  name: 'App',

  components: {
    BidCalculator,
  },

  data: () => ({
    //
  }),
}
</script>
