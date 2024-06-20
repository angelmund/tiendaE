import './bootstrap';

// Importa jQuery y asigna a las variables globales
import $ from 'jquery';
window.jQuery = $;
window.$ = $;

// Importa SweetAlert2 y DataTables
import 'sweetalert2';
import 'select2';
//  import 'datatables.net'; // Importa DataTables después de jQuery

// Importa los archivos JavaScript de tu aplicación
// import './datables';
// import './nuevoproyecto';
// import './inscripcion';
// import './updateproyecto';
// import './updateinscripcion';
// import './eventosNPago';
// import './roles';
// import './Permisos';
// import './AltaPagos';
import './alertas';
import './producto';
// import './editarPago';
// import './usuario';
// import './graficas';
// import './proyectosTableconsulta';


// Importa Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
