<template>
  <div class="">
    <div class="container mb-lg-0 mb-4 px-0">
      <div id="edit">
        <div class="d-color-bg px-lg-5 pt-lg-5 p-3 my-container">
          <h1 class="text-white-gray d-flex justify-content-between">
            <span class="align-self-center">
              Hi {{user.name}}
            </span>
            <div v-if="editModel" class="project-container text-center align-self-center" @click="addModelTrue">
              <svg width="30" style="opacity:1" height="30" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M11 14.5V16.5H13V14.5H15V12.5H13V10.5H11V12.5H9V14.5H11Z" fill="currentColor" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M4 1.5C2.89543 1.5 2 2.39543 2 3.5V4.5C2 4.55666 2.00236 4.61278 2.00698 4.66825C0.838141 5.07811 0 6.19118 0 7.5V19.5C0 21.1569 1.34315 22.5 3 22.5H21C22.6569 22.5 24 21.1569 24 19.5V7.5C24 5.84315 22.6569 4.5 21 4.5H11.874C11.4299 2.77477 9.86384 1.5 8 1.5H4ZM9.73244 4.5C9.38663 3.9022 8.74028 3.5 8 3.5H4V4.5H9.73244ZM3 6.5C2.44772 6.5 2 6.94772 2 7.5V19.5C2 20.0523 2.44772 20.5 3 20.5H21C21.5523 20.5 22 20.0523 22 19.5V7.5C22 6.94772 21.5523 6.5 21 6.5H3Z"
                  fill="currentColor" />

              </svg>
              <h6 class="text-capitalize">add project </h6>

            </div>
          </h1>
          <div class="mb-3">

            <label for="exampleFormControlInput1" class="form-label text-white-gray" v-if="addModel">Add new project</label>
            <div :class="{'border-danger': error}"
              class="input-group mb-3 dd-color-bg my-border border-2 p-1 rounded-3 overflow-hidden" v-if="addModel">
              <input type="text" v-model="project_name" name="project_name" class="form-control dd-color-bg border-0 text-white-gray"
                id="floatingInput" placeholder="Project name" @keydown.enter="perFormAddProject">
              <span class="input-group-text dd-color-bg border-0 py-0" id="basic-addon2">
                <div class="border-e border-s px-2">
                  <label class="text-white-gray mb-2">Color</label>
                  <input type="color" v-model="color" name="color" class="form-control form-control-color p-0 "
                    style="max-width:100%">

                </div>
              </span>
              <button type="button" class="btn  rounded-3 m-color-bg m-color-bg-hover" v-if="addModel"
                :class="{disabled : isLoading}" @click.prevent="perFormAddProject">
                <i class="gg-spinner me-2" v-if="isLoading"></i>
                Add
              </button>
            </div>

            <label for="exampleFormControlInput1" class="form-label" v-if="editModel">Edit project</label>
            <div :class="{'border-danger': error}"
              class="input-group mb-3 d-color-bg border border-2 p-1 rounded-3 overflow-hidden" v-if="editModel">
              <input type="text" v-model="project_name" @keydown.enter="perFormEditProject" name="project_name"
                class="form-control border-0 text-white-gray" id="floatingInput" placeholder="Project name">
              <span class="input-group-text d-color-bg border-0 py-0" id="basic-addon2">
                <div class="border-end border-start px-2">
                  <label class="text-white-gray mb-2"> Color</label>
                  <input type="color" v-model="color" name="color" class="form-control form-control-color p-0"
                    style="max-width:100%">

                </div>
              </span>
              <button type="button" class="btn  rounded-3 m-color-bg m-color-bg-hover" v-if="editModel"
                :class="{disabled : isLoading}" @click.prevent="perFormEditProject">
                <i class="gg-spinner me-2 " v-if="isLoading"></i>
                Edit
              </button>
            </div>
            <div v-if="error" class="invalid-feedback">
              {{error.project_name[0]}}
            </div>
          </div>
          <h6 class="text-white-gray" v-if="projects.length > 0">
            Your have ({{projects.length}}) projects
          </h6>

        </div>
        <div class="d-flex justify-content-center pt-5" v-if="!loading">
          <img src="@/assets/squares.svg" alt="loader" class="align-self-center">
        </div>

        <div v-if="loading">


          <div v-if="projects.length == 0" class="text-center pt-lg-5 mt-5 text-white-gray">
            <NotFound />
            <h6>You have no project</h6>

          </div>
          <div class="row mx-0">
            <div v-for="project in projects" :key="project.id" class=" col-lg-3 col-md-4 col-6  px-0 text-white-gray text-center">

              <div class="project-container py-3 rounded-3">
                <div class="card project text-white mb-3 mx-auto" :style="{backgroundColor:project.color}">

                  <router-link :to="`/project/tasks/${project.id}`" class="text-decoration-none text-white">
                    <div class="card-body pt-0">
                      <h2 class="card-title py-0 mb-0 text-uppercase" style="line-height:2.5">
                        {{project.project_name.substring(0,2)}}
                        </h2>
                    </div>
                  </router-link>

                </div>
                <router-link :to="`/project/tasks/${project.id}`" class="text-decoration-none m-color-text-hover text-white-gray">
                  <h5 class="text-capitalize">{{project.project_name}}</h5>
                </router-link>
                <div class="px-1 border-0 position-relative dropup">
                  <span id="statusDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"
                    class="pointer text-white">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M5 15C6.65685 15 8 13.6569 8 12C8 10.3431 6.65685 9 5 9C3.34315 9 2 10.3431 2 12C2 13.6569 3.34315 15 5 15ZM5 13C5.55228 13 6 12.5523 6 12C6 11.4477 5.55228 11 5 11C4.44772 11 4 11.4477 4 12C4 12.5523 4.44772 13 5 13Z"
                        fill="#b4b7bd" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15ZM12 13C12.5523 13 13 12.5523 13 12C13 11.4477 12.5523 11 12 11C11.4477 11 11 11.4477 11 12C11 12.5523 11.4477 13 12 13Z"
                        fill="#b4b7bd" />
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M22 12C22 13.6569 20.6569 15 19 15C17.3431 15 16 13.6569 16 12C16 10.3431 17.3431 9 19 9C20.6569 9 22 10.3431 22 12ZM20 12C20 12.5523 19.5523 13 19 13C18.4477 13 18 12.5523 18 12C18 11.4477 18.4477 11 19 11C19.5523 11 20 11.4477 20 12Z"
                        fill="#b4b7bd" />
                    </svg>
                  </span>
                  <ul class="dropdown-menu border-0 shadow py-0 rounded-3 dd-color-bg" aria-labelledby="statusDropdown">
                    <li><a href="#edit" class="text-white-gray m-color-text-hover rounded-3 dropdown-item pointer"
                        @click="editModelTrue(project)">Edit</a></li>
                    <li><span class="text-white-gray m-color-text-hover rounded-3 dropdown-item pointer"
                        @click="perFormDeleteProject(project.id)">Delete</span></li>

                  </ul>

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


    </div>

  </div>
