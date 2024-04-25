<script>
    import Form from "../../mixins/Form.js"
    import Request from "../../Request.js"

    import FormFooter from "../native/form-footer/FormFooter.vue"
    import Color from "./Color.vue"

    export default {
        mixins: [Form],
        components: { FormFooter, Color },
        data() {
            return {
                categories: [],
                colors: [{}],
            }
        },
        methods: {
            addColor() {
                if (this.data.colors == undefined) {
                    this.colors.push({})
                } else {
                    this.data.colors.push({})
                }
            },
            removeColor(index) {
                if (this.data.colors == undefined) {
                    this.colors.splice(index, 1)
                } else {
                    this.data.colors.splice(index, 1)
                }
            },
        },
        created() {
            Request.get("api/categories").then((response) => {
                this.categories = response.data
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
            <legend><i class="bi bi-qr-code"></i> Código de barras y SKU</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="number" placeholder="Código de barras" class="form-control" name="code" id="code" :value="data.code" required />
                            <label for="code">Código de barras <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="SKU" class="form-control" name="sku" id="sku" :value="data.sku" required />
                            <label for="sku">SKU <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-box"></i> Información del producto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Nombre" class="form-control" name="name" id="name" :value="data.name" required />
                            <label for="name">Nombre <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Precio de compra (Con impuesto incluido)" class="form-control" name="price" id="price" :value="data.price" required />
                            <label for="price">Precio de compra (Con impuesto incluido) <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Precio de venta (Con impuesto incluido)" class="form-control" name="cost" id="cost" :value="data.cost" required />
                            <label for="cost">Precio de venta (Con impuesto incluido) <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-4">
                            <input type="number" placeholder="Stock o existencias" class="form-control" name="stock" id="stock" :value="data.stock" required />
                            <label for="stock">Stock o existencias <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-4">
                            <input type="number" placeholder="Stock mínimo" class="form-control" name="min" id="min" :value="data.min" required />
                            <label for="min">Stock mínimo <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Fabricante" class="form-control" name="trademark" id="trademark" :value="data.trademark" />
                            <label for="trademark">Fabricante <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-4">
                            <input type="text" placeholder="Modelo" class="form-control" name="model" id="model" :value="data.model" />
                            <label for="model">Modelo <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-1">
            <legend><i class="bi bi-box2-fill"></i> Tipo, Presentación, Categoría & Estado</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="mb-4">
                            <label>Tipo de producto</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="type" value="Físico" id="state-fisico" :checked="data.type == 'Físico'" />
                                <label class="form-check-label" for="state-fisico">Físico</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="type" value="Digital" id="state-digital" :checked="data.type == 'Digital'" />
                                <label class="form-check-label" for="state-digital">Digital</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="mb-4">
                            <label>Estado del producto</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="state" value="Activo" id="state-active" :checked="data.state == 'Activo'" />
                                <label class="form-check-label" for="state-active">Activo</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="state" value="Inactivo" id="state-inactive" :checked="data.state == 'Inactivo'" />
                                <label class="form-check-label" for="state-inactive">Inactivo</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="mb-4">
                            <label class="form-label">Categoría del producto</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <template v-for="category in categories">
                                    <option :value="category.id" :selected="data.category_id == category.id">{{ category.name }}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <!-- <legend><i class="bi bi-card-heading"></i> Descripción</legend> -->
                        <div class="form-floating mb-4">
                            <textarea class="form-control" placeholder="Descripción" name="description" id="description" rows="5">{{ data.description }}</textarea>
                            <label for="description">Descripción</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <!-- <legend><i class="fa fa-tags"></i> Etiquetas</legend> -->
                        <div class="form-floating mb-4">
                            <textarea class="form-control" placeholder="Escriba las etiquetas separadas por coma" name="tags" id="tags" rows="5">{{ Utils.join(data.tags) }}</textarea>
                            <label for="tags">Escriba las etiquetas separadas por coma</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-file-earmark-image-fill"></i> Foto o portada de producto</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <label for="image" class="form-label">Tipos de archivos permitidos: JPG, JPEG, PNG. Tamaño máximo 3MB. Resolución mínima 500px X 500px o superior manteniendo el aspecto cuadrado (1:1)</label>
                        <input class="form-control form-control-sm" id="image" name="image" type="file" />
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <button @click="addColor" type="button" class="btn btn-success btn-sm float-end"><i class="bi bi-plus-lg"></i> Agregar color</button>
            <h4 style="font-weight: normal"><i class="bi bi-tools"></i> &nbsp; Colores del producto</h4>
            <div class="container-fluid" v-if="data.colors == undefined">
                <template v-for="(color, index) in colors">
                    <Color @remove="removeColor" :index="index" :color="color" />
                </template>
            </div>
            <div class="container-fluid" v-else>
                <template v-for="(color, index) in data.colors">
                    <Color @remove="removeColor" :index="index" :color="color" />
                </template>
            </div>
        </fieldset>
        <FormFooter />
    </form>
</template>
