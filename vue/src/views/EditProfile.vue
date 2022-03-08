<template>
	<div class="container">
		<div class="">
			<div class="row justify-content-center  py-4">

				<div class="col-md-10 col-lg-5">
					<div class="p-4 p-md-5 rounded-3 d-color-bg">
						<div class="mb-3 text-white-gray text-center">
							<h1 class="mb-1">
								Hi {{user.name}}
							</h1>
							<p class="mb-4">
								{{user.email}}
							</p>
							<h6 class="mb-4">
								<router-link to="/projects"
									class=" p-2 m-color-bg text-dark  text-decoration-none rounded-3 me-2 mb-3">
									Projects <span class=" dd-color-bg text-white-gray rounded-3 px-2 ms-1 py-1">
										{{projects_task_count[0]}}</span>
								</router-link>
								<router-link to="/projects" class=" p-2 m-color-bg text-dark  text-decoration-none rounded-3">
									Tasks <span class=" dd-color-bg text-white-gray rounded-3 px-2 ms-1 py-1"> {{projects_task_count[1]}}</span>
								</router-link>
							</h6>

							<div class="d-grid gap-2">
								<button @click.prevent="perFormLogout" class="btn m-color-text-hover btn-inverse-secondary">Logout</button>
								<button class="btn m-color-text-hover btn-inverse-secondary" type="button" data-bs-toggle="collapse"
									data-bs-target="#multiCollapseExample2" aria-expanded="false"
									aria-controls="multiCollapseExample2">Edit profile</button>
								<button @click="perFormDeleteAccount()" class="btn m-color-text-hover btn-inverse-danger">
									<svg class="" width="20" height="20" viewBox="0 0 24 24" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path fill="#ee5b5b" fill-rule="evenodd" clip-rule="evenodd"
											d="M17 5V4C17 2.89543 16.1046 2 15 2H9C7.89543 2 7 2.89543 7 4V5H4C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H5V18C5 19.6569 6.34315 21 8 21H16C17.6569 21 19 19.6569 19 18V7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H17ZM15 4H9V5H15V4ZM17 7H7V18C7 18.5523 7.44772 19 8 19H16C16.5523 19 17 18.5523 17 18V7Z" />
										<path fill="#ee5b5b" d="M9 9H11V17H9V9Z" />
										<path fill="#ee5b5b" d="M13 9H15V17H13V9Z" />
									</svg>
									Delete this account
								</button>

							</div>
						</div>

						<div class="row">

							<div class="col">
								<div class="collapse multi-collapse" id="multiCollapseExample2">
									<div class="card dd-color-bg card-body">
										<form class="">
											<h1 class="h5 mb-3 fw-normal text-white-gray">Edit profile</h1>

											<div class="form-floating mb-3">
												<input type="text" v-model="user.name" name="name" class="form-control d-color-bg" id="floatingName"
													placeholder="Name">
												<label class="text-white-gray" for="floatingName">Name</label>
												<div v-if="error" class="invalid-feedback">
													{{error.name[0]}}
												</div>
											</div>
											<div class="form-floating mb-3">
												<input type="email" v-model="user.email" name="email" class="form-control d-color-bg" id="floatingEmail"
													placeholder="name@example.com">
												<label class="text-white-gray" for="floatingEmail">Email address</label>
												<div v-if="error" class="invalid-feedback">
													{{error.email[0]}}
												</div>
											</div>
											<div class="form-floating">
												<input type="password" v-model="password" name="password" class="form-control d-color-bg"
													id="floatingPassword" placeholder="password">
												<label class="text-white-gray" for="floatingPassword">password</label>
												<div v-if="error" class="invalid-feedback">
													{{error.password[0]}}
												</div>
											</div>
											<small class="text-white-gray">* Keep empty if not chang *</small>

											<button class="w-100 btn text-dark mt-3 btn-lg m-color-bg m-color-bg-hover" @click.prevent="updateProfile"
												:class="{disabled : isLoading}">
												<i v-if="isLoading" class="gg-spinner"></i>
												update
											</button>

										</form>
									</div>
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
		data() {
			return {
				error: '',
				isLoading: false,
				password: '',
				projects_task_count: [],
			}
		},
		computed: {
			user() {
				return this.$store.getters.get_user;
			}
		},
		methods: {
			// perFormDeleteProject
			perFormDeleteAccount() {
				Toast1.fire({
					title: 'Are you sure you want delete your account',
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

						axios.delete(this.$store.state.apiUrl + "/api/auth/destroy", {
								headers: {
									Authorization: `Bearer ${this.$store.state.token}`
								}
							})

							.then(() => {
								this.$store.commit('SET_token', null)
								this.$store.commit('SET_user', null)
								this.$store.commit('SET_loggedIn', false)
								this.$router.push('/')
								Toast1.fire({
									type: 'success',
									icon: 'success',
									title: 'Account Deleted '
								})
							})
							.catch(() => {})
					}
				})



			},

			// perFormLogout
			perFormLogout() {
				this.$store.dispatch('perFormLogoutAction')
					.then(() => {
						this.$router.push('/')
					})
					.catch((err) => {
						this.error = err.message
					})
			},

			// getProjectsTaskCount
			getProjectsTaskCount() {
				axios.get(this.$store.state.apiUrl + "/api/auth/projects_task_count", {
						headers: {
							Authorization: `Bearer ${this.$store.state.token}`
						}
					})
					.then((res) => {
						this.projects_task_count = res.data
					})
					.catch(() => {})
			},

			// updateProfile
			updateProfile() {
				this.isLoading = true
				this.$store.dispatch("perFormUpdateAction", {
						name: this.user.name,
						password: this.password,
						email: this.user.email
					})
					.then((res) => {
						this.isLoading = false
						this.error = ''
						Toast1.fire({
							type: 'success',
							icon: 'success',
							title: 'Profile updated '
						});
					})
					.catch((err) => {
						this.isLoading = false
						this.error = err.response.data.errors
					})
			}
		},
		mounted() {
			this.getProjectsTaskCount()
		}
	}
</script>
