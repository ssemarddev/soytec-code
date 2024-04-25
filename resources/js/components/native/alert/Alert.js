"use strict"
import { createApp } from "vue"
import Root from "./Root.vue"
import AlertConfig from "./AlertConfig.js"

/**
 * @class Maneja las notificaciones del sistema. Muestra información en una notificación emergente en la pantalla.
 */
export default class Alert {
    /**
     * @constructor
     * @param {AlertConfig} config
     */
    constructor(config) {
        Root.mixins = [
            {
                data() {
                    return {
                        config: config,
                    }
                },
            },
        ]
        this.create()
    }

    /**
     * Crea una aplicación Vue para mostrar la notificación con la configuración definida
     * y las personalizaciones pasadas en el constructor de la clase
     */
    create() {
        this.app = createApp(Root)
    }

    /**
     * Muestra la notificación en pantalla
     */
    fire() {
        this.app.mount("#alerts")
    }
}
