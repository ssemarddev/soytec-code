import Toast from "bootstrap/js/dist/toast"
import AlertConfig from "./AlertConfig"

export default {
    props: {
        /**
         * Configuración de la notificación
         */
        config: AlertConfig,
    },
    data() {
        return {
            toastMouseHover: false,
        }
    },
    mounted() {
        const toast = new Toast(this.$el, {
            delay: 2000,
        })
        toast.show()
        //Actualizar barra de progreso
        const progress = this.$el.querySelector(".toast-progress")
        let progressWidth = 100
        const interval = setInterval(() => {
            progress.style.width = `${progressWidth}%`
            if (progressWidth < 0) clearInterval(interval)
            if (!this.toastMouseHover) progressWidth--
        }, 20)
        //Detectar si el puntero se encuentra encima o fuera de la notificación
        this.$el.addEventListener("mouseover", () => {
            this.toastMouseHover = true
            progressWidth = 100
        })
        this.$el.addEventListener("mouseleave", () => {
            this.toastMouseHover = false
        })
    },
}
