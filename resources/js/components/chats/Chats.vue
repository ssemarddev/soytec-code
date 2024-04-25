<script>
    import Mixin from "./ChatMixin.js"
    import Websocket from "./Websocket.js"

    export default {
        mixins: [Mixin, Websocket],
    }
</script>

<template>
    <div class="main">
        <div class="row">
            <div class="col-4 p-0 chats" style="max-height: 100%" :class="{ active: chat == null }">
                <div class="chat-navbar">
                    <div class="float-end">
                        <button data-bs-toggle="popover" class="btn bg-transparent text-white p-1"><i class="bi bi-plus"></i></button>
                        <div class="dropdown">
                            <button class="btn btn-sm text-white p-1" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="dropdown-menu" id="save-as">
                                <li>
                                    <button v-if="selection == null" @click="selection = []" class="dropdown-item">Seleccionar chats</button>
                                </li>
                                <li>
                                    <button v-if="selection !== null" @click="selection = null" class="dropdown-item">Cancelar</button>
                                </li>
                                <li>
                                    <button @click="remove" :disabled="selection == null || selection.length == 0" class="dropdown-item">Eliminar chats</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle btn-sm text-white" data-bs-toggle="dropdown">Soytec (Soporte)</button>
                            <ul class="dropdown-menu" id="save-as">
                                <li>
                                    <button class="dropdown-item">Soytec (Soporte técnico)</button>
                                </li>
                                <li>
                                    <button class="dropdown-item">Clientes (Soporte técnico)</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="list-group list-group-flush scroll" style="overflow-y: auto; height: calc(100% - 55px)">
                    <div class="chat" v-for="(item, index) in chats">
                        <div class="form-check" :class="{ 'd-none': selection == null }">
                            <input class="form-check-input" type="checkbox" name="selection" @change="selection.push(item)" />
                        </div>
                        <div class="chat-avatar" :style="rand(index)" @click="chat = item">
                            <h4>{{ item.title.charAt(0) }}</h4>
                        </div>
                        <div class="chat-body" :class="{ selection: selection !== null }" @click="chat = item">
                            <h5 class="text-truncate">{{ item.title }}</h5>
                            <p class="text-truncate">
                                <template v-if="item.messages.length > 0">
                                    {{ item.messages[item.messages.length - 1].message }}
                                </template>
                                <template v-else> No hay mensajes en este chat </template>
                            </p>
                        </div>
                    </div>
                    <div class="chat" v-for="chat in sending.chats">
                        <div class="chat-avatar placeholder" :style="rand()"></div>
                        <div class="chat-body w-100" :class="{ selection: selection !== null }">
                            <h5 class="text-truncate w-100">{{ chat }}</h5>
                            <p class="text-truncate w-100"><span class="placeholder w-100"></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8 p-0" :class="{ active: chat !== null }" style="max-height: 100%">
                <ChatBody @back="chat = null" :chat="chat" :sending="sending.messages" :apikey="apikey" />
            </div>
        </div>
    </div>
</template>

<style scoped>
    .main {
        width: 100%;
        height: calc(100vh - 3.4rem);
        padding: 2rem;
        background-color: rgb(245, 245, 245);
    }
    .main > div {
        background-color: white;
        box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.452);
        overflow: hidden;
        width: 100%;
        height: 100%;
        border-radius: 0.5rem;
        margin-left: unset;
    }
    .chats {
        border-right: solid 1px #bbbbbb;
    }
    .list-group > * {
        border-bottom: solid 1px #bbbbbb;
    }
    .list-group > *:last-child {
        border-bottom: none;
    }
    .chat-navbar {
        width: 100%;
        height: 55px;
        background-color: rgb(68, 68, 68);
    }
    .chat-navbar > div {
        display: flex;
        align-items: center;
        color: white;
        height: 100%;
        padding: 0.75rem;
    }
    .chat {
        padding: 0.45rem;
        text-decoration: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    .chat:hover {
        background-color: #f0f0f0;
    }
    .chat-avatar {
        padding: 0.25rem;
        border-radius: 50%;
        background-color: red;
        width: 3rem;
        height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .chat-avatar > h4 {
        color: white;
        font-weight: bold;
        margin-bottom: 0;
    }
    .chat-body {
        padding-left: 0.5rem;
        max-width: calc(100% - 3rem);
    }
    .selection {
        max-width: calc(100% - 5rem);
    }
    .chat-body > h5 {
        color: #5c5c5c;
        margin-bottom: 0;
        font-weight: bold;
        font-size: 1.1em;
    }
    .chat-body > p {
        color: #919191;
        margin-bottom: 0;
    }
    @media (max-width: 770px) {
        .col-4 {
            width: 45%;
        }
        .col-8 {
            width: 55%;
        }
    }
    @media (max-width: 560px) {
        .col-4 {
            width: 100%;
            display: none;
        }
        .col-4.active {
            display: block;
        }
        .col-8 {
            width: 100%;
            display: none;
        }
        .col-8.active {
            display: block;
        }
    }
</style>
