<template>
  <ContactTabs v-if="userEmail && userEmail != ''"/>
  <UserTabs v-else/>
</template>
<script>
  import UserTabs from '@/views/UserTabs.vue';
  import ContactTabs from '@/views/ContactTabs.vue';

  export default {
    data: () => ({
      userEmail: localStorage.getItem("userEmail")
    }),
    components: {
      UserTabs,
      ContactTabs
    },
  }
</script>



