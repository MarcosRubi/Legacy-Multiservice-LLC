<?php
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
// if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'regresoVacio') {
//     echo "var Toast = Swal.mixin({
//                 toast: true,
//                 position: 'top-end',
//                 showConfirmButton: false,
//                 timer: 3000
//             });
//             Toast.fire({
//                 icon: 'error',
//                 title: 'La fecha de regreso es obligatoria.'
//             })";
//     unset($_SESSION['error-registro']);
// }
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

if (isset($_SESSION['success-registro']) && $_SESSION['success-registro'] === 'factura') {
    echo "var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Factura guardada correctamente.'
                })";
    unset($_SESSION['success-registro']);
}
if (isset($_SESSION['success-registro']) && $_SESSION['success-registro'] === 'cotizacion') {
    echo "var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Cotización guardada correctamente.'
                })";
    unset($_SESSION['success-registro']);
}
if (isset($_SESSION['success-registro']) && $_SESSION['success-registro'] === 'boletos') {
    echo "var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Boletos guardado correctamente.'
                })";
    unset($_SESSION['success-registro']);
}
if (isset($_SESSION['success-registro']) && $_SESSION['success-registro'] === 'boleto') {
    echo "var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Boleto guardado correctamente.'
                })";
    unset($_SESSION['success-registro']);
}
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
if (isset($_SESSION['error']) && $_SESSION['error'] === 'ClienteNotFound') {
    echo "var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'error',
                    title: 'Cliente no encontrado.'
                })";
    unset($_SESSION['error']);
}
if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'fecha') {
    echo " var Toast = Swal.mixin({
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
if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'pnr') {
    echo " var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
                icon: 'error',
                title: 'El PNR es obligatorio.'
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


if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'fecha') {
        echo "var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            icon: 'error',
            title: 'Fecha no válida.'
        })";
    unset($_SESSION['error-registro']);
}
if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'ida') {
        echo "var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: 'error',
            title: 'Fecha de ida no válida.'
        })";
    unset($_SESSION['error-registro']);
}
if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'valor') {
        echo "var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            icon: 'error',
            title: 'Introduzca un valor.'
        })";
    unset($_SESSION['error-registro']);
}
if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'pago') {
        echo "var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000
        });
        Toast.fire({
            icon: 'error',
            title: 'Selecciona una forma de pago e introduzca la cantidad.'
        })";
    unset($_SESSION['error-registro']);
}
if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'numeroTarjetaVacio') {
        echo "var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
        Toast.fire({
            icon: 'error',
            title: 'El pago con tarjeta de crédito debe ingresar los 4 números finales de la tarjeta.'
        })";
    unset($_SESSION['error-registro']);
}
if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'numeroTarjetaNoCompleto') {
        echo "var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
        Toast.fire({
            icon: 'error',
            title: 'Rellene los 4 números de la tarjeta de crédito.'
        })";
    unset($_SESSION['error-registro']);
}

if (isset($_SESSION['error-registro']) && $_SESSION['error-registro'] === 'cantidad-abono') {
    echo "var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    Toast.fire({
        icon: 'error',
        title: 'La cantidad es obligatoria.'
    })";
unset($_SESSION['error-registro']);
}
if (isset($_SESSION['success-registro']) && $_SESSION['success-registro'] === 'abono') {
    echo "var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Abono guardado correctamente.'
                })";
    unset($_SESSION['success-registro']);
}

?>