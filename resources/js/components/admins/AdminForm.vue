<script>
    import Form from "../../mixins/Form.js"
    import Request from "../../Request.js"

    import AvatarForm from "../Avatar.vue"
    import FormFooter from "../native/form-footer/FormFooter.vue"

    export default {
        mixins: [Form],
        components: { AvatarForm, FormFooter },
        data() {
            return {
                permissions: [],
                isRoot: false,
            }
        },
        methods: {
            isPermissionExist(id) {
                if (this.data.permissions == undefined) return false
                for (let permission of this.data.permissions) {
                    if (permission.permission_id == id || this.isRoot) return true
                }
                return false
            },
            submit(e) {
                const data = new FormData(e.target)
                const permissions = []
                this.$el.querySelectorAll("input[name=permissions]:checked").forEach((input) => {
                    permissions.push(input.value)
                })
                data.set("permissions", permissions)
                if (this.item.id == undefined) {
                    this.$emit("submit", { id: null, data: data })
                } else {
                    data.append("_method", "put")
                    this.$emit("submit", { id: this.item.id, data: data })
                }
            },
        },
        created() {
            Request.get("api/permissions").then((response) => {
                this.permissions = response.data
            })
        },
    }
</script>

<template>
    <form class="page-container" v-on:submit.prevent="submit">
        <AvatarForm :avatar="data.avatar" />
        <fieldset class="mb-4">
            <legend><i class="bi bi-person-square"></i> Información personal</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Nombres" class="form-control" name="name" :value="data.name" required />
                            <label>Nombres <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Apellidos" class="form-control" name="lastName" :value="data.lastName" required />
                            <label>Apellidos <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Teléfono" class="form-control" name="phone" :value="data.phone" />
                            <label>Teléfono</label>
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
                                <input class="form-check-input" type="radio" name="gender" value="Masculino" checked />
                                <label class="form-check-label">Masculino</label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="gender" value="Femenino" :checked="data.gender == 'Femenino'" />
                                <label class="form-check-label">Femenino</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="Otro" :checked="data.gender == 'Otro'" />
                                <label class="form-check-label">Otro</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-person-bounding-box"></i> Datos de la cuenta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-3">
                            <input type="email" placeholder="Correo electrónico" class="form-control" name="email" :value="data.email" required />
                            <label for="email">Correo electrónico <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-3">
                            <input type="text" placeholder="Nombre de usuario" class="form-control" name="username" :value="data.username" required />
                            <label>Nombre de usuario <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                    <div v-if="data.name == undefined" class="col-12 col-md-6 col-lg-4">
                        <div class="form-floating mb-3">
                            <input type="password" placeholder="Contraseña" class="form-control" name="password" required />
                            <label for="password">Contraseña <i class="bi bi-check-all"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="mb-4">
            <legend><i class="bi bi-person-bounding-box"></i> Permisos del usuario</legend>
            <div class="container-fluid">
                <div class="row">
                    <template v-for="(permission, index) in permissions">
                        <div v-if="index == 0" class="form-check mb-2 col-12 col-md-6 col-lg-4">
                            <input class="form-check-input" type="checkbox" name="permissions" :value="permission.id" v-model="isRoot" :checked="isPermissionExist(permission.id)" />
                            <label class="form-check-label">{{ permission.name }}</label>
                        </div>
                        <div v-else class="form-check mb-2 col-12 col-md-6 col-lg-4">
                            <input class="form-check-input" type="checkbox" name="permissions" :value="permission.id" :checked="isPermissionExist(permission.id)" :disabled="isRoot" />
                            <label class="form-check-label">{{ permission.name }}</label>
                        </div>
                    </template>
                </div>
            </div>
        </fieldset>

        <fieldset class="mb-4">
            <legend><i class="bi bi-person-circle"></i> Tipo y estado de cuenta</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <span>Estado de la cuenta</span>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="state" value="Activa" checked />
                                <label class="form-check-label">Activa</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="state" value="Bloqueada" :checked="data.state == 'Bloqueada'" />
                                <label class="form-check-label">Bloqueada</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="mb-4">
                            <span>Estado de la cuenta</span>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="level" value="Administrador" checked />
                                <label class="form-check-label">Administrador</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="level" value="Usuario" :checked="data.level == 'Usuario'" />
                                <label class="form-check-label">Usuario</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset v-if="data.name !== undefined" class="mb-4">
            <legend><i class="bi bi-key"></i> Introduzca su contraseña para guardar los cambios</legend>
            <div class="container-fluid">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="password" placeholder="Contraseña" class="form-control" name="password" required />
                        <label for="password">Contraseña <i class="bi bi-check-all"></i></label>
                    </div>
                </div>
            </div>
        </fieldset>
        <FormFooter />
    </form>
</template>
