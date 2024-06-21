
function alertaInfo(titulo) {
  Swal.fire({
      title: `<strong>${titulo}</strong>`,
      icon: "info",
      showCloseButton: false,
      showCancelButton: false,
      focusConfirm: false,
  });
}

function confirmarInfo(titulo, callback) {
  Swal.fire({
      title: `${titulo}`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Aceptar"
  }).then((result) => {
      if (result.isConfirmed) {
          if (callback && typeof callback === 'function') {
              callback();
          }
          Swal.fire({
              title: "Descargado!",
              text: "Descargado con éxito.",
              icon: "success"
          });
      }
  });
}

//Mensaje de confirmación para guardar 
function confirSave(titulo,callback) {
    Swal.fire({
        title: `${titulo}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Aceptar"
    }).then((result) => {
        if (result.isConfirmed) {
            if (callback && typeof callback === 'function') {
                callback();
            }
        }
    });
}
  
 

// Mensaje de Confirmación para eliminar un registro
function eliminar(titulo,callback){
    Swal.fire({
        title: `${titulo}`,
        text: "Si elimina, no se volverá a recuperar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Eliminar"
      }).then((result) => {
        if (result.isConfirmed) {
            if (callback && typeof callback === 'function') {
                callback();
            }
        }
      });
}

//Mensaje de confirmación para guardar 
 function confirUpdate(titulo,callback) {
    Swal.fire({
        title: `${titulo}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Aceptar"
    }).then((result) => {
        this.submit();
    });
}