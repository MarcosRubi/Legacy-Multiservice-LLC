<script>
    <?php

    //VALIDACIONES PARA FORMULARIO DE BOLETOS
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'dobVacio') {
        echo "
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'Passenger DOB es obligatorio.'
            })";
        unset($_SESSION['error-registro']);
    }

    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'boletos') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El número de boletos es obligatorio.'
            })";
        unset($_SESSION['error-registro']);
    }

    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'dobFormato') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de Passenger DOB no es válida.'
            })";
        unset($_SESSION['error-registro']);
    }

    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'nombre') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El nombre del pasajero es obligatorio.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'aerolinea') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La aerolinea es obligatorio.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'origen') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El origen es obligatorio.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'destino') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El destino es obligatorio.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'idaVacio') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de ida es obligatoria.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'idaFormato') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de ida no es válida.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'regresoVacio') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de regreso es obligatoria.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'regresoFormato') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'La fecha de regreso no es válida.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'precio') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El precio es obligatorio.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'base') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'Base es obligatorio.'
            })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'tax') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'error',
                title: 'El TAX es obligatorio.'
            })";
        unset($_SESSION['error-registro']);
    }

    //VALIDACIONES PARA FORMUALRIO DE CLIENTES
    if (isset($_SESSION['success-registro']) && $_SESSION['success-registro'] === 'cliente') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                icon: 'success',
                title: 'Cliente guardado correctamente.'
            })";
        unset($_SESSION['success-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'fecha') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                    icon: 'error',
                    title: 'Fecha de nacimiento no válida.'
                })";
        unset($_SESSION['error-registro']);
    }
    if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'tel') {
        echo "var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            
            Toast.fire({
                    icon: 'error',
                    title: 'Número de teléfono no válido.'
                })";
        unset($_SESSION['error-registro']);
    }
    ?>
</script>