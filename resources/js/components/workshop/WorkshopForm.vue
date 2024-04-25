<script>
    import Form from "../../mixins/Form.js"

    import FormFooter from "../native/form-footer/FormFooter.vue"

    export default {
        mixins: [Form],
        components: { FormFooter },
        props: {
            payTypes: Array,
        },
        methods: {
            submit(e) {
                const data = new FormData(e.target)
                const day = this.$el.querySelector("#day").value
                const time = this.$el.querySelector("#time").value
                data.append("finished", `${day} ${time.substring(0, 5)}`)
                if (this.item.id == undefined) {
                    //this.emitter.emit("submit", {id: null, data: data})
                    this.$emit("submit", { id: null, data: data })
                } else {
                    data.append("_method", "put")
                    //this.emitter.emit("submit", {id: this.item.id, data: data})
                    this.$emit("submit", { id: this.item.id, data: data })
                }
            },
            getDay(finished) {
                if (finished == undefined) {
                    const today = new Date().toLocaleString()
                    return today.substring(0, today.indexOf(","))
                } else {
                    return finished.substring(0, finished.indexOf(" "))
                }
            },
            getTime(finished) {
                if (finished == undefined) {
                    const today = new Date().toLocaleString()
                    return today.substring(today.indexOf(",") + 1)
                } else {
                    return finished.substring(finished.indexOf(" ") + 1)
                }
            },
        },
    }
</script>

<style scoped>
    textarea {
        min-height: 5rem;
    }
</style>

<template>
    <form class="page-container" v-on:submit.prevent="submit">
        <fieldset class="mb-4">
            <legend><i class="bi bi-laptop"></i> Datos del equipo</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Nombre" class="form-control" name="name" id="name" :value="data.name" required />
                            <label for="name">Nombre <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Contacto por SMS" class="form-control" name="contact" id="contact" :value="data.contact" required />
                            <label for="contact">Contacto por SMS <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Estado" class="form-control" name="state" id="state" :value="data.state" required />
                            <label for="state">Estado <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="mb-4">
            <legend><i class="bi bi-tools"></i> Datos del servicio</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Precio" class="form-control" name="price" id="price" :value="data.price" required />
                            <label for="price">Precio <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-4">
                            <input type="date" placeholder="Día de entrega" class="form-control" id="day" :value="getDay(data.finished)" required />
                            <label for="day" class="form-label">Día de entrega <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-4">
                            <input type="time" placeholder="Hora de entrega" class="form-control" id="time" :value="getTime(data.finished)" required />
                            <label for="time" class="form-label">Hora de entrega <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend><i class="bi bi-tags"></i> Etiquetas</legend>
            <div class="p-1">
                <div class="form-floating mb-1">
                    <textarea class="form-control" placeholder="Escribas las etiquetas separadas por comas" name="tags" id="tags">{{ Utils.join(data.tags) }}</textarea>
                    <label for="tags" class="form-label">Escribas las etiquetas separadas por comas</label>
                </div>
                <small class="text-muted">Estas etiquetas serán utilizadas para mostrar productos de interés a los clientes en la página de seguimiento.</small>
            </div>
        </fieldset>

        <fieldset class="mb-4">
            <legend><i class="bi bi-credit-card"></i> Método de pago</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <div v-for="(payType, index) in payTypes" class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payType" :value="payType.value" :id="'type_' + index" />
                                <label class="form-check-label" :for="'type_' + index">{{ payType.label }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <FormFooter />
    </form>
</template>
