export default defineNuxtConfig({
  devtools: { enabled: true },
  modules:
      ["@nuxtjs/tailwindcss",
        '@pinia/nuxt',
      ],
  app: {
    pageTransition: { name: 'page', mode: 'out-in' , name: 'fade' },
    layoutTransition: { name: 'layout', mode: 'out-in' ,    name: 'bounce',},
    head: {
      title: 'Tanzania Startups - ICT Commission', // Set the default title for your application
      meta: [
        { charset: 'utf-8' },
        { 'http-equiv': 'pragma', content: 'no-cache' },
        { 'http-equiv': 'cache-control', content: 'no-cache' },
        { 'http-equiv': 'expires', content: '0' },
        { content: 'telephone=no', name: 'format-detection' }
      ],
      link: [
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap'
        }
      ],
    },
    pageTransition: {
      name: 'fade',
      mode: 'out-in' // default
    },
    layoutTransition: {
      name: 'slide',
      mode: 'out-in' // default
    },
  },
  runtimeConfig:{
    public:{
      appName:  'Tanzania Startups - ICT Commission',
      apiBaseUlr: process.env.API_URL ,
      baseUrl: process.env.BASE_URL,
    }
  },
  css:[
    "~/assets/css/app.css",
  ]
})