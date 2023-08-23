<template>
  <v-container class="fill-height">
    <v-responsive class="align-center text-center fill-height">
      <v-sheet width="300" height="500" class="mx-auto">
        <v-form @submit.prevent="submitContactForm">
          <v-text-field
            v-model="name"
            :rules="rules"
            label="Nome"
          />
          <v-text-field
            v-model="email"
            :rules="rules"
            label="E-mail"
            type="email"
          />
          <v-text-field
            v-model="phone"
            :rules="rules"
            label="Telefone"
          />
          <v-file-input
            ref="photoFileInput"
            @change="onChangeFileUpload()"
            label="Foto"
            show-size
          />
          <v-btn type="submit" block class="mt-2">Enviar</v-btn>
          <v-btn v-if="editingContact" block class="mt-2" @click="cancelContactEdition">Cancelar edição</v-btn>
        </v-form>
      </v-sheet>
    </v-responsive>
  </v-container>
</template>

<script>
  import axios from 'axios'

  export default {
    data: () => ({
      id: -1,
      userId: -1,
      name: '',
      email: '',
      phone: '',
      photo: [],
      rules: [ value => { return value ? true : 'Não é possível deixar campos vazios!' }, ],
      editingContact: false
    }),
    props: {
      isEdition: {
        type: Boolean,
        required: true
      },
      contactData: {
        type: Object,
        required: false
      }
    },
    methods: {
      onChangeFileUpload(){
        this.photo = this.$refs.photoFileInput.files[0];
      },
      submitContactForm() {
        const requestOptions = {
          headers: { 'Content-Type': 'multipart/form-data' }
        };

        if(this.editingContact) {
          console.log(this.editParams.get("photo"));

          axios.post('http://localhost:8000/controller/ContactController.class.php', this.editParams, requestOptions)
          .then(response => console.log(response.data) )
          .catch(error => console.log('Ocorreu um erro: ' + error) );
        } else {
          axios.post('http://localhost:8000/controller/ContactController.class.php', this.createParams, requestOptions)
          .then(response => console.log(response.data) )
          .catch(error => console.log('Ocorreu um erro: ' + error) );
        }

        // location.reload();
      },

      cancelContactEdition() {
        this.$emit('cancelEditionForm');

        this.editingContact = false;
        this.id = -1;
        this.userId = -1;
        this.name = '';
        this.email = '';
        this.phone = '';
        this.photo = [];
      }
    },
    computed: {
      createParams() {
        let params = new FormData();
        params.append('_acao', 'cadastrar');
        params.append('userEmail', localStorage.getItem("userEmail"));
        params.append('name', this.name);
        params.append('email', this.email);
        params.append('phone', this.phone);
        params.append('photo', this.photo);

        return params;
      },
      editParams() {
        let params = new FormData();
        params.append('_acao', 'editar');
        params.append('name', this.name);
        params.append('email', this.email);
        params.append('phone', this.phone);
        params.append('photo', this.photo);
        params.append('contactId', this.id);

        return params;
      },
    },
    mounted() {
      console.log(this.contactData.nome);

      this.editingContact = this.isEdition;

      if(this.editingContact == true) {
        this.id = this.contactData.idContato;
        this.userId = this.contactData.idUsuario;
        this.name = this.contactData.nome;
        this.email = this.contactData.email;
        this.phone = this.contactData.telefone;
        this.photo = this.contactData.foto;
      } else {
        this.id = -1;
        this.userId = '';
        this.name = '';
        this.email = '';
        this.phone = '';
        this.photo = '';
      }
    }
  }
</script>
