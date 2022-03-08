<template>
  <div class="container">

    <div class="d-flex justify-content-center pt-2" v-if="!loading">
      <img src="@/assets/squares.svg" alt="loader" class="align-self-center">
    </div>
    <p v-if="loading" class="text-center">
      <router-link to="/projects" class="m-color-text m-color-text-hover text-decoration-none">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M20.3284 11.0001V13.0001L7.50011 13.0001L10.7426 16.2426L9.32842 17.6568L3.67157 12L9.32842 6.34314L10.7426 7.75735L7.49988 11.0001L20.3284 11.0001Z"
            fill="currentColor" />
        </svg>
        All projects
      </router-link>
    </p>
    <div class="p-lg-5 p-2" v-if="loading">
      <div class="project-container mb-4">
        <div class="card project text-white  mb-3 mx-auto" :style="{backgroundColor:project.color}">

          <div class="card-body pt-0 d-flex align-items-center justify-content-center">
            <div class="align-self-center text-center">
              <h3 class="card-title text-center text-uppercase mt-3 mb-1">
                {{project.project_name[0]}}
                {{project.project_name[1]}}
              </h3>
              <span v-if="tasks.length">{{tasks.length}} Tasks</span>

            </div>
          </div>

        </div>
        <h4 class="text-capitalize fw-bold text-white-gray text-center">{{project.project_name}}</h4>

      </div>


      <div class="row justify-content-center">
        <div class="col-lg-6">

          <div class="input-group input-group-lg mb-3 p-1 rounded-pill">
            <div v-if="error" class="invalid-feedback">
              {{error.task_name[0]}}
            </div>
            <input :class="{'is-invalid': error}" v-model="task_name" @keypress.enter="perFormAddTask" type="text"
              class="form-control d-color-bg rounded-pill" placeholder="Add new task">
            <span class="input-group-text border-0 bg-transparent pe-0" v-if="isLoading">
              <i class="gg-spinner"></i>
            </span>
          </div>
        </div>
        <div class="col-12"></div>
        <!-- tasks -->
        <div class="col-lg-6">
          <ol class="list-group list-group-numbered">
            <li
              class="list-group-item d-flex border-0 task-hover d-color-bg position-relative mb-3 justify-content-between align-items-start"
              v-for="task in tasks" :key="task.id">

              <div :class="{'border-danger': editerror}" class="form-floating edit-input d-color-bg display-none" :id="task.id">
                <input type="text" class="form-control border-0 bg-transparent" @keypress.enter="perFormEditTask(task.id)"
                  v-model="task_name_on_edit" placeholder="Edit task">
                <label for="floatingInput" v-if="!editerror" class="text-white-gray">Edit task</label>
                <label for="floatingInput" v-if="editerror" class="invalid-feedback">{{editerror.task_name[0]}}</label>

                <span v-if="!isEditLoading" @click="clseEdit" class="position-absolute top-50  translate-middle-y"
                  style="right:15px">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M6.2253 4.81108C5.83477 4.42056 5.20161 4.42056 4.81108 4.81108C4.42056 5.20161 4.42056 5.83477 4.81108 6.2253L10.5858 12L4.81114 17.7747C4.42062 18.1652 4.42062 18.7984 4.81114 19.1889C5.20167 19.5794 5.83483 19.5794 6.22535 19.1889L12 13.4142L17.7747 19.1889C18.1652 19.5794 18.7984 19.5794 19.1889 19.1889C19.5794 18.7984 19.5794 18.1652 19.1889 17.7747L13.4142 12L19.189 6.2253C19.5795 5.83477 19.5795 5.20161 19.189 4.81108C18.7985 4.42056 18.1653 4.42056 17.7748 4.81108L12 10.5858L6.2253 4.81108Z"
                      fill="#b4b7bd" />
                  </svg>
                </span>

                <span v-if="isEditLoading" @click="clseEdit" class="position-absolute top-50  translate-middle-y"
                  style="right:15px">
                  <i class="gg-spinner"></i>
                </span>
              </div>
              <div class="ms-2 me-auto align-self-center dropup dropdown">
                <div class=" mb-1 ">
                  <span class="fw-bold text-white-gray" :class="{'text-decoration-line-through': task.rejected}">
                    {{task.task_name}}

                  </span>

                </div>
                <span id="statusDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"
                  class="px-3 pt-1 pb-2 dropdown-toggle btn-inverse-secondary rounded-pill pointer"
                  v-if="task.waiting"><img src="@/assets/waiting.gif" alt="waiting">
                  waiting
                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M6.34317 7.75732L4.92896 9.17154L12 16.2426L19.0711 9.17157L17.6569 7.75735L12 13.4142L6.34317 7.75732Z"
                      fill="currentColor" />
                  </svg>
                </span>
                <span id="statusDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"
                  class="px-3 pt-1 pb-2 dropdown-toggle btn-inverse-success rounded-pill pointer"
                  v-if="task.completed"><img src="@/assets/completed.gif" alt="completed">
                  completed
                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M6.34317 7.75732L4.92896 9.17154L12 16.2426L19.0711 9.17157L17.6569 7.75735L12 13.4142L6.34317 7.75732Z"
                      fill="currentColor" />
                  </svg>
                </span>
                <span id="statusDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"
                  class="px-3 pt-1 pb-2 dropdown-toggle btn-inverse-danger rounded-pill pointer"
                  v-if="task.rejected"><img src="@/assets/rejected.gif" alt="rejected">
                  rejected
                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M6.34317 7.75732L4.92896 9.17154L12 16.2426L19.0711 9.17157L17.6569 7.75735L12 13.4142L6.34317 7.75732Z"
                      fill="currentColor" />
                  </svg>
                </span>
                <span id="statusDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false"
                  class="px-3 pt-1 pb-2 dropdown-toggle btn-inverse-primary rounded-pill pointer"
                  v-if="task.inprogress"><img src="@/assets/inprogress.gif" alt="inprogress">
                  inprogress
                  <svg width="17" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M6.34317 7.75732L4.92896 9.17154L12 16.2426L19.0711 9.17157L17.6569 7.75735L12 13.4142L6.34317 7.75732Z"
                      fill="currentColor" />
                  </svg>
                </span>
                <ul class="dropdown-menu border-0 shadow py-0 rounded-3 m-color-bg" aria-labelledby="statusDropdown">
                  <li><span class="text-white-gray m-color-text-hover rounded-3 dropdown-item pointer" v-if="!task.waiting"
                      @click="editStatus(task, 'waiting')">waiting</span></li>
                  <li><span class="text-white-gray m-color-text-hover rounded-3 dropdown-item pointer" v-if="!task.completed"
                      @click="editStatus(task, 'completed')">completed</span></li>
                  <li><span class="text-white-gray m-color-text-hover rounded-3 dropdown-item pointer" v-if="!task.rejected"
                      @click="editStatus(task, 'rejected')">rejected</span></li>
                  <li><span class="text-white-gray m-color-text-hover rounded-3 dropdown-item pointer" v-if="!task.inprogress"
                      @click="editStatus(task, 'inprogress')">inprogress</span></li>
                </ul>


              </div>
              <div>

                <div class="align-self-center me-1">
                  <div class="text-center mb-2" :class="{'text-decoration-line-through': task.rejected}">
                    <small class="text-white-gray">{{myDate(task.created_at)}}</small></div>
                  <svg @click="toggleEditInput(task)" class="rounded-circle  m-color-bg-hover p-1 me-1" width="27"
                    height="27" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M21.2635 2.29289C20.873 1.90237 20.2398 1.90237 19.8493 2.29289L18.9769 3.16525C17.8618 2.63254 16.4857 2.82801 15.5621 3.75165L4.95549 14.3582L10.6123 20.0151L21.2189 9.4085C22.1426 8.48486 22.338 7.1088 21.8053 5.99367L22.6777 5.12132C23.0682 4.7308 23.0682 4.09763 22.6777 3.70711L21.2635 2.29289ZM16.9955 10.8035L10.6123 17.1867L7.78392 14.3582L14.1671 7.9751L16.9955 10.8035ZM18.8138 8.98525L19.8047 7.99429C20.1953 7.60376 20.1953 6.9706 19.8047 6.58007L18.3905 5.16586C18 4.77534 17.3668 4.77534 16.9763 5.16586L15.9853 6.15683L18.8138 8.98525Z" />
                    <path d="M2 22.9502L4.12171 15.1717L9.77817 20.8289L2 22.9502Z" />
                  </svg>

                  <svg @click="perFormDeleteTask(task.id)" class="rounded-circle  m-color-bg-hover p-1  me-1" width="27"
                    height="27" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" />
                    <path d="M9 9H11V17H9V9Z" />
                    <path d="M13 9H15V17H13V9Z" />
                  </svg>

                  <span class="d-inline-block text-white project-color rounded-circle"
                    :style="{backgroundColor:project.color}"></span>
                </div>

              </div>

            </li>

          </ol>
        </div>
      </div>
      <div v-if="tasks.length == 0" class="text-center pt-lg-4 mb-4 text-dark">
        <NotFound />
        <h6>You have no task in this project</h6>
      </div>
    </div>

  </div>

