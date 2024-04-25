<script>
    import Form from "../../mixins/Form.js"
    import FormFooter from "../native/form-footer/FormFooter.vue"

    export default {
        mixins: [Form],
        components: { FormFooter },
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
            <legend><i class="bi bi-building"></i> &nbsp; Información del proveedor</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Nombre del proveedor" required :value="data.name" />
                            <label>Nombre <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="url" class="form-control" name="website" placeholder="Sitio web del proveedor" required :value="data.website" />
                            <label>Sitio web <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="address" maxlength="200" placeholder="Dirección del proveedor">{{ data.address }}</textarea>
                            <label>Dirección postal <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-phone"></i> &nbsp; Contacto con el proveedor</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" name="phone" placeholder="Número de teléfono del proveedor" required :value="data.phone" />
                            <label>Número de teléfono <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="email" placeholder="Email del proveedor" required :value="data.email" />
                            <label>Email <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <FormFooter @import="save" :columns="columns" />
    </form>
</template>
