<template>
  <v-card>
    <v-card
      v-if="userEmail && userEmail != ''"
      border
      class="mb-2"
      density="compact"
      :prepend-avatar="userPhoto"
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
      <v-tab :value="2" @click="changeCurrentForm(2)" id="contactFormTab">{{ contactFormTitle }}</v-tab>
    </v-tabs>
    <v-window v-model="tab">
      <v-window-item
        v-for="n in 2"
        :key="n"
        :value="n"
      >
        <v-container fluid>
          <component :is="currentForm" :isEdition="isEdition" :contactData="contactData" @editContact="loadEditionForm" @cancelEditionForm="cancelEditionForm"/>
        </v-container>
      </v-window-item>
    </v-window>
  </v-card>
</template>
<script>
  import axios from 'axios'

  import ContactForm from '@/components/ContactForm.vue';
  import ContactList from '@/components/ContactList.vue';

  export default {
    data: () => ({
      tab: null,
      isEdition: false,
      userEmail: localStorage.getItem("userEmail"),
      currentForm: ContactList,
      contactFormTitle: "Criar contato",
      contactId: -1,
      contactData: {},
      userPhoto: 'http://localhost:8000'
    }),
    components: {
      ContactForm,
      ContactList
    },

    methods: {
      changeCurrentForm(tabValue) {
        this.currentForm = tabValue == 1 ? ContactList : ContactForm;
      },
      logout() {
        localStorage.setItem("userEmail", '');
        location.reload();
      },
      loadEditionForm(contact) {
        this.contactData = contact;
        this.isEdition = true;
        this.contactFormTitle = "Editar contato";
        document.getElementById("contactFormTab").click();
      },
      cancelEditionForm() {
        this.contactData = {};
        this.isEdition = false;
        this.contactFormTitle = "Criar contato";
        document.getElementById("contactFormTab").click();
      }
    },
    mounted() {
      const requestOptions = {
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
      };

      axios.post('http://localhost:8000/controller/UserController.class.php', this.params, requestOptions)
        .then(response => this.userPhoto += response.data[0].foto )
        .catch(error => console.log('Ocorreu um erro: ' + error) );
    },
    computed: {
      params() {
        let params = new FormData();
        params.append('_acao', 'carregar');
        params.append('userEmail', this.userEmail);

        return params;
      },
    }
  }
</script>



