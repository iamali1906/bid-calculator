<template>
  <v-container>
    <v-card class="mx-auto my-12" max-width="600">
      <v-card-title>Bid Calculation Tool</v-card-title>

      <v-card-text>
        <v-form>
          <v-text-field
            v-model="price"
            label="Vehicle Base Price"
            type="number"
            required
          ></v-text-field>

          <v-select
            v-model="vehicleType"
            :items="['common', 'luxury']"
            label="Vehicle Type"
            required
          ></v-select>

          <v-btn color="primary" @click="calculateBid" :disabled="!price || !vehicleType">Calculate</v-btn>
        </v-form>

        <v-alert v-if="error" type="error" dismissible class="mt-4">{{ error }}</v-alert>

        <v-divider class="my-4"></v-divider>
        <div v-if="result">
          <h3>Total Cost: ${{ result.totalCost }}</h3>
          <v-list dense>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Base Price</v-list-item-title>
                <v-list-item-subtitle>${{ result.basePrice || 0 }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Buyer Fee</v-list-item-title>
                <v-list-item-subtitle>${{ (result.buyerFee || 0).toFixed(2) }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Special Fee</v-list-item-title>
                <v-list-item-subtitle>${{ (result.specialFee || 0).toFixed(2) }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Association Fee</v-list-item-title>
                <v-list-item-subtitle>${{ (result.associationFee || 0).toFixed(2) }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>

            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>Storage Fee</v-list-item-title>
                <v-list-item-subtitle>${{ (result.storageFee || 0).toFixed(2) }}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </div>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      price: null,
      vehicleType: null,
      result: null,
      error: null, // Error state
    };
  },
  methods: {
    async calculateBid() {
      this.error = null; 
      this.result = null;

      try {
        const response = await fetch(`${process.env.VUE_APP_API_BASE_URL}/calculate`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            price: this.price,
            type: this.vehicleType,
          }),
        });
        
        const data = await response.json();

        if (!response.ok) {
          throw new Error(data.error || "Failed to calculate bid.");
        }


        if (!data || typeof data.totalCost !== 'number') {
          throw new Error("Invalid response from the server.");
        }

        this.result = data;
      } catch (error) {
        this.error = error.message || "An unexpected error occurred.";
        console.error("Error calculating bid:", error);
      }
    },
  },
};
</script>

<style>
h3 {
  color: #3f51b5;
  font-weight: bold;
  text-align: center;
}
</style>
