
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
import SignaturePad from "signature_pad";

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// var sig = new SignaturePad(document.querySelector('canvas'));

const app = new Vue({
    el: '#app',
    data() {
        return {
            sig: '',
        }
    },
    methods: {
         openSigModal: function() {
            console.log(this);
        }
    }
});

// var canvas = document.querySelector('canvas');

// var signaturePad = new SignaturePad(canvas, {
//     penColor: "rgb(0, 0, 0)"
// });
function sigModal() {
    // TODO ADD funtions here
}

const am_checkboxes = document.querySelectorAll('input[name^="am_checkin"]');
const pm_checkboxes = document.querySelectorAll('input[name^="pm_checkout"]');

am_checkboxes.forEach(checkbox => {
    const modal = checkbox.parentElement.parentElement.querySelector('.sig-modal');
    const body = document.querySelector('body');
    const canvas = modal.querySelector('canvas');
    const sigPad = new SignaturePad(canvas, {
        penColor: "rgb(3,3,3)",
        backgroundColor: "#fff"
    });
    checkbox.addEventListener('click',function() {
        modal.classList.add('active');
        body.classList.add('modal-open');
    });
    modal.querySelector('.close').addEventListener('click', function() {
        modal.classList.remove('active');
        body.classList.remove('modal-open');
        sigPad.clear();
        modal.parentElement.querySelector('input[type^="checkbox"]').checked = false;
    });
    modal.querySelector('button').addEventListener('click', function(e) {
        if (!sigPad.isEmpty()) {
            modal.querySelector('input[name^="sig"').value = sigPad.toDataURL("image/jpeg");
            if (modal.querySelector('input[name^="sig"').value > 0) {
                this.form.submit();
            }
        } else {
            e.preventDefault();
            alert('Please Sign to Checkin Child');
            this.form.querySelector('input[type^="checkbox"').checked = false;
        }
    });
});
