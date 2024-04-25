<script>
    export default {
        /**
         * @inject columns: CustomTable
         */
        inject: ["columns"],
    }
</script>
<template>
    <tr>
        <td style="width: 40px" class="table-select">
            <div class="form-check">
                <input tag="selected" class="form-check-input" type="checkbox" disabled />
            </div>
        </td>
        <template v-for="column in columns">
            <td v-if="column.visible">
                <p class="placeholder-glow mb-0">
                    <span class="placeholder w-100"></span>
                </p>
            </td>
        </template>
    </tr>
</template>
