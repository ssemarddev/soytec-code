<script>
    import Form from "../../mixins/Form.js"
    import Request from "../../Request.js"

    import QuotationService from "./QuotationService.vue"
    import FormFooter from "../native/form-footer/FormFooter.vue"

    export default {
        mixins: [Form],
        components: { QuotationService, FormFooter },
        data() {
            return {
                services: 1,
                clients: [],
            }
        },
        methods: {
            addService() {
                if (this.data.services == undefined) {
                    this.services++
                } else {
                    this.data.services.push({})
                }
            },
        },
        created() {
            Request.get("api/clients")
            .then((response) => {
                this.clients = response.data
            })
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
            <legend><i class="bi bi-calculator"></i> &nbsp; Información del cotización</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <select class="form-control" name="client_id">
                                <template v-for="client in clients">
                                    <option :value="client.id" :selected="data.client_id == client.id">{{ client.name }} {{ client.lastName }}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Nombre de la cotización" required :value="data.name" />
                            <label>Nombre de la cotización <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-receipt"></i> &nbsp; Descripción de la cotización</legend>
            <div class="container-fluid">
                <div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="description" placeholder="Descripción de la cotización">{{ data.description }}</textarea>
                        <label>Descripción de la cotización <i class="bi bi-check-all"></i></label>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <button @click="addService" type="button" class="btn btn-success btn-sm float-end"><i class="bi bi-plus-lg"></i> Agregar servicio</button>
            <h4 style="font-weight: normal"><i class="bi bi-tools"></i> &nbsp; Servicios de la cotización</h4>
            <div class="container-fluid" v-if="data.services == undefined">
                <template v-for="(n, index) in services">
                    <QuotationService :index="index" />
                </template>
            </div>
            <div class="container-fluid" v-else>
                <template v-for="(service, index) in data.services">
                    <QuotationService :index="index" :service="service" />
                </template>
            </div>
        </fieldset>
        <FormFooter />
    </form>
</template>
