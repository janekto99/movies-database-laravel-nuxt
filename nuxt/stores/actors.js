export const useActorStore = defineStore('actors', {
    state: () => {
        const config = useRuntimeConfig()
        return {
            actors: [],
            baseUrl: config.public.baseUrl,
        }
    },
    actions: {
        async getActors(page = 1) {
            try {
                this.actors = await $fetch(`${this.baseUrl}/actors?page=${page}`)
            } catch {

            }
        },
        async getActorById(id) {
            try {
                return this.actor = await $fetch(`${this.baseUrl}/actors/${id}`)
            } catch {

            }
        },
    },
})