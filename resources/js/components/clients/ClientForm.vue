<script>
    import Form from "../../mixins/Form.js"
    import AvatarForm from "../Avatar.vue"
    import FormFooter from "../native/form-footer/FormFooter.vue"

    export default {
        mixins: [Form],
        components: { AvatarForm, FormFooter },
        data() {
            return {
                image: null,
                avatar: null,
            }
        },
        methods: {
            selectImage() {
                this.avatar.click()
            },
        },
        mounted() {
            this.avatar = this.$el.querySelector("[name='avatar']")
            this.avatar.addEventListener("change", () => {
                const files = this.avatar.files
                if (!files || !files.length) {
                    this.image = null
                } else {
                    this.image = URL.createObjectURL(files[0])
                }
            })
        },
    }
</script>

<style scoped>
    .preview-image {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }
    .preview-image > img {
        max-width: 200px;
        max-height: 300px;
        border-radius: 50%;
        cursor: pointer;
    }
</style>

<template>
    <form class="page-container" v-on:submit.prevent="submit">
        <div class="preview-image">
            <img v-if="image !== null" :src="image" @click="selectImage" />
            <img v-else src="../../../img/blank-profile.svg" @click="selectImage" />
        </div>
        <input type="file" name="avatar" style="visibility: hidden" />
        <fieldset class="mb-4">
            <legend><i class="bi bi-person-square"></i> Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Nombres" class="form-control" name="name" id="name" required />
                            <label for="name">Nombres <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Apellidos" class="form-control" name="lastName" id="lastName" required />
                            <label for="lastName">Apellidos <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Teléfono" class="form-control" name="phone" id="phone" />
                            <label for="phone">Teléfono</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-gender-ambiguous"></i> Genero</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="gender" value="Masculino" id="gender-male" checked />
                                <label class="form-check-label" for="gender-male">Masculino</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="gender" value="Femenino" id="gender-female" />
                                <label class="form-check-label" for="gender-female">Femenino</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="Otro" id="gender-other" />
                                <label class="form-check-label" for="gender-other">Otro</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-cart4"></i> Información de envió</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Estado, provincia o departamento" class="form-control" name="province" id="province" required />
                            <label for="province">Estado, provincia o departamento <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Ciudad o pueblo" class="form-control" name="city" id="city" required />
                            <label for="city">Ciudad o pueblo <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Calle o dirección de casa" class="form-control" name="address" id="address" required />
                            <label for="address">Calle o dirección de casa <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-person-bounding-box"></i> Datos de la cuenta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="email" placeholder="Correo electrónico" class="form-control" name="email" id="email" required />
                            <label for="email">Correo electrónico <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating mb-3">
                            <input type="password" placeholder="Contraseña" class="form-control" name="password" id="password" required />
                            <label for="password">Contraseña <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-4">
                            <span>Estado de la cuenta</span>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="state" value="Activa" id="state-active" checked />
                                <label class="form-check-label" for="state-active">Activa</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="state" value="Bloqueada" id="state-inactive" />
                                <label class="form-check-label" for="state-inactive">Bloqueada</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <FormFooter />
    </form>
</template>
