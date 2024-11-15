
<!--<template>-->
<!--  <el-steps style="max-width: 100%" :active="active" finish-status="success" align-center>-->
<!--    <el-step title="Step 1" description="Description of Step 1" />-->
<!--    <el-step title="Step 2" description="Description of Step 2" />-->
<!--    <el-step title="Step 3" description="Description of Step 3" />-->
<!--  </el-steps>-->

<!--  <div class="flex justify-center items-center w-full">-->
<!--    <div class="py-4">-->
<!--      <div v-if="active === 0">-->
<!--        <h3>Details for Step 1</h3>-->
<!--        <p>Here you can add any content relevant to Step 1.</p>-->
<!--      </div>-->
<!--      <div v-else-if="active === 1">-->
<!--        <h3>Details for Step 2</h3>-->
<!--        <p>Here you can add any content relevant to Step 2.</p>-->
<!--      </div>-->
<!--      <div v-else-if="active === 2">-->
<!--        <h3>Details for Step 3</h3>-->
<!--        <p>Here you can add any content relevant to Step 3.</p>-->
<!--      </div>-->
<!--      <div v-else>-->
<!--        <h3>Process Complete</h3>-->
<!--        <p>You have completed all the steps.</p>-->
<!--      </div>-->
<!--      <el-button style="margin-top: 12px; margin-right: 8px" @click="back" :disabled="active === 0">Back</el-button>-->
<!--      <el-button style="margin-top: 12px" @click="next">Next step</el-button>-->
<!--    </div>-->
<!--  </div>-->
<!--</template>-->

<!--<script lang="ts" setup>-->
<!--import { ref } from 'vue'-->

<!--const active = ref(0)-->

<!--const next = () => {-->
<!--  if (active.value < 3) {-->
<!--    active.value++-->
<!--  } else {-->
<!--    active.value = 0-->
<!--  }-->
<!--}-->

<!--const back = () => {-->
<!--  if (active.value > 0) {-->
<!--    active.value&#45;&#45;-->
<!--  }-->
<!--}-->
<!--</script>-->


<template>
  <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 p-6">
    <!-- Header Section -->
    <div class="text-center mb-6">
      <h2 class="text-xl font-semibold text-blue-600">Register Your Product</h2>
      <p class="text-xl text-blue-600">Fill in the required product information</p>
    </div>

    <!-- Tabs Section -->
    <div class="flex justify-center mb-4 border-b border-gray-300 w-full max-w-4xl">
      <button class="flex-1 py-2 font-semibold text-blue-600 border-b-2 border-blue-500 focus:outline-none">
        Product Details
      </button>
      <span class="flex-none py-2 text-gray-400 font-semibold">1/6</span>
    </div>

    <!-- Form Section -->
    <div class="w-full max-w-4xl bg-white rounded-lg shadow-md p-6">
      <form @submit.prevent="submitForm">
        <!-- Product Details -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-blue-600 mb-2">Product Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-gray-600 text-sm font-semibold mb-1">Product Name</label>
              <input
                  type="text"
                  class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
              />
            </div>
            <div>
              <label class="block text-gray-600 text-sm font-semibold mb-1">Category</label>
              <select
                  class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
              >
                <option value="" disabled selected>Select category</option>
                <option value="software">Software</option>
                <option value="hardware">Hardware</option>
                <option value="mobile-app">Mobile App</option>
                <option value="web-app">Web App</option>
                <option value="ai-solution">AI Solution</option>
              </select>
            </div>
            <div>
              <label class="block text-gray-600 text-sm font-semibold mb-1">Launch Date</label>
              <input
                  type="date"
                  class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
              />
            </div>
            <div>
              <label class="block text-gray-600 text-sm font-semibold mb-1">Description</label>
              <textarea
                  class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
                  rows="3"
              ></textarea>
            </div>
          </div>
        </div>

        <!-- Technical Specifications -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-blue-600 mb-2">Technical Specifications</h3>
          <div>
            <label class="block text-gray-600 text-sm font-semibold mb-1">Technology Stack</label>
            <input
                type="text"
                placeholder="E.g., Vue.js, Laravel, AWS"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
            />
          </div>
        </div>

        <!-- Market Details -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-blue-600 mb-2">Market Details</h3>
          <div>
            <label class="block text-gray-600 text-sm font-semibold mb-1">Target Audience</label>
            <input
                type="text"
                placeholder="E.g., Small businesses, Students"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
            />
          </div>
        </div>

        <!-- Intellectual Property -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-blue-600 mb-2">Intellectual Property</h3>
          <div>
            <label class="block text-gray-600 text-sm font-semibold mb-1">Patent/Trademark Details</label>
            <input
                type="text"
                placeholder="E.g., Patent number or 'None'"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
            />
          </div>
        </div>

        <!-- Supporting Media -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-blue-600 mb-2">Supporting Media</h3>
          <div>
            <label class="block text-gray-600 text-sm font-semibold mb-1">Demo Link</label>
            <input
                type="url"
                placeholder="E.g., https://example.com"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
            />
          </div>
        </div>

        <!-- Impact and Usage Metrics -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-blue-600 mb-2">Impact and Usage Metrics</h3>
          <div>
            <label class="block text-gray-600 text-sm font-semibold mb-1">Number of Users</label>
            <input
                type="number"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
            />
          </div>
        </div>

        <!-- Legal and Compliance Information -->
        <div class="mb-6">
          <h3 class="text-lg font-semibold text-blue-600 mb-2">Legal and Compliance Information</h3>
          <div>
            <label class="block text-gray-600 text-sm font-semibold mb-1">Compliance Details</label>
            <textarea
                placeholder="E.g., GDPR compliant, ISO 27001"
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
                rows="3"
            ></textarea>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between items-center mt-6">
          <button class="text-gray-500 font-semibold flex items-center space-x-2 hover:text-gray-700">
            <span>&larr;</span>
            <span>Go back</span>
          </button>
          <button
              type="submit"
              class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-md flex items-center space-x-2 hover:bg-blue-600"
          >
            <span>Submit</span>
            <span>&rarr;</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductRegistrationForm",
  methods: {
    submitForm() {
      alert("Form submitted!");
    }
  }
};
</script>

<style scoped>
/* Scoped styles for custom adjustments if necessary */
</style>

