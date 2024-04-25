<script>
    import Mixin from "./ActionsRowMixin.js"

    export default {
        /**
         * @mixin ./ActionsRowMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <transition name="details">
        <tr v-if="details" class="actions-row">
            <td :colspan="colspan">
                <div>
                    <slot>
                        <template v-for="column in columns">
                            <p v-if="!column.visible"><i :class="column.icon"></i> {{ column.name }}: <span v-html="column.html(item)"></span></p>
                        </template>
                    </slot>
                    <p>
                        <template v-for="action in actions">
                            <button @click="emit(action)" class="btn btn-primary btn-sm"><i :class="action.icon"></i> {{ action.name }}</button>
                        </template>
                    </p>
                </div>
            </td>
        </tr>
    </transition>
</template>

<style scoped>
    .actions-row p {
        margin-bottom: 0.2rem;
    }
    .actions-row p:last-child {
        margin-bottom: 0;
        line-height: 2.1rem;
    }
    .actions-row button {
        margin-right: 0.5rem;
    }
    .actions-row > td {
        padding: 0;
    }
    .actions-row > td > div {
        overflow: hidden;
        padding: 0.5rem;
    }
    @keyframes details-show {
        from {
            height: 0px;
            padding: 0;
        }
        75% {
            transform: scale3d(1, 1.1, 1.1);
        }
        100% {
            transform: scale3d(1, 1, 1);
        }
        to {
            height: auto;
            padding: 0.5rem;
        }
    }
    .details-enter-active,
    .details-enter-active > td > div {
        animation: details-show 0.15s;
        animation-fill-mode: forwards;
        animation-timing-function: ease-in;
    }
    .details-leave-active,
    .details-leave-active > td > div {
        animation: details-show 0.15s;
        animation-fill-mode: backwards;
        animation-direction: reverse;
        animation-timing-function: ease-out;
    }
</style>
