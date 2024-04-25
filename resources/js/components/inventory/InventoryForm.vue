<script>
    import Form from "../../mixins/Form.js"
    import Request from "../../Request.js"

    import FormFooter from "../native/form-footer/FormFooter.vue"

    export default {
        mixins: [Form],
        components: { FormFooter },
        data() {
            return {
                units: [],
            }
        },
        created() {
            Request.get("api/units").then((response) => {
                this.units = response.data
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
            <legend><i class="bi bi-tag"></i> &nbsp; Información de la entrada en inventario</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Nombre de la entrada" required :value="data.name" />
                            <label>Nombre <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="model" placeholder="Modelo" required :value="data.model" />
                            <label>Modelo <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" maxlength="700" placeholder="Descripción">{{ data.description }}</textarea>
                            <label>Descripción <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" name="stock" placeholder="Cantidad en stock" required :value="data.stock" />
                            <label>Cantidad en stock <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <!-- <label for="unit" class="form-label">Categoría del producto</label> -->
                            <select class="form-control" name="unit_id">
                                <template v-for="unit in units">
                                    <option :value="unit.id" :selected="data.unit_id == unit.id">{{ unit.name }}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <FormFooter :columns="columns" />
    </form>
</template>
