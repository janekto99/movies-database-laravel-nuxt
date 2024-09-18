export const useMovieStore = defineStore('movies', {
    state: () => {
        const config = useRuntimeConfig()
        return {
            movies: [],
            setFilters: {
                year: null,
                genre: null,
                country: null,
                errors: [],
            },
            baseUrl: config.public.baseUrl,
        }
    },
    getters: {

    },
    actions: {
        async getMovies(page = 1) {
            useModalStore().switchLoading()
            try {
                const query = new URLSearchParams({
                    page: page,
                })

                if (this.setFilters.year) query.append('year', this.setFilters.year)
                if (this.setFilters.genre) query.append('genre', this.setFilters.genre)
                if (this.setFilters.country) query.append('country', this.setFilters.country)

                this.movies = await $fetch(`${this.baseUrl}/movies?${query}`)
            } catch {

            } finally {
                useModalStore().switchLoading()
            }
        },
        async getMovieById(id) {
            try {
                return await $fetch(`${this.baseUrl}/movies/${id}`)
            } catch {

            }
        },

        async getFilters()  {
            try {
                return await $fetch(`${this.baseUrl}/movies/filters`)
            } catch {

            }
        },
    },
})