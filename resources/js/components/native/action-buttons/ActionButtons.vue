<script>
    import Mixin from "./ActionButtonsMixin.js"

    export default {
        /**
         * @mixin: ./ActionButtonMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <div>
        <template v-for="(action, index) in actions">
            <transition name="bounce">
                <button v-show="selection.size() > 0" @click="emit(action)" class="btn btn-primary btn-sm" :style="{ 'animation-delay': index * 150 + 'ms' }" data-bs-toggle="tooltip" :title="action.name" :disabled="action.single === true && selection.size() > 1">
                    <i :class="action.icon"></i>
                </button>
            </transition>
        </template>
    </div>
</template>

<style scoped>
    div {
        display: flex;
        justify-content: center;
    }

    div > * {
        margin: 0.15rem;
    }

    @keyframes bounce-in {
        from,
        20%,
        40%,
        60%,
        80%,
        to {
            animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        0% {
            opacity: 0;
            transform: scale3d(0.3, 0.3, 0.3);
        }

        20% {
            transform: scale3d(1.1, 1.1, 1.1);
        }

        40% {
            transform: scale3d(0.9, 0.9, 0.9);
        }

        60% {
            opacity: 1;
            transform: scale3d(1.03, 1.03, 1.03);
        }

        80% {
            transform: scale3d(0.97, 0.97, 0.97);
        }

        to {
            opacity: 1;
            transform: scale3d(1, 1, 1);
        }
    }

    @keyframes bounce-out {
        20% {
            transform: scale3d(0.9, 0.9, 0.9);
        }

        50%,
        55% {
            opacity: 1;
            transform: scale3d(1.1, 1.1, 1.1);
        }

        to {
            opacity: 0;
            transform: scale3d(0.3, 0.3, 0.3);
        }
    }

    .bounce-enter-active {
        animation: bounce-in 0.75s;
        animation-fill-mode: both;
    }

    .bounce-leave-active {
        animation: bounce-out 0.75s;
        animation-fill-mode: both;
    }
</style>
