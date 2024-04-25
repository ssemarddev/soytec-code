import Pusher from "pusher-js"
import ChatForm from "./ChatForm.js"
//Pusher.logToConsole = true

import Request from "../../Request.js"
import ChatBody from "./ChatBody.vue"

const API_URL = "http://127.0.0.1:8000/api/"
export default {
    components: { ChatBody },
    data() {
        return {
            apikey: "",
            chats: [],
            chat: null,
            colors: ["#f11818", "#da1f95", "#f3620e", "#18bd18", "#1e90ff", "#4b0082", "#8a2be2"],
            sending: {
                chats: [],
                messages: [],
            },
            selection: null,
        }
    },
    methods: {
        rand(index) {
            const rand = index % this.colors.length
            return `background-color: ${this.colors[rand]}`
        },
        remove() {
            const data = new FormData()
            const ids = []
            for (let chat of this.selection) {
                ids.push(chat.id)
            }
            data.append("ids", ids)
            Request.delete(API_URL + "client/chats/" + this.apikey, data)
            this.selection = null
        },
    },
    mounted() {
        // Request.get("api/chats")
        //     .then((response) => {
        //         this.chats = response.data
        //     })
        //     .catch((e) => console.log(e))

        Request.get("api/chats/apikey").then((response) => {
            this.apikey = response.data.chat
            this.init(response.data.pusher)
            new ChatForm(this.$el, this.apikey, (chat) => {
                this.sending.chats.push(chat)
            })
            Request.get(API_URL + "client/chats/" + response.data.apikey).then((response) => {
                this.chats = response.data
            })
        })
    },
}
