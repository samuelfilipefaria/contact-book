<template>
  <v-card>
    <v-tabs
      v-model="tab"
      color="deep-purple-accent-4"
      align-tabs="center"
    >
      <v-tab :value="1" @click="changeCurrentForm(1)">Cadastro</v-tab>
      <v-tab :value="2" @click="changeCurrentForm(2)">Login</v-tab>
    </v-tabs>
    <v-window v-model="tab">
      <v-window-item
        v-for="n in 2"
        :key="n"
        :value="n"
      >
        <v-container fluid>
          <component :is="currentForm"/>
        </v-container>
      </v-window-item>
    </v-window>
  </v-card>
</template>
<script>
  import RegisterForm from '@/components/RegisterForm.vue';
  import LoginForm from '@/components/LoginForm.vue';

  export default {
    data: () => ({
      tab: null,
      currentForm: RegisterForm
    }),
    components: {
      RegisterForm,
      LoginForm
    },

    methods: {
      changeCurrentForm(tabValue) {
        this.currentForm = tabValue == 1 ? RegisterForm : LoginForm;
      }
    }
  }
</script>