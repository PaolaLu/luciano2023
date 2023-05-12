// @ts-check

/**
 * @param {HTMLTableSectionElement} elementoBase
 * @param {'libros' | 'socios' | 'prestamos'} entidad
 * @param {any[]} datos
 * @param {string[]} columnas
 */
function insertarFilas(elementoBase, entidad, datos, columnas) {
  if (!datos || !datos.length) {
    return;
  }
  for (const dato of datos) {
    const fila = elementoBase.insertRow();

    for (const columna of columnas) {
      const celda = fila.insertCell();
      const claves = columna.split('.');

      celda.innerText = claves.reduce(
        (datoParcial, clave) => datoParcial[clave],
        dato,
      );
    }

    const celdaDeAcciones = fila.insertCell();
    const editar = document.createElement('button');

    editar.type = 'button';
    editar.innerText = 'Editar';
    editar.className = 'editar';
    editar.onclick = () => {
      editar.disabled = true;

      window.location.href = `/${entidad}/editar?id=${dato.id}`;
    };

    const eliminar = document.createElement('button');

    eliminar.type = 'button';
    eliminar.innerText = 'Eliminar';
    eliminar.className = 'eliminar';
    eliminar.onclick = () => {
      eliminar.disabled = true;
      eliminar.innerText = 'Eliminando...';

      fetch(`/api/${entidad}/${dato.id}`, {
        method: 'DELETE',
      })
        .then((res) => {
          if (res.ok) {
            elementoBase.deleteRow(fila.rowIndex - 1);
          } else {
            eliminar.innerText =
              'Hubo un error y no se pudo eliminar. ' +
              'Cliquéa F12 para abrir la consola.';

            throw res;
          }
        })
        .catch((err) => {
          eliminar.innerText =
            'Hubo un error y no se pudo eliminar. ' +
            'Cliquéa F12 para abrir la consola.';

          throw err;
        });
    };

    celdaDeAcciones.appendChild(editar);
    celdaDeAcciones.appendChild(eliminar);
  }
}
