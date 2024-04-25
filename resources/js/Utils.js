/**
 * Maneja funciones comunes de la aplicación
 */
export default class Utils {
    /**
     * Convertir una hora en números de minutos totales en un string más legible por el usuario
     * @param {number} time Número de minutos totasales
     */
    static timeToString(time) {
        const days = Math.floor(time / 1340)
        const res = time % 1340
        const hours = Math.floor(res / 60)
        const minutes = Math.floor(res % 60)
        let result = []
        if (days > 0) {
            result.push(days > 1 ? `${days} días` : `${days} día`)
        }
        if (hours > 0) {
            result.push(hours > 1 ? `${hours} horas` : `${hours} hora`)
        }
        if (minutes > 0) {
            result.push(minutes > 1 ? `${minutes} minutos` : `${minutes} minuto`)
        }
        return result.join(", ")
    }

    /**
     * Convertir una fecha en un string más legible para el usuario
     * @param {String} date String de fecha válido para obtener la fecha
     */
    static localeDateString(date) {
        const result = new Date(date).toLocaleDateString("es-ES", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        })
        return result.charAt(0).toUpperCase() + result.substring(1)
    }

    /**
     * Convertir una fecha y hora en un string más legible para el usuario
     * @param {String} date String de fecha válido para obtener la fecha y hora
     */
    static localeDateTimeString(date) {
        const result = new Date(date).toLocaleDateString("es-ES", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
            hour: "numeric",
            minute: "2-digit",
        })
        return result.charAt(0).toUpperCase() + result.substring(1)
    }

    /**
     * Obtener hora de una fecha
     * @param {String} time String de fecha válido para obtener la hora en formato HH:MM AM/PM
     */
    static getTime(time) {
        const result = new Date(time).toLocaleDateString("es-ES", {
            hour: "numeric",
            minute: "2-digit",
            hour12: true,
        })
        return result.substring(result.indexOf(",") + 1)
    }

    /**
     * Unir varios elementos de un array por una coma (,)
     * @param {Array} items Elementos a unir
     * @return {String} Elementos del Array separados por comas (,)
     */
    static join(items) {
        if (items == undefined) return
        return items.join(",")
    }
}