</template>
<script>
  import axios from "axios";
  import NotFound from '@/components/NotFound.vue';
  import Swal from 'sweetalert2'
  window.Swal = Swal;
  const Toast1 = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    background: '#fff',
    showConfirmButton: false,
    timer: 3000,
    customClass: {
      title: 'title-class'
    }
  });
  window.Toast1 = Toast1;
  export default {
    components: {
      'NotFound': NotFound
    },
    computed: {
      // user
      user() {
        return this.$store.getters.get_user;
      }
    },
    data() {
      return {
        isLoading: false,
        addModel: true,
        editModel: false,
        loading: true,
        error: "",
        id: "",
        projects: [],
        project_name: '',
        color: '#ff9800',
      }
    },
    methods: {
      // addModelTrue
      addModelTrue() {
        this.addModel = true
        this.editModel = false
        this.project_name = ''
        this.error = ''
        this.color = '#ff9800'
      },
      // editModelTrue
      editModelTrue(project) {
        this.addModel = false
        this.editModel = true
        this.id = project.id
        this.project_name = project.project_name
        this.color = project.color
        this.error = ''
      },

      // getAllProjects
      getAllProjects() {
        this.loading = false
        axios.get(this.$store.state.apiUrl + "/api/auth/project", {
            headers: {
              Authorization: `Bearer ${this.$store.state.token}`
            }
          })
          .then((res) => {
            this.projects = res.data
            this.loading = true
          })
          .catch((err) => {
            this.error = err.response.data.errors
          })
      },

      // perFormAddProject
      perFormAddProject() {
        this.isLoading = true

        axios.post(this.$store.state.apiUrl + "/api/auth/project", {
            project_name: this.project_name,
            color: this.color,
            token: this.$store.state.token
          })
          .then((res) => {
            this.isLoading = false
            this.projects = [...this.projects, res.data]
            this.project_name = ''
            this.error = ''
            this.color = '#ff9800'
            Toast1.fire({
              type: 'success',
              icon: 'success',
              title: 'Project added '
            });
          })
          .catch((err) => {
            this.isLoading = false
            this.error = err.response.data.errors
          })
      },

      // perFormEditProject
      perFormEditProject() {
        this.isLoading = true
        axios.patch(this.$store.state.apiUrl + "/api/auth/project/" + this.id, {
            project_name: this.project_name,
            color: this.color,
            token: this.$store.state.token
          })
          .then(() => {
            this.isLoading = false
            this.error = ''
            this.project_name = ''
            this.color = '#ff9800'
            this.editModel = false
            this.addModel = true
            this.error = ''
            this.getAllProjects()
            Toast1.fire({
              type: 'success',
              icon: 'success',
              title: 'Project Edited '
            });
          })
          .catch((err) => {
            this.isLoading = false
            this.error = err.response.data.errors
          })
      },

      // perFormDeleteProject
      perFormDeleteProject(id) {
        Toast1.fire({
          title: 'Are you sure you want delete this project',
          position: 'center-center',
          icon: 'warning',
          timer: 5000,
          showConfirmButton: true,
          showCancelButton: true,
          confirmButtonColor: '#fdb813',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {

            axios.delete(this.$store.state.apiUrl + "/api/auth/project/" + id, {
                headers: {
                  Authorization: `Bearer ${this.$store.state.token}`
                }
              })

              .then(() => {
                this.projects = this.projects.filter((project) => project.id !== id)
                Toast1.fire({
                  type: 'success',
                  icon: 'success',
                  title: 'Project Deleted '
                })
              })
              .catch((err) => {
                this.error = err.response.data.errors
              })
          }
        })

      }

    },
    created() {
      this.getAllProjects()
    },
  }
</script>

<style scoped>
  .my-container {
    border-radius: 8px 8px  0 0 ;
  }

  .dropdown-menu {
    transform: translate(1px, -33px) !important;
  }

  .project-container:hover {
    border: 1px solid #7367f0;
    background-color: #283046;
  }

  .project-container {
    border-radius: 0 !important;
    border: 1px solid #3b4253;

  }
</style>