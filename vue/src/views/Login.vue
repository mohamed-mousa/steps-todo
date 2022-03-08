<template>
  <div class="container">
    <main class="form-signin text-center">
      <form>
        <img src="@/assets/2.png" width="200" class="mb-0" />
        <h1 class="h3 mb-3 text-white-gray fw-normal">Please login</h1>
        <div v-if="error" class="alert alert-danger">
          {{ error }}
        </div>
        <div class="form-floating">
          <input
            type="email"
            v-model="email"
            name="email"
            :class="{ 'is-invalid': error }"
            class="form-control d-color-bg"
            id="floatingInput"
            placeholder="name@example.com"
          />
          <label class="text-white-gray" for="floatingInput">Email</label>
        </div>
        <div class="form-floating">
          <input
            type="password"
            v-model="password"
            name="password"
            :class="{ 'is-invalid': error }"
            class="form-control d-color-bg"
            id="floatingPassword"
            placeholder="password"
          />
          <label class="text-white-gray" for="floatingPassword">Password</label>
        </div>

        <div class="mb-3 text-white-gray">
          Not have account
          <router-link to="/register" class="m-color-text">
            Registre
          </router-link>
        </div>
        <button
          class="w-100 btn btn-lg m-color-bg m-color-bg-hover text-dark"
          :class="{ disabled: isLoading }"
          @click.prevent="perFormLogin"
        >
          Login
          <i class="gg-spinner ms-3" v-if="isLoading"></i>
        </button>
      </form>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      error: "",
      isLoading: false,
    };
  },
  methods: {
    // perFormLogin
    perFormLogin() {
      this.isLoading = true;
      this.$store
        .dispatch("perFormLoginAction", {
          email: this.email,
          password: this.password,
        })
        .then((res) => {
          this.isLoading = false;
          this.error = "";
          this.$router.push("/projects");
        })
        .catch((err) => {
          this.isLoading = false;
          this.error = err.response.data.error;
        });
    },
  },
};
</script>

<style></style>
