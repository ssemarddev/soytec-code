<script>
    import Mixin from "./FiltersMixin.js"
    export default {
        /**
         * @mixin ./FiltersMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <li class="mb-2">
        <div v-if="selected.index == null" class="input-group input-group-sm w-75 m-auto">
            <input @input="error = false" type="text" placeholder="Nombre del filtro" class="form-control" v-model="nameInput" />
            <button @click="saveFilter" class="btn btn-outline-success" type="button"><i class="bi bi-save"></i></button>
        </div>
        <div v-else-if="selected.edit" class="input-group input-group-sm w-75 m-auto">
            <input @input="error = false" type="text" class="form-control" v-model="nameInput" />
            <button @click="saveFilter" class="btn btn-outline-success" type="button"><i class="bi bi-save"></i></button>
        </div>
        <div v-else class="input-group input-group-sm w-75 m-auto">
            <input @input="error = false" type="text" class="form-control" disabled v-model="nameInput" />
            <button @click="saveFilter" class="btn btn-outline-secondary" type="button"><i class="bi bi-pencil-square"></i></button>
        </div>
        <transition name="wobble">
            <div v-if="error" class="error">Nombre de filtro inválido</div>
        </transition>
    </li>
    <li class="text-center">
        <button type="button" class="btn btn-primary btn-sm me-1 dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-save"></i> Guardados</button>
        <ul class="dropdown-menu">
            <template v-if="savedFilters.length > 0">
                <li v-for="(filter, index) in savedFilters">
                    <div class="d-flex">
                        <button @click="setFilter(index)" class="dropdown-item" type="button">{{ filter.name }}</button>
                        <button @click="removeFilter(index)" type="button" class="btn btn-sm me-1"><i class="bi bi-trash"></i></button>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <button @click="removeAllFilters" type="button" class="dropdown-item">Eliminar todos los filtros</button>
                </li>
            </template>
            <li v-else class="dropdown-item">No hay filtros guardados</li>
        </ul>
        <button @click="clean" type="reset" class="btn btn-danger btn-sm"><i class="bi bi-eraser-fill"></i> Quitar filtro</button>
    </li>
</template>

<style scoped>
    .error {
        width: 100%;
        color: #dc3545;
        text-align: center;
    }
    @keyframes flipOutX {
        from {
            transform: perspective(400px);
        }

        30% {
            transform: perspective(400px) rotate3d(1, 0, 0, -20deg);
            opacity: 1;
        }

        to {
            transform: perspective(400px) rotate3d(1, 0, 0, 90deg);
            opacity: 0;
        }
    }
    @keyframes wobble {
        from {
            transform: translate3d(0, 0, 0);
        }

        15% {
            transform: translate3d(-25%, 0, 0) rotate3d(0, 0, 1, -5deg);
        }

        30% {
            transform: translate3d(20%, 0, 0) rotate3d(0, 0, 1, 3deg);
        }

        45% {
            transform: translate3d(-15%, 0, 0) rotate3d(0, 0, 1, -3deg);
        }

        60% {
            transform: translate3d(10%, 0, 0) rotate3d(0, 0, 1, 2deg);
        }

        75% {
            transform: translate3d(-5%, 0, 0) rotate3d(0, 0, 1, -1deg);
        }

        to {
            transform: translate3d(0, 0, 0);
        }
    }
    .wobble-enter-active {
        animation: wobble 0.75s;
        animation-fill-mode: both;
    }
    .wobble-leave-active {
        animation: flipOutX 0.75s;
        animation-fill-mode: both;
    }
</style>
