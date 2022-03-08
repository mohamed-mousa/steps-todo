import { createStore } from "vuex";
import axios from "axios";
import VuexPersistence from 'vuex-persist'

export default createStore({
	// state
	state: {
		loggedIn: false,
		user: null,
		token: null,
		apiUrl: 'https://steps-api.herokuapp.com',
	},

	// VuexPersistence plugin
	plugins: [new VuexPersistence().plugin],

	// mutations
	mutations: {
		SET_token (state, payload) {
			state.token = payload
		},
		SET_user (state, payload) {
			state.user = payload
		},
		SET_loggedIn (state, payload) {
			state.loggedIn = payload
		},
		SET_project (state, payload) {
			state.project = payload
		},
	},

	// actions
	actions: {

		// perFormLoginAction
		perFormLoginAction ({ commit, state }, payload) {
			return new Promise((resolve, reject) => {
				axios.post(state.apiUrl + "/api/auth/login", {
					email: payload.email,
					password: payload.password
				})
					.then((res) => {
						commit('SET_token', res.data.access_token)
						commit('SET_user', res.data.user)
						commit('SET_loggedIn', true)
						resolve(res)
					})
					.catch((err) => {
						reject(err)
					})
			})
		},

		// perFormRegisterAction
		perFormRegisterAction ({ commit, state }, payload) {
			return new Promise((resolve, reject) => {
				axios.post(state.apiUrl + "/api/auth/register", {
					name: payload.name,
					email: payload.email,
					password: payload.password
				})
					.then((res) => {
						commit('SET_token', res.data.access_token)
						commit('SET_user', res.data.user)
						commit('SET_loggedIn', true)
						resolve(res)
					})
					.catch((err) => {
						reject(err)
					})
			})
		},

		// perFormLogoutAction
		perFormLogoutAction ({ commit, state }) {

			return new Promise((resolve, reject) => {
				axios.post(state.apiUrl + "/api/auth/logout", {
					token: state.token
				})
					.then((res) => {
						commit('SET_token', null)
						commit('SET_user', null)
						commit('SET_loggedIn', false)
						resolve(res)
						this.$router.push('/')
					})
					.catch((err) => {
						reject(err)
						commit('SET_token', null)
						commit('SET_user', null)
						commit('SET_loggedIn', false)
					})
			})
		},

		// perFormUpdateAction
		perFormUpdateAction ({ commit, state }, payload) {
			return new Promise((resolve, reject) => {
				axios.patch(state.apiUrl + "/api/auth/update", {
					name: payload.name,
					email: payload.email,
					password: payload.password,
					token: state.token
				})
					.then((res) => {
						commit("SET_user", res.data.user);
						resolve(res)
					})
					.catch((err) => {
						reject(err);
					})

			})
		},

		// perFormSingleProjectAction
		perFormSingleProjectAction ({ commit, state }, payload) {
			return new Promise((resolve, reject) => {
				axios.get(state.apiUrl + "/api/auth/project/" + payload.project.id, {
					headers: { Authorization: `Bearer ${state.token}` },
				})
					.then((res) => {
						commit('SET_project', payload.project)
						commit('SET_task', res.data)
						resolve(res)
					})
					.catch((err) => {
						reject(err)
					})
			})
		},

	},

	// getters
	getters: {
		get_loggedIn (state) {
			return state.loggedIn
		},
		get_user (state) {
			return state.user
		},
		get_project (state) {
			return state.project
		},
		get_task (state) {
			return state.task
		}
	},
	modules: {},
});
