<script>
    import Mixin from "./SortMixin.js"

    export default {
        /**
         * @mixin ./SortMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <th v-show="column.visible" :title="'Haga click para ordenar por ' + column.name" @click="sort" data-bs-toggle="tooltip"><i :class="column.icon"></i> {{ column.name }} <i :class="orderIcon"></i></th>
</template>
