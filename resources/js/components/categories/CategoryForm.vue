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
            <legend><i class="bi bi-tag"></i> &nbsp; Información de categoría</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Nombre de la categoría" required :value="data.name" />
                            <label>Nombre <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" maxlength="700" placeholder="Descripción de la categoría">{{ data.description }}</textarea>
                            <label>Descripción <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label><i class="bi bi-toggles"></i> Estado</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Activa" name="state" id="state_1" :checked="data.state == 'Activa'" />
                            <label class="form-check-label" for="state_1"> Activa </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Inactiva" name="state" id="state_2" :checked="data.state == 'Inactiva'" />
                            <label class="form-check-label" for="state_2"> Inactiva </label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <FormFooter @import="save" :columns="columns" />
    </form>
</template>
