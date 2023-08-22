<template>
  <v-card>
    <v-card
      v-if="userEmail && userEmail != ''"
      border
      class="mb-2"
      density="compact"
      prepend-avatar="https://randomuser.me/api/portraits/women/10.jpg"
      variant="text"
      :title="userEmail"
    >
      <v-card-actions>
        <v-btn @click="logout">
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
      <v-tab :value="1" @click="changeCurrentForm(1)">Contatos</v-tab>
      <v-tab :value="2" @click="changeCurrentForm(2)">Criar/Editar</v-tab>
    </v-tabs>
    <v-window v-model="tab">
      <v-window-item
        v-for="n in 2"
        :key="n"
        :value="n"
      >
        <v-container fluid>
          <ContactForm/>
        </v-container>
      </v-window-item>
    </v-window>
  </v-card>
</template>
<script>
  import ContactForm from '@/components/ContactForm.vue';

  export default {
    data: () => ({
      tab: null,
      isEdition: false,
      userEmail: localStorage.getItem("userEmail")
    }),
    components: {
      ContactForm
    },

    methods: {
      changeCurrentForm(tabValue) {
        console.log('preencher campos' + tabValue);
      },
      logout() {
        localStorage.setItem("userEmail", '');
        location.reload();
      }
    }
  }
</script>



