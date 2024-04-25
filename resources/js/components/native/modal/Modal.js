"use strict"
import { createApp } from "vue"
import Root from "./Root.vue"
import ModalButton from "./ModalButton"

/**
 * @class Maneja los ventanas tipo "Modal" del sistema
 */
export default class Modal {
    /**
     * Instancia un nuevo modal a partir de la configuración pasada y se pasan todos los parámetros extras al data de la instancia de Vue
     * @param {Object} config Configuración del modal
     * - @prop {ModalButton} cancel Configuración del botón de cancelar
     * - @prop {ModalButton} accept Configuración del botón de aceptar
     * - @prop {ModalButton} close Configuración del botón de cerrar
     * - @prop {String} window Texto a mostrar en el título de la ventana del modal
     * - @prop {String} title Texto a mostrar en el texto principal del modal
     * - @prop {String} background Color de fondo del encabezado del modal
     * - @prop {String} icon Ícono a mostrar en el encabezado del modal
     * - @prop {String} description Texto a mostrar como texto secundario del modal
     * - @prop {Array<ModalInput>} inputs Entradas de formularios a mostrar en el modal para interactuar con el usuario
     *
     * @param {Object} modal Archivo .vue con diseño personalizado del modal
     * @param {Array<Object>} extra Datos adicionales a ser retornados por la propiedad data() de Vue
     */
    constructor(config, modal, extra) {
        const _this = this
        //Si no se pasa un diseño personalizado del modal usar el diseño predeterminado
        this.root = modal || Root
        this.root.mixins = [
            {
                data() {
                    const data = {
                        /**
                         * Configuración de los elementos del modal
                         */
                        config: {
                            window: config.window || false,
                            title: config.title || false,
                            background: config.background || "#fff",
                            icon: config.icon || false,
                            description: config.description || false,
                            inputs: config.inputs || [],
                            close:
                                config.close ||
                                new ModalButton({
                                    classes: "btn-close-white",
                                }),
                            cancel:
                                config.cancel ||
                                new ModalButton({
                                    text: "Cancelar",
                                    classes: "btn-secondary",
                                }),
                            accept:
                                config.accept ||
                                new ModalButton({
                                    text: "Aceptar",
                                    classes: "btn-primary",
                                }),
                        },
                    }
                    if (extra !== undefined) {
                        for (const item of extra) {
                            for (const key in item) {
                                data[key] = item[key]
                            }
                        }
                    }
                    return data
                },
                methods: {
                    /**
                     * Resuelve la promesa del modal y pasarle los datos del formulario
                     * @param {FormData} data Datos del formulario si se pasaron inputs en la configuración
                     */
                    accept(data) {
                        _this.resolve({
                            status: "accept",
                            data: data,
                        })
                    },
                    /**
                     * Resuelve la promesa del modal
                     */
                    cancel() {
                        _this.resolve({
                            status: "cancel",
                        })
                    },
                },
            },
        ]
        this.app = createApp(this.root)
    }

    /**
     * Muestra el modal
     * @returns {Promise} Promesa que se resuelve cuando se acepta, se cancela o se cierra el modal
     */
    fire() {
        return new Promise((resolve) => {
            this.resolve = resolve
            this.app.mount("#modals")
        })
    }
}
