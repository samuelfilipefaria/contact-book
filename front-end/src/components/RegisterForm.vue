<template>
  <v-container class="fill-height">
    <v-responsive class="align-center text-center fill-height">
      <v-sheet width="300" height="400" class="mx-auto">
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
          <v-file-input
            ref="photoFileInput"
            @change="onChangeFileUpload()"
            label="Foto"
            show-size
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
      photo: [],
      rules: [ value => { return value ? true : 'Não é possível deixar campos vazios!' }, ],
    }),
    methods: {
      onChangeFileUpload(){
        this.photo = this.$refs.photoFileInput.files[0];
      },
      submitUserForm() {
        const requestOptions = {
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        };

        axios.post('http://localhost:8000/controller/UserController.class.php', this.prepareFormData, requestOptions)
        .then(response => this.setLoginStatus(response.data) )
        .catch(error => console.log('Ocorreu um erro: ' + error) );
      },

      setLoginStatus(apiResponse) {
        console.log(apiResponse);
        const loginStatus = apiResponse.status_code == 1 ? true : false;
        if(loginStatus) {
          localStorage.setItem("userName", apiResponse.user_data);
          location.reload();
        } else {
          localStorage.setItem("userName", false);
        }
      }
    },
    computed: {
      prepareFormData() {
        let params = new URLSearchParams();
        params.append('_acao', 'cadastrar');
        params.append('name', this.name);
        params.append('email', this.email);
        params.append('password', this.password);
        params.append('photo', this.photo);

        return params;
      }
    }
  }
</script>
