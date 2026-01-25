import './bootstrap';
import htmx from "htmx.org";

window.htmx = htmx;

import Swal from 'sweetalert2';

if (window.alertError) {
    Swal.fire({
        icon: 'error',
        showConfirmButton: false,
        timer: 2800,
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
        showConfirmButton: false,
        timer: 2800,
    });
}

import '../../public/frontassets/styles/bootstrap.css'
import '../../public/frontassets/fonts/bootstrap-icons.css'
import '../../public/frontassets/styles/style.css'





