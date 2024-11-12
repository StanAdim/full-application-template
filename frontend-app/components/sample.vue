<template>
  <div class="profile-view-container p-6 max-w-4xl mx-auto bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold text-gray-900">{{ profileType }} Profile</h1>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Basic Information -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Basic Information</h2>
        <div class="mt-2">
          <p><strong>Name:</strong> {{ profile.name }}</p>
          <p><strong>Email:</strong> {{ profile.email }}</p>
          <p><strong>Phone:</strong> {{ profile.phone }}</p>
          <p><strong>Website:</strong> <a :href="profile.website" class="text-blue-500">{{ profile.website }}</a></p>
        </div>
      </div>

      <!-- Location Information -->
      <div>
        <h2 class="text-lg font-semibold text-gray-800">Location</h2>
        <div class="mt-2">
          <p><strong>Address:</strong> {{ profile.address }}</p>
          <p><strong>City:</strong> {{ profile.city }}</p>
          <p><strong>Country:</strong> {{ profile.country }}</p>
        </div>
      </div>

      <!-- Additional Information (for Startups, Hubs, etc.) -->
      <div v-if="profileType === 'Startup'" class="md:col-span-2">
        <h2 class="text-lg font-semibold text-gray-800">Founders</h2>
        <ul class="mt-2 list-disc list-inside">
          <li v-for="founder in profile.founders" :key="founder">{{ founder }}</li>
        </ul>
      </div>

      <div v-if="profileType === 'Hub'" class="md:col-span-2">
        <h2 class="text-lg font-semibold text-gray-800">Supported Programs</h2>
        <ul class="mt-2 list-disc list-inside">
          <li v-for="program in profile.programs" :key="program">{{ program }}</li>
        </ul>
      </div>

      <div v-if="profileType === 'Accelerator'" class="md:col-span-2">
        <h2 class="text-lg font-semibold text-gray-800">Mentorship Areas</h2>
        <ul class="mt-2 list-disc list-inside">
          <li v-for="area in profile.mentorshipAreas" :key="area">{{ area }}</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Sample data (replace with actual data)
const profileType = 'Startup'; // can be 'Startup', 'Hub', or 'Accelerator'
const profile = ref({
  name: 'Tech Innovators Ltd.',
  email: 'info@techinnovators.com',
  phone: '+123 456 7890',
  website: 'https://techinnovators.com',
  address: '123 Innovation Ave',
  city: 'Dar es Salaam',
  country: 'Tanzania',
  founders: ['Jane Doe', 'John Smith'],
  programs: ['Youth Empowerment', 'Digital Literacy'], // For 'Hub'
  mentorshipAreas: ['Business Strategy', 'Product Development'], // For 'Accelerator'
});
</script>

<style scoped>
.profile-view-container {
  background-color: #f9fafb; /* Light background */
}
</style>
