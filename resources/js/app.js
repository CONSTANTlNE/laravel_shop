

import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css'; // Import from node_modules

import * as bootstrap from 'bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css'

import htmx from "htmx.org";
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';
import Swal from 'sweetalert2';
import Splide from '@splidejs/splide';
import '@splidejs/splide/css';

window.Notyf = Notyf;
window.htmx = htmx;
window.Swal = Swal;
window.Splide = Splide;
window.bootstrap = bootstrap;

if (window.alertError) {
    Swal.fire({
        icon: 'error',
        showConfirmButton: true,
        // timer: 2800,
        text: window.alertError,
    });
}

if (window.alertSuccess) {
    Swal.fire({
        icon: 'success',
        showConfirmButton: false,
        timer: 2800,
        text: window.alertSuccess,
    });
}

if (window.validationErrors && window.validationErrors.length) {
    Swal.fire({
        icon: 'error',
        html: window.validationErrors.join('<br>'),
        showConfirmButton: true,
        // timer: 2800,
    });
}

// import '../../public/frontassets/styles/bootstrap.css'
// import '../../public/frontassets/fonts/bootstrap-icons.css'
import '../../public/frontassets/styles/style.css'
import '../../public/frontassets/scripts/custom.js'





