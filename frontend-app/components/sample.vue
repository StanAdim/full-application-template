<!-- components/DynamicInputs.vue -->
<template>
  <div class="dynamic-inputs">
    <h2>Dynamic Inputs</h2>

    <div v-for="(input, index) in inputs" :key="index" class="input-group">
      <input
          v-model="input.value"
          type="text"
          :placeholder="'Input ' + (index + 1)"
          class="form-input"
      >
      <button
          @click="removeInput(index)"
          class="remove-btn"
      >
        Remove
      </button>
    </div>

    <button @click="addInput" class="add-btn">
      Add New Input
    </button>

    <!-- Display values for demonstration -->
    <div class="values-display">
      <h3>Current Values:</h3>
      <pre>{{ JSON.stringify(inputValues, null, 2) }}</pre>
    </div>
  </div>
</template>

<script setup>
const inputs = ref([{ value: '' }])

const inputValues = computed(() => {
  return inputs.value.map(input => input.value)
})

const addInput = () => {
  inputs.value.push({ value: '' })
}

const removeInput = (index) => {
  inputs.value.splice(index, 1)
  // Ensure at least one input remains
  if (inputs.value.length === 0) {
    inputs.value.push({ value: '' })
  }
}
</script>

<style scoped>
.dynamic-inputs {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.input-group {
  display: flex;
  gap: 10px;
  margin-bottom: 10px;
}

.form-input {
  flex: 1;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.add-btn,
.remove-btn {
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.add-btn {
  background-color: #4CAF50;
  color: white;
  margin-top: 10px;
}

.remove-btn {
  background-color: #f44336;
  color: white;
}

.values-display {
  margin-top: 20px;
  padding: 10px;
  background-color: #f5f5f5;
  border-radius: 4px;
}

pre {
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>