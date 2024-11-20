
<template>
  <el-steps style="max-width: 100%" :active="active" finish-status="success" align-center>
    <el-step title="Step 1" description="Description of Step 1" />
    <el-step title="Step 2" description="Description of Step 2" />
    <el-step title="Step 3" description="Description of Step 3" />
  </el-steps>

  <div class="flex justify-center items-center w-full">
    <div class="py-4">
      <div v-if="active === 0">
        <h3>Details for Step 1</h3>
        <p>Here you can add any content relevant to Step 1.</p>
      </div>
      <div v-else-if="active === 1">
        <h3>Details for Step 2</h3>
        <p>Here you can add any content relevant to Step 2.</p>
      </div>
      <div v-else-if="active === 2">
        <h3>Details for Step 3</h3>
        <p>Here you can add any content relevant to Step 3.</p>
      </div>
      <div v-else>
        <h3>Process Complete</h3>
        <p>You have completed all the steps.</p>
      </div>
      <el-button style="margin-top: 12px; margin-right: 8px" @click="back" :disabled="active === 0">Back</el-button>
      <el-button style="margin-top: 12px" @click="next">Next step</el-button>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'

const active = ref(0)

const next = () => {
  if (active.value < 3) {
    active.value++
  } else {
    active.value = 0
  }
}

const back = () => {
  if (active.value > 0) {
    active.value--
  }
}
</script>

