<template>
  <v-table>
    <thead>
      <tr>
        <th class="text-left">
          Nome
        </th>
        <th class="text-left">
          Ações
        </th>
      </tr>
    </thead>
    <tbody v-if="contacts.length > 0">
      <tr
        v-for="contact in contacts"
        :key="contact.idContato"
      >
        <td>
          <v-card
            class="mb-2"
            density="compact"
            prepend-avatar="https://randomuser.me/api/portraits/women/10.jpg"
            variant="text"
            :title="contact.nome"
          />
        </td>
        <td>
          <v-btn class="mr-2" @click="editContact(contact)">
            <v-icon
              icon="mdi-pencil"
              size="18"
            />
          </v-btn>

          <v-btn @click="deleteContact(contact.idContato)">
            <v-icon
              icon="mdi-delete"
              size="18"
            />
          </v-btn>
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
<script>
  import axios from 'axios'

  export default {
    data () {
      return {
        contacts: [],
        contactId: -1,
        requestOptions: {
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }
      }
    },
    methods: {
      getContacts() {
        axios.post('http://localhost:8000/controller/ContactController.class.php', this.getContactsParams, this.requestOptions)
        .then(response => this.contacts = response.data )
        .catch(error => console.log('Ocorreu um erro: ' + error) );
      },
      deleteContact(contactId) {
        console.log(contactId);
        this.contactId = contactId;
        axios.post('http://localhost:8000/controller/ContactController.class.php', this.deleteContactParams, this.requestOptions)
        .then(response => this.contacts = response.data )
        .catch(error => console.log('Ocorreu um erro: ' + error) );
        location.reload();
      },
      editContact(contact) {
        this.$emit('editContact', contact);
      }
    },
    computed: {
      getContactsParams() {
        let params = new FormData();
        params.append('_acao', 'listar');
        params.append('userId', 20);

        return params;
      },
      deleteContactParams() {
        let params = new FormData();
        params.append('_acao', 'deletar');
        params.append('contactId', this.contactId);

        return params;
      }
    },
    mounted() {
      this.getContacts();
    }
  }
</script>