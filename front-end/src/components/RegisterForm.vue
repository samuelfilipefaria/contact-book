<template>
  <v-container class="fill-height">
    <v-responsive class="align-center text-center fill-height">
      <v-sheet width="300" class="mx-auto">
        <v-form @submit.prevent="submitUserForm">
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
            v-model="password"
            :rules="rules"
            label="Senha"
            type="password"
          />
          <v-btn type="submit" block class="mt-2">Cadastrar</v-btn>
        </v-form>
      </v-sheet>
    </v-responsive>
  </v-container>
</template>

<script>
  import axios from 'axios'

  export default {
    data: () => ({
      name: '',
      email: '',
      password: '',
      photo: '',
      rules: [ value => { return value ? true : 'Não é possível deixar campos vazios!' }, ],
    }),
    methods: {
      submitUserForm() {
        const requestOptions = {
          headers: { 'Content-Type': 'multipart/form-data' },
        };

        axios.post('http://localhost:8000/api.php', this.prepareFormData, requestOptions)
        .then(response => console.log(response.data) )
        .catch(error => console.log('Ocorreu um erro: ' + error) );
      },

      prepareFormData() {
        let formData = new FormData();
        formData.append('name', this.name);
        formData.append('email', this.email);
        formData.append('password', this.password);
        formData.append('photo', this.photo);

        return formData;
      }
    }
  }
</script>
