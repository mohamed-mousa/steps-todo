<template>
<div class="container">
    <div class="form-signin text-center">
      <img src="@/assets/2.png" width="200" class="mb-0">
      <h1 class="h3 mb-3 text-white-gray fw-normal">Add new account</h1>

       <form>
        <div class="form-floating">
          <input type="text" :class="{'is-invalid' : error.name}"  v-model="name" name="name"  class="form-control d-color-bg" id="floatingName" placeholder="user name">
          <label  class="text-white-gray"  for="floatingName">User name</label>
           <div v-if="error.name" class="invalid-feedback">
            {{error.name[0]}}
          </div>
        </div>
         <div class="form-floating">
          <input type="email"  :class="{'is-invalid' : error.email}" v-model="email" name="email"  class="form-control d-color-bg" id="floatingEmail" placeholder="name@example.com">
          <label  class="text-white-gray"  for="floatingEmail">Email</label>
          <div v-if="error.email" class="invalid-feedback">
            {{error.email[0]}}
          </div>
        </div>
        <div class="form-floating mb-3">
         <input type="password" :class="{'is-invalid' : error.password}" v-model="password" name="password"  class="form-control d-color-bg" id="floatingPassword" placeholder="password">
          <label  class="text-white-gray"  for="floatingPassword">password</label>
          <div v-if="error.password" class="invalid-feedback">
            {{error.password[0]}}
          </div>
        </div>

        <div class="mb-3 text-white-gray">
            Hav account
          <router-link to="/login" class="m-color-text ">
             login
          </router-link>
        </div>

        <button class="w-100 btn btn-lg m-color-bg text-dark m-color-bg-hover"
          :class="{disabled : isLoading}"
          @click.prevent="perFormRegistre">
          Create
          <i v-if="isLoading" class="gg-spinner me-3"></i>

        </button>
      </form>

    </div>

</div>
</template>

<script>
  export default {
    data() {
      return {
        name:'',
        email:'',
        password:'',
        error: "",
        isLoading: false

      }
    },

    methods: {
      // perFormRegistre
      perFormRegistre () {
        this.isLoading = true
        this.$store.dispatch('perFormRegisterAction', {
          name: this.name,
          email: this.email,
          password: this.password
        })
        .then(() => {
          this.isLoading = false
          this.error = ''
          this.$router.push('/projects')
        })
        .catch((err) => {
          this.isLoading = false
          this.error = err.response.data.errors

        })
      }
    }
  }
</script>

<style scoped="Register.vue">
  .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-radius: 0;
    border-radius: 0;
  }
</style>