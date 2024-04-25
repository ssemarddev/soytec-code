<script>
    import Mixin from "./ChatBodyMixin.js"

    export default {
        mixins: [Mixin],
    }
</script>
<template>
    <div style="height: 100%; position: relative">
        <div class="messages-navbar">
            <button @click="$emit('back')" class="btn btn-sm text-white me-2"><i class="bi bi-arrow-left"></i></button>
            <div>
                <h5 v-if="chat == null">Selecciona un chat para mostrar sus mensajes</h5>
                <h5 v-else>{{ chat.title }}</h5>
                <p v-if="chat !== null">{{ chat.messages.length }} mensajes en este chat</p>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-sm text-white" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                    <ul class="dropdown-menu" id="save-as">
                        <li>
                            <button v-if="selection == null" @click="selection = []" class="dropdown-item">Seleccionar mensajes</button>
                        </li>
                        <li>
                            <button v-if="selection !== null" @click="selection = null" class="dropdown-item">Cancelar</button>
                        </li>
                        <li>
                            <button @click="remove" :disabled="selection == null || selection.length == 0" class="dropdown-item">Eliminar</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="message-list px-3 scroll" :class="{ empty: chat == null }">
            <template v-if="chat !== null" v-for="message in chat.messages">
                <Message :message="message" :selection="selection" />
            </template>
            <template v-for="message in sending">
                <Message :message="message" :selection="selection" sending="true" />
            </template>
            <div id="preview" :style="{ bottom: src == '' ? '-16rem' : '3.2rem' }">
                <img :src="src" />
                <button @click="reset" :class="{ 'd-none': src == '' }" class="btn btn-sm"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>
        <form class="chat-form" @submit.prevent="send">
            <input type="hidden" name="chat_id" :value="chat == null ? 0 : chat.id" />
            <button @click="annexed.click()" type="button" class="btn btn-sm"><i class="bi bi-image"></i></button>
            <input type="file" name="annexed" />
            <textarea type="text" class="form-control mx-2" name="message" placeholder="Describe tu problema"></textarea>
            <button class="btn btn-sm btn-success"><i class="bi bi-send"></i></button>
        </form>
    </div>
</template>

<style scoped>
    .messages-navbar {
        width: 100%;
        height: 55px;
        background-color: rgb(68, 68, 68);
    }
    .message-list {
        overflow-y: auto;
        height: calc(100% - 110px);
    }
    .message-list.empty {
        background-image: url(../../../img/conversation.svg);
        background-position: bottom;
        background-size: contain;
        background-repeat: no-repeat;
    }
    .chat-form {
        height: 55px;
        width: 100%;
        padding-left: 0.5rem;
        padding-right: 0.75rem;
        display: flex;
        align-items: center;
        background-color: #fafafa;
        border-top: solid 1px #bbbbbb;
    }
    .chat-form > textarea {
        height: 2rem;
    }
    .chat-form > input[type="file"] {
        display: none;
    }
    .messages-navbar {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        position: relative;
    }
    .messages-navbar > div > h5 {
        color: white;
        margin-bottom: 0;
        font-size: 1em;
    }
    .messages-navbar > div > p {
        color: #dddddd;
        margin-bottom: 0;
    }
    .messages-navbar > div:last-child {
        position: absolute;
        right: 0.85rem;
    }
    .messages-navbar > div:last-child > button {
        color: white;
        font-size: 1.3em;
        cursor: pointer;
    }
    #preview {
        position: absolute;
        transition: bottom ease-in 0.3s;
        right: 1rem;
        max-width: 50%;
        max-height: 50%;
        border-radius: 0.5rem;
        box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.8);
    }
    #preview > img {
        max-width: 100%;
        max-height: 100%;
        border-radius: 0.5rem;
    }
    #preview > button {
        position: absolute;
        right: 0.5rem;
        background-color: #fff;
        border-radius: 50%;
        top: 0.5rem;
        opacity: 0.8;
        transition: opacity ease-in-out 0.3;
    }
    #preview > button:hover {
        opacity: 1;
    }
</style>
