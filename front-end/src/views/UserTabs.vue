<template>
  <v-card>
    <v-card
      v-if="userEmail"
      border
      class="mb-2"
      density="compact"
      prepend-avatar="https://randomuser.me/api/portraits/women/10.jpg"
      variant="text"
      :title="userEmail"
    >
      <v-card-actions>
        <v-btn>
          <v-icon
            icon="mdi-arrow-left"
            size="18"
            class="mr-2"
          />
          Sair
        </v-btn>
      </v-card-actions>
    </v-card>

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
      currentForm: RegisterForm,
      userEmail: localStorage.getItem("userEmail")
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