</template>

<script>
  import axios from "axios";
  import moment from 'moment'
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
    data() {
      return {
        isLoading: false,
        isEditLoading: false,
        showInput: false,
        tasks: [],
        project: '',
        error: '',
        editerror: '',
        loading: true,
        task_name: '',
        task_name_on_edit: ''
      }
    },
    created() {
      this.perFormGetTasks()
    },
    methods: {
      // myDate
      myDate(date) {
        return moment(date).format('l')
      },
      // getOnlyTask
      getOnlyTask() {
        axios.get(this.$store.state.apiUrl + "/api/auth/project/" + this.$route.params.id, {
            headers: {
              Authorization: `Bearer ${this.$store.state.token}`
            }
          })
          .then((res) => {
            this.tasks = res.data[1]
          })
      },

      // perFormEditTask
      perFormEditTask(id) {
        this.isEditLoading = true
        axios.patch(this.$store.state.apiUrl + "/api/auth/task/" + id, {
            task_name: this.task_name_on_edit,
            token: this.$store.state.token
          })
          .then(() => {
            this.task_name_on_edit = ''
            this.getOnlyTask()
            this.clseEdit()
            this.isEditLoading = false
            this.editerror = ''
            Toast1.fire({
              type: 'success',
              icon: 'success',
              title: 'Task edited '
            });
          })
          .catch((err) => {
            this.isEditLoading = false
            this.editerror = err.response.data.errors
          })
      },

      // clseEdit
      clseEdit() {
        var input = document.getElementsByClassName('edit-input')
        input.forEach(myFunction);

        function myFunction(item) {
          item.style.display = "none";
        }
        this.task_name_on_edit = ''
        this.editerror = false
      },
      toggleEditInput(task) {
        this.clseEdit()
        var input = document.getElementById(task.id)
        if (input.id == task.id) {
          input.style.display = "block";
          this.task_name_on_edit = task.task_name

        }
      },
      // editStatus
      editStatus(task, status) {
        console.log(status)
        axios.patch(this.$store.state.apiUrl + "/api/auth/task/" + status + "/" + task.id, {
            token: this.$store.state.token
          })
          .then(() => {
            this.getOnlyTask()
          })
          .catch((err) => {
            this.error = err.message
          })
        Toast1.fire({
          type: 'success',
          icon: 'success',
          title: 'task is ' + status
        });

      },
      // perFormEditProject
      perFormGetTasks() {
        this.loading = false
        axios.get(this.$store.state.apiUrl + "/api/auth/project/" + this.$route.params.id, {
            headers: {
              Authorization: `Bearer ${this.$store.state.token}`
            }
          })
          .then((res) => {
            this.tasks = res.data[1]
            this.project = res.data[0]
            this.error = ''
            this.loading = true
          })
          .catch((err) => {
            this.error = err.message
          })
      },

      // perFormAddProject
      perFormAddTask() {
        this.isLoading = true

        axios.post(this.$store.state.apiUrl + "/api/auth/task", {
            task_name: this.task_name,
            project_id: this.project.id,
            token: this.$store.state.token
          })
          .then((res) => {
            this.isLoading = false
            this.tasks = [...this.tasks, res.data]
            this.task_name = ''
            this.error = ''
            Toast1.fire({
              type: 'success',
              icon: 'success',
              title: 'Task added '
            });
          })
          .catch((err) => {
            this.isLoading = false
            this.error = err.response.data.errors
          })
      },

      // perFormDeleteProject
      perFormDeleteTask(id) {
        Toast1.fire({
          title: 'Are you sure you want delete this Task',
          position: 'center-center',
          icon: 'warning',
          timer: 500000,
          showConfirmButton: true,
          showCancelButton: true,
          confirmButtonColor: '#fdb813',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {

            axios.delete(this.$store.state.apiUrl + "/api/auth/task/" + id, {
                headers: {
                  Authorization: `Bearer ${this.$store.state.token}`
                }
              })

              .then(() => {
                this.tasks = this.tasks.filter((task) => task.id !== id)
                Toast1.fire({
                  type: 'success',
                  icon: 'success',
                  title: 'Task Deleted '
                })
              })
              .catch((err) => {
                this.error = err.response.data.errors
              })
          }
        })


      }
    },
  }
</script>

<style scoped>
  .gg-spinner,
  .gg-spinner::after,
  .gg-spinner::before {
    top: 0;
    left: 0;
    width: 30px;
    height: 30px
  }

  input:focus {
    box-shadow: none !important;
  }

  .gg-spinner::before {
    animation: spinner 1s cubic-bezier(.6, 0, .4, 1) infinite;
    border: 3px solid transparent;
    border-top-color: #643fdb;
  }

  .project-color {
    width: 10px;
    height: 10px;
  }

  svg {
    fill: #b4b7bd;
  }

  svg:hover {
    fill: #7367f0 !important;
  }

  .bg-light {
    background-color: #f1f1f1 !important;
  }

  .edit-input input {
    border-radius: 15px !important;

  }

  .task-hover {
    transition: .3s;
    border-radius: 15px !important;
  }

  .task-hover:hover {
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    transform: scale(1.02);
  }


  .dropdown-toggle::after {
    display: none;
  }

  .edit-input {
    display: none;
    position: absolute;
    top: 0;
    width: 100%;
    left: 0;
    bottom: 0;
    border: 3px solid #643fdb;
    border-radius: 15px !important;
    z-index: 2;
  }
  .list-group-numbered>li::before {
   color: #b4b7bd;
}
input::placeholder {
  color: #b4b7bd;
}
.title-class {
    color: #b4b7bd;
}
.swal2-popup.swal2-toast {
  background-color: #283046 !important;
}
</style>swal2-title