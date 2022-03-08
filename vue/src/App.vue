<template>
  <mainNavbar class="mb-lg-5 mb-4"></mainNavbar>
  <router-view />
</template>

<script>
import mainNavbar from '@/components/Navbar.vue';


export default {
  components: {
    'mainNavbar': mainNavbar
  },

}
</script>
