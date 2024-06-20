import { alertaInfo, confirSave } from "./alertas";
import Swal from 'sweetalert2';
$(document).ready(function () {
    if ($('#formAlta-pagos').length > 0) {
        let formularioValido = false;
        // $('.select2').select2();
        // Ocultar inicialmente los elementos con la clase 'cheque'
        toggleChequeDivs();

        // Manejador de evento para cambiar el valor del select
        $('#concepto_pago').change(function () {
            toggleChequeDivs(); // Mostrar u ocultar los elementos según la opción seleccionada
        });

        // Función para mostrar u ocultar los divs con clase "cheque"
        function toggleChequeDivs() {
            var conceptoPago = $('#concepto_pago').val();
            if (conceptoPago === 'cheque') {
                $('.cheque').removeClass('d-none'); // Mostrar los elementos
                $('#numeroChequePago').prop('required', true); // Hacer obligatorio el campo
                $('#NumeroCuentaBancaria').prop('required', true); // Hacer obligatorio el campo
            } else {
                $('.cheque').addClass('d-none'); // Ocultar los elementos
                $('#numeroChequePago').prop('required', false); // No hacer obligatorio el campo
                $('#NumeroCuentaBancaria').prop('required', false); // No hacer obligatorio el campo
                // Limpiar y quitar clases de validación
                $('#numeroChequePago').val('').removeClass('is-invalid is-valid');
                $('#NumeroCuentaBancaria').val('').removeClass('is-invalid is-valid');
            }
            
        }

        const nCuenta = document.querySelector('#NumeroCuentaBancaria');


        document.getElementById('monto').addEventListener('input', function () {
            // Obtener el valor del input de monto
            var monto = this.value;
            if (!/^[0-9,]+$/.test(monto)) {
                alertaInfo('Solo puede ingresar números');
                this.value = monto.replace(/[^0-9,]/g, ''); // Elimina caracteres no numéricos
            }
            // Llamar a la función NumerosaLetras con el valor del input de monto
            var montoEnLetras = NumerosaLetras(monto);

            // Asignar el resultado al input donde deseas mostrar el valor en letras
            document.getElementById('montLetra').value = montoEnLetras;
        });
        function NumerosaLetras(cantidad) {

            var numero = 0;
            cantidad = parseFloat(cantidad);

            if (cantidad == "0.00" || cantidad == "0") {
                return "CERO";
            } else {
                var ent = cantidad.toString().split(".");
                var arreglo = separar_split(ent[0]);
                var longitud = arreglo.length;

                switch (longitud) {
                    case 1:
                        numero = unidades(arreglo[0]);
                        break;
                    case 2:
                        numero = decenas(arreglo[0], arreglo[1]);
                        break;
                    case 3:
                        numero = centenas(arreglo[0], arreglo[1], arreglo[2]);
                        break;
                    case 4:
                        numero = unidadesdemillar(arreglo[0], arreglo[1], arreglo[2], arreglo[3]);
                        break;
                    case 5:
                        numero = decenasdemillar(arreglo[0], arreglo[1], arreglo[2], arreglo[3], arreglo[4]);
                        break;
                    case 6:
                        numero = centenasdemillar(arreglo[0], arreglo[1], arreglo[2], arreglo[3], arreglo[4], arreglo[5]);
                        break;
                    case 7:
                        numero = millares(arreglo[0], arreglo[1], arreglo[2], arreglo[3], arreglo[4], arreglo[5], arreglo[6], arreglo[7]);
                        break;
                }

                ent[1] = isNaN(ent[1]) ? '00' : ent[1];

                return numero;
            }
        }

        function unidades(unidad) {
            var unidades = Array('UNO', 'DOS ', 'TRES', 'CUATRO ', 'CINCO ', 'SEIS ', 'SIETE ', 'OCHO ', 'NUEVE ');


            return unidades[unidad - 1];
        }

        function decenas(decena, unidad) {
            var diez = Array('ONCE ', 'DOCE ', 'TRECE ', 'CATORCE ', 'QUINCE', 'DIECISEIS ', 'DIECISIETE ', 'DIECIOCHO ', 'DIECINUEVE ');
            var decenas = Array('DIEZ ', 'VEINTE ', 'TREINTA ', 'CUARENTA ', 'CINCUENTA ', 'SESENTA ', 'SETENTA ', 'OCHENTA ', 'NOVENTA ');
            let veinte

            if (decena == 0 && unidad == 0) {
                return "";
            }

            if (decena == 0 && unidad > 0) {
                return unidades(unidad);
            }

            if (decena == 1) {
                if (unidad == 0) {
                    return decenas[decena - 1];
                } else {
                    return diez[unidad - 1];
                }
            } else if (decena == 2) {
                if (unidad == 0) {
                    return decenas[decena - 1];
                }
                else if (unidad == 1) {
                    return veinte = "VEINTI" + "UNO";
                }
                else {
                    return veinte = "VEINTI" + unidades(unidad);
                }
            } else {

                if (unidad == 0) {
                    return decenas[decena - 1] + " ";
                }
                if (unidad == 1) {
                    return decenas[decena - 1] + " Y " + "UNO";
                }

                return decenas[decena - 1] + " Y " + unidades(unidad);
            }
        }

        function centenas(centena, decena, unidad) {
            var centenas = Array("CIENTO ", "DOSCIENTOS ", "TRESCIENTOS ", "CUATROCIENTOS ", "QUINIENTOS ", "SEISCIENTOS ", "SETECIENTOS ", "OCHOCIENTOS ", "NOVECIENTOS ");

            if (centena == 0 && decena == 0 && unidad == 0) {
                return "";
            }
            if (centena == 1 && decena == 0 && unidad == 0) {
                return "CIEN ";
            }

            if (centena == 0 && decena == 0 && unidad > 0) {
                return unidades(unidad);
            }

            if (decena == 0 && unidad == 0) {
                return centenas[centena - 1] + "";
            }

            if (decena == 0) {
                var numero = centenas[centena - 1] + "" + decenas(decena, unidad);
                return numero.replace(" Y ", " ");
            }
            if (centena == 0) {

                return decenas(decena, unidad);
            }

            return centenas[centena - 1] + "" + decenas(decena, unidad);

        }

        function unidadesdemillar(unimill, centena, decena, unidad) {
            var numero = unidades(unimill) + " MIL " + centenas(centena, decena, unidad);
            numero = numero.replace("UN  MIL ", "MIL ");
            if (unidad == 0) {
                return numero.replace(" Y ", " ");
            } else {
                return numero;
            }
        }

        function decenasdemillar(decemill, unimill, centena, decena, unidad) {
            var numero = decenas(decemill, unimill) + " MIL " + centenas(centena, decena, unidad);
            return numero;
        }

        function centenasdemillar(centenamill, decemill, unimill, centena, decena, unidad) {

            var numero = 0;
            numero = centenas(centenamill, decemill, unimill) + " MIL " + centenas(centena, decena, unidad);

            return numero;
        }
        function millares(millon, centenamill, decemill, unimill, centena, decena, unidad) {
            var numero = 0;
            // var centenas = Array( "MILLÓN ", "DOS MILLONES ", "TRES MILLONES ", "CUATRO MILLONES ","CINCO MILLONES ","SEIS MILLONES","SIETE MILLONES ", "OCHO MILLONES ","NUEVE MILLONES");
            var millonEnLetras = unidades(millon) + " MILLÓN ";
            var restoEnLetras = centenas(centenamill, decemill, unimill) + " MIL " + centenas(centena, decena, unidad);
            numero = millonEnLetras + restoEnLetras;
            // if (millon ==0 && centena == 0 && decena == 0 && unidad == 0) {
            //     return "MILLÓN";
            // }
            return numero;
        }


        function separar_split(texto) {
            var contenido = new Array();
            for (var i = 0; i < texto.length; i++) {
                contenido[i] = texto.substr(i, 1);
            }
            return contenido;
        }

        nCuenta.addEventListener('input', function (e) {
            // Obtener el valor actual del campo
            let valor = this.value.trim();

            if (!/^[0-9,]+$/.test(valor)) {
                alertaInfo('Solo puede ingresar números');
                this.value = valor.replace(/[^0-9,]/g, ''); // Elimina caracteres no numéricos
            }
        });



    }
});
