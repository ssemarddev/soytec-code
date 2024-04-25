import Request from "../../Request.js"
import Message from "./Message.vue"

const API_URL = "http://127.0.0.1:8000/api/"
export default {
    inject: ["loggedUser"],
    components: { Message },
    emits: ["send", "back"],
    props: {
        chat: {
            type: Object,
            default: null,
        },
        sending: {
            type: Array,
            default: [],
        },
        apikey: String,
    },
    data() {
        return {
            selection: null,
            src: "",
            annexed: null,
        }
    },
    methods: {
        send(e) {
            const client = this.loggedUser
            const data = new FormData(e.target)
            data.append("client", `${client.name} ${client.lastName}`)
            let item = {
                user: null,
                user_id: null,
                chat: this.chat,
                chat_id: this.chat.id,
                client: `${client.name} ${client.lastName}`,
                client_id: client.id,
                message: data.get("message"),
                annexed: null,
                created_at: Date.now(),
                updated_at: null,
            }
            if (this.annexed.files.length == 0) {
                data.delete("annexed")
            } else {
                item.annexed = this.src
                this.src = ""
            }
            Request.post(API_URL + "client/messages/" + this.apikey, data)
            //Añadir mensaje a la lista de mensajes en estado "Enviando"
            this.sending.push(item)
            //Ir al final del scroll en los mensajes
            this.scroll()
        },
        remove() {
            const data = new FormData()
            const ids = []
            for (let message of this.selection) {
                ids.push(message.id)
            }
            data.append("ids", ids)
            Request.delete(API_URL + "client/messages/" + this.apikey, data).then(() => {
                this.selection = null
                for (let id of ids) {
                    for (let i in this.chat.messages) {
                        if (this.chat.messages[i].id == id) {
                            this.chat.messages.splice(i, 1)
                            break
                        }
                    }
                }
            })
        },
        scroll() {
            const messageList = this.$el.querySelector(".message-list")
            const length = (messageList.scrollHeight - messageList.scrollTop) / 50
            let i = 1
            const interval = setInterval(() => {
                messageList.scrollTop += length
                i++
                if (i > 50) clearInterval(interval)
            }, 5)
        },
        reset() {
            this.annexed.value = ""
            this.src = ""
        },
    },
    mounted() {
        this.annexed = this.$el.querySelector("[type='file']")
        const preview = this.$el.querySelector("#preview > img")
        this.annexed.addEventListener("change", () => {
            const files = this.annexed.files
            if (!files || !files.length) {
                this.src = ""
            } else {
                this.src = URL.createObjectURL(files[0])
            }
            preview.src = this.src
        })
    },
}
