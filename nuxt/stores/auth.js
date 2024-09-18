import {useModalStore} from "~/stores/modals.js";
import {useCookie} from "#app";

export const useAuthStore = defineStore('auth', {
    state: () => {
        const config = useRuntimeConfig()
        return {
            auth: useCookie('isAuth'),
            user: useCookie('user'),
            errors: [],
            baseUrl: config.public.baseUrl
        }
    },
    getter: {
    },
    actions: {
        async getCsrfToken() {
            await $fetch(`${this.baseUrl}/sanctum/csrf-cookie`, {
                credentials: 'include',
            })
        },

        async register(data) {
            await this.getCsrfToken()
            useModalStore().switchLoading()
            try {
                const user = await $fetch(`${this.baseUrl}/register`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value
                    },
                    body: data
                })
                console.log(user)
                useCookie('isAuth', {maxAge: 60 * 60 * 2}).value = 'true'
                useCookie('user', {maxAge: 60 * 60 * 2}).value = JSON.stringify(user)
                window.location.href = '/'
            } catch (errors) {
                this.errors = errors.response._data.errors
            } finally {
                useModalStore().switchLoading()
            }
        },

        async login(data) {
            await this.getCsrfToken()
            useModalStore().switchLoading()
            try {
                const user = await $fetch(`${this.baseUrl}/login`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value
                    },
                    body: data
                })
                useCookie('isAuth', {maxAge: 60 * 60 * 2}).value = 'true'
                useCookie('user', {maxAge: 60 * 60 * 2}).value = JSON.stringify(user)
                window.location.href = '/'
            } catch (errors) {
                this.errors = errors.response._data.errors
            } finally {
                useModalStore().switchLoading()
            }
        },

        async logout(data) {
            await this.getCsrfToken()
            useModalStore().switchLoading()
            try {
                await $fetch(`${this.baseUrl}/logout`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value
                    },
                    body: data
                })
                useCookie('isAuth').value = 'false'
                useCookie('user').value = ''
                window.location.href = '/'
            } catch (errors) {
                this.errors = errors.response._data.errors
            } finally {
                useModalStore().switchLoading()
            }
        }
    },
})