import {collapse} from "@alpinejs/collapse";
import Swal from "sweetalert2";

Alpine.plugin(collapse)
window.Swal = Swal;

import.meta.glob([
    '../images/**',
]);
