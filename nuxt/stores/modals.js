export const useModalStore = defineStore('modal', {
    state: () => {
        return {
            loading: false,
            flash: {
                show: false,
                type: '',
                description: ''
            },
            newReview: false
        }
    },
    actions: {
        switchLoading() {
            this.loading = !this.loading
        },
        showFlashMessage(type, description) {
            this.flash = {
                show: true,
                type: type,
                description: description
            }
            setTimeout(() => {
                this.flash = {
                    show:false,
                    type: '',
                    description: ''
                }
            }, 2000)
        },
        switchReview() {
            this.newReview = !this.newReview
        }
    },
})