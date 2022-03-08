<template>
  <div id="nav">
    <nav class="navbar navbar-expand-md navbar-light d-color-bg">
      <div class="container-fluid">
        <router-link
          class="navbar-brand text-white me-lg-3 text-capitalize"
          to="/"
        >
          <img src="@/assets/logo.png" alt="logo" width="30" />
          <span v-if="user"> {{ user.name }}</span>
        </router-link>

        <div class="ms-auto">
          <span class="" v-if="!loggedIn">
            <router-link
              class="mx-1 btn btn-sm btn-light m-color-bg-hover"
              to="/login"
              >login</router-link
            >
          </span>
          <span class="" v-if="!loggedIn">
            <router-link
              class="mx-1 btn btn-sm m-color-bg text-dark m-color-bg-hover"
              to="/register"
              >Registre</router-link
            >
          </span>
          <span class="" v-if="loggedIn">
            <span
              class="mx-1 btn btn-sm m-color-bg text-dark m-color-bg-hover"
              @click.prevent="perFormLogout"
            >
              Logout
            </span>
          </span>
          <span class="" v-if="loggedIn">
            <router-link
              to="/profile"
              class="mx-1 btn btn-sm bg-white m-color-bg-hover"
            >
              Profile
            </router-link>
          </span>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      token: null,
    };
  },
  computed: {
    // loggedIn
    loggedIn() {
      return this.$store.getters.get_loggedIn;
    },
    // user
    user() {
      return this.$store.getters.get_user;
    },
  },
  methods: {
    // checkUserStatus
    checkUserStatus() {
      if (localStorage.getItem("token")) {
        this.token = localStorage.getItem("token");
      }
    },

    // perFormLogout
    perFormLogout() {
      this.$store
        .dispatch("perFormLogoutAction")
        .then(() => {
          this.$router.push("/");
        })
        .catch((err) => {
          this.error = err.message;
        });
    },
  },
  mounted() {
    this.checkUserStatus();
  },
};
</script>
