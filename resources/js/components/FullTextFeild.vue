<template>
    <section>
        <editor-menu-bar
            :editor="editor"
            class="menu-bar">
            <div slot-scope="{ commands, isActive }">
                <button
                    :class="{ 'is-active': isActive.bold() }"
                    @click="commands.bold"
                    >
                    Bold
                </button>
                <button
                    :class="{ 'is-active': isActive.italic() }"
                    @click="commands.italic">
                    Italic
                </button>
                <button
                    :class="{ 'is-active': isActive.heading({ level: 2 }) }"
                    @click="commands.heading({ level: 2 })">
                    H2
                </button>
                <button
                    :class="{ 'is-active': isActive.heading({ level: 3} )}"
                    @click="commands.heading({ level: 3 })">
                    H3
                </button>
                <button
                    :class="{ 'is-active': isActive.underline() }"
                    @click="commands.underline">
                    _
                </button>
                 <button
                    :class="{ 'is-active': isActive.bullet_list() }"
                    @click="commands.bullet_list">
                    BL
                </button>
                <button
                    :class="{ 'is-active': isActive.ordered_list() }"
                    @click="commands.ordered_list">
                    OL
                </button>
                <button
                    :class="{ 'is-active': isActive.strike() }"
                    @click="commands.strike">
                    Strike
                </button>
                <button
                    @click="commands.horizontal_rule">
                    _
                </button>
            </div>
        </editor-menu-bar>
        <editor-content :editor="editor" class="editor"/>
        <button @click="updatePolicy" class="btn btn-primary mt-3">Update</button>
    </section>
</template>

<script>
import { Editor, EditorContent, EditorMenuBar } from "tiptap";
import {
    HardBreak,
    Heading,
    HorizontalRule,
    OrderedList,
    BulletList,
    ListItem,
    Bold,
    Italic,
    Link,
    Strike,
    Underline,
    History,
    Image
} from 'tiptap-extensions';
export default {
    components: {
        EditorMenuBar,
        EditorContent
    },
    props: {
        policy: String,
    },
    data() {
        return {
            errors: [],
            editor: new Editor({
                extensions: [
                    new HardBreak(),
                    new Heading({ levels: [2, 3]}),
                    new HorizontalRule(),
                    new BulletList(),
                    new OrderedList(),
                    new ListItem(),
                    new Bold(),
                    new Italic(),
                    new Strike(),
                    new Underline(),
                    new History(),
                ],
                content: this.policy,
                onUpdate: ({ getHTML }) => {
                    this.html = getHTML()
                },
            }),
            html: this.content,
        }
    },
    beforeDestroy() {
        this.editor.destroy()
    },
    methods: {
        updatePolicy() {
            this.errors = [];
            console.log(this.html);
            axios.put('/policy', {
                policy: this.html
            })
            .then(res => {
                window.location = '/policy'
            })
            .catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                }
            })
        },
    }
}
</script>

<style scoped>
    section {
        padding: 15px;
    }
    .menu-bar {
        margin-left:-15px;
        margin-right: -15px;
        margin-top: -15px;
        padding: 15px 15px;
        background: rgb(187, 187, 187);
    }
    .editor {
        margin-top:15px;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 2px;
        padding: 5px;
    }
    .ProseMirror-focused {
        outline:none !important;
    }
    .is-active {
        font-weight: 700
    }
</style>
