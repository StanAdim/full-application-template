<script setup lang="ts">
const categories = [
  {title: 'ICT Startups',
    icon: 'startup-management.png',
    description : 'An Information and Communication Technology company in the first stages of operations,\n' +
        '            founded by one or more entrepreneurs who want to develop a product or service for which \n' +
        '            they believe there is demand.' ,
    style: 'bg-blue-500 text-white'},
  { title: 'ICT Small / Medium Companies',
    icon: 'corporate-culture.png',
    description : 'Registered businesses or enterprises which use ICT innovations in offering their services. The nature of SMEs are normally registered Sole proprietor businesses, or partnership firms.' ,
    style: 'bg-yellow-400 text-black'},
  { title: 'ICT Innovators',
    icon: 'project-management.png',
    description : 'A cutting-edge digital technology individuals who solve society business problems and\n' +
        ' normally have working prototypes or Minimum viable products or full functioning products developed ready for use.' ,
    style: 'bg-black text-white'
  }, {
    title: 'Grant Programs',
    icon: 'charity.png',
    description : 'Different ways the government funds innovation ideas and projects to provide public services and\n' +
        ' stimulate the economy. Grants normally are provided to support critical recovery initiatives, innovative research.' ,
    style: 'bg-green-500 text-white' },
  {title: 'Grass-root Innovation Hubs',
    icon: 'grassroot.png',
    description : 'Designed to stimulate ICT innovations at lower ages such as in Primary\n' +
        ' school level and secondary school level. Aim to stimulate the students\n' +
        ' mindset to see potential in science and technology and developing solutions that tap daily life community problems.' ,
    style: 'bg-blue-300 text-black'},
  {title: 'ICT Accelerators',
    icon: 'accelerator.png',
    description : 'Institution that nurtures entrepreneurs to create successful ICT start ups\n' +
        ' and provide a set of designed services to foster their growth for a specific period of time.\n' +
        ' Encouraging those whose career is beginning to realize their innovative ideas in a quicker and easier way.' ,
    style: 'bg-yellow-300 text-black'},
]
</script>

<template>
  <div class="container mx-auto mt-4">
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      <GuestCardCategory v-for="item in categories"
                         :key="item.title"
                    :title="item.title"
                    :style="item.style" :icon="item.icon"
                    :description="item.description"
      />

    </div>
  </div>
</template>

<style scoped>

</style>