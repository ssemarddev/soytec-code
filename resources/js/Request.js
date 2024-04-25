import axios from "axios"
import Alert from "./components/native/alert/Alert.js"
import AlertConfig from "./components/native/alert/AlertConfig.js"

//Bearer token
const token = document.cookie.replace(/(?:(?:^|.*;\s*)TOKEN-API\s*\=\s*([^;]*).*$)|^.*$/, "$1")
axios.defaults.headers.common["Authorization"] = `Bearer ${token.replace("%7C", "|")}`

/**
 * Maneja las peticiones http al servidor
 */
class Request {
    /**
     * Hacer una petición GET al servidor
     * @param {String} url Url a donde se hará la petición, puede ser una ruta relativa o absoluta
     * @return {Promise} Una promesa que se resuelve cuando se reciben los resultados de la respuesta del backend
     */
    static get(url) {
        return new Promise((resolve) => {
            axios({
                method: "get",
                url: url,
            })
                .then((response) => {
                    // console.log(response)
                    resolve(response)
                })
                .catch((error) => {
                    console.log(error)
                    switch (error.request.status) {
                        case 401:
                            Request.showInauthorizedError()
                            break
                        case 422:
                            Request.showUnprocessableError(error.response.data)
                            break
                        case 500:
                            Request.showServerError()
                            break
                    }
                    throw error
                })
        })
    }

    /**
     * Hacer una petición POST al servidor y enviar datos
     * @param {String} url Url de la petición, puede ser una ruta relativa o absoluta
     * @param {Object|FormData} data Datos a enviar
     * @return {Promise} Una promesa que se resuelve cuando se reciben los resultados de la respuesta del backend
     */
    static post(url, data) {
        return new Promise((resolve) => {
            axios({
                method: "post",
                url: url,
                data: data,
            })
                .then((response) => {
                    resolve(response)
                })
                .catch((error) => {
                    console.log(error)
                    switch (error.request.status) {
                        case 401:
                            Request.showInauthorizedError()
                            break
                        case 422:
                            Request.showUnprocessableError(error.response.data)
                            break
                        case 500:
                            Request.showServerError()
                            break
                    }
                    throw error
                })
        })
    }

    /**
     * Hacer una petición DELETE al servidor y enviar datos (opcional)
     * @param {String} url Url de la petición, puede ser una ruta relativa o absoluta
     * @param {Object|FormData} data Datos a enviar
     * @return Una promesa que se resuelve cuando se reciben los resultados de la respuesta del backend
     */
    static delete(url, data) {
        return new Promise((resolve) => {
            data.append("_method", "delete")
            axios({
                method: "post",
                url: url,
                data: data,
            })
                .then((response) => {
                    resolve(response)
                })
                .catch((error) => {
                    switch (error.request.status) {
                        case 401:
                            Request.showInauthorizedError()
                            break
                        case 422:
                            Request.showUnprocessableError(error.response.data)
                            break
                        case 500:
                            Request.showServerError()
                            break
                    }
                    throw error
                })
        })
    }

    /**
     * Mostrar mensaje de error de autenticación
     */
    static showInauthorizedError() {
        const alert = new Alert(
            new AlertConfig({
                title: "¡Error de autenticación!",
                text: "No está autenticado o no tiene permisos para realizar esta acción",
                icon: "bi bi-exclamation-triangle",
                color: "#f55555",
            })
        )
        alert.fire()
    }

    /**
     * Mostrar mensaje de datos inválidos
     */
    static showUnprocessableError(errors) {
        const alert = new Alert(
            new AlertConfig({
                title: "¡Datos inválidos!",
                text: errors.message,
                icon: "bi bi-exclamation-triangle",
                color: "#f55555",
            })
        )
        alert.fire()
    }

    /**
     * Mostrar mensaje de error interno del servidor
     */
    static showServerError() {
        const alert = new Alert(
            new AlertConfig({
                title: "¡Error inesperado!",
                text: "Ocurrió un error inesperado al comunicarse con el servidor",
                icon: "bi bi-exclamation-triangle",
                color: "#f55555",
            })
        )
        alert.fire()
    }
}

export { Request as default }
