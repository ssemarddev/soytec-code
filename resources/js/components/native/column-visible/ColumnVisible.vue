<script>
    export default {
        /**
         * @inject columns: CustomTable
         */ 
        inject: ["columns"],
    }
</script>

<template>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown"><i class="bi bi-list-check"></i> Columnas visibles</button>
        <ul class="dropdown-menu">
            <li v-for="column in columns" class="dropdown-item">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" :checked="column.visible" v-model="column.visible" />
                    <label><i :class="column.icon"></i> {{ column.name }}</label>
                </div>
            </li>
        </ul>
    </div>
</template>
