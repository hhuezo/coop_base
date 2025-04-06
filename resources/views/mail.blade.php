<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Precio de Bitcoin en Tiempo Real</title>

  <!-- Incluir Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 20px;
    }
    h1 {
      color: #333;
    }
    #price {
      font-size: 2em;
      font-weight: bold;
      color: #0F172A;
    }
    .error {
      color: red;
    }
    .timestamp {
      margin-top: 10px;
      font-size: 0.9em;
      color: #666;
    }
  </style>
</head>
<body>
  <h1>Precio Actual de Bitcoin (USD)</h1>
  <div id="price">Cargando...</div>
  <div id="error" class="error"></div>
  <div id="timestamp" class="timestamp"></div>

  <!-- Inputs para valores mínimo y máximo -->
  <div class="mb-3">
    <label for="minValue" class="form-label">Valor Mínimo:</label>
    <input type="number" id="minValue" class="form-control" value="89000" min="0" max="100000" step="100">
  </div>
  <div class="mb-3">
    <label for="maxValue" class="form-label">Valor Máximo:</label>
    <input type="number" id="maxValue" class="form-control" value="92000" min="0" max="100000" step="100">
  </div>

  <!-- Botón con Bootstrap -->
  <button id="audioButton" class="btn btn-warning" onclick="speakReady()">Hola</button>

  <script>


    // Función para leer un mensaje cuando la página se carga
    function speakReady() {
      const utterance = new SpeechSynthesisUtterance('Listo');
      window.speechSynthesis.speak(utterance);

      // Cambiar el estilo del botón después de hacer clic
      const button = document.getElementById('audioButton');
      button.classList.remove('btn-warning');
      button.classList.add('btn-success');
    }

    // Función para obtener y mostrar el precio de Bitcoin y enviar datos a la API
    function fetchBitcoinPrice() {
      fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd')
        .then(response => {
          if (!response.ok) {
            throw new Error('Error en la respuesta de la API');
          }
          return response.json();
        })
        .then(data => {
          const price = data.bitcoin.usd;
          const timestamp = new Date().toLocaleTimeString(); // Hora actual

          // Actualizar el precio y el timestamp
          document.getElementById('price').textContent = `$${price.toLocaleString()}`;
          document.getElementById('timestamp').textContent = `Actualizado a las: ${timestamp}`;

          // Obtener los valores mínimo y máximo de los inputs
          const minValue = parseFloat(document.getElementById('minValue').value);
          const maxValue = parseFloat(document.getElementById('maxValue').value);

          // Verificar si el precio está fuera del rango y enviar la solicitud POST
          let statusMessage = '';
          let tipo = 0;  // Valor por defecto es 2 (subió)

          if (price < minValue) {
            statusMessage = `El valor bajó el precio es ${price}`;
            tipo = 1;  // Cambiar tipo a 1 si el precio es menor que el valor mínimo
            console.log(`El valor bajó el precio es ${price}`);
          } else if (price > maxValue) {
            statusMessage = `El valor subió el precio es ${price}`;
            tipo = 2;  // Tipo 2 si el precio es mayor que el valor máximo
            console.log(`El valor subió el precio es ${price}`);
          } else {
            //statusMessage = `El valor está dentro del rango: ${price}`;
            console.log(`El valor está dentro del rango: ${price}`);
          }

          // Leer el mensaje en voz alta
          const utterance = new SpeechSynthesisUtterance(statusMessage);
          window.speechSynthesis.speak(utterance);

          // Enviar los datos a la API si el precio ha bajado o subido
          if (tipo === 1 || tipo === 2) {
            const dataToSend = {
              tipo: tipo,
              precio: price,
              _token: '{{ csrf_token() }}' // Pasar el token CSRF en la solicitud
            };

            fetch('{{url('mail')}}', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify(dataToSend)
            })
            .then(response => response.json())
            .then(data => {
              console.log('Respuesta de la API:', data);
              // Aquí puedes mostrar una notificación si lo deseas
            })
            .catch(error => {
              console.error('Error al enviar el correo:', error);
            });
          }

          // Limpiar errores
          document.getElementById('error').textContent = '';
        })
        .catch(error => {
            console.log(`El valor está dentro del rango: ${price}`);
          //document.getElementById('error').textContent = `Error: ${error.message}`;
        });
    }

    // Llamar a la función al cargar la página
    fetchBitcoinPrice();

    // Configurar el intervalo de actualización (30 segundos)
    const INTERVAL = 30 * 1000; // 30 segundos en milisegundos
    setInterval(fetchBitcoinPrice, INTERVAL);
  </script>

  <!-- Incluir los scripts de Bootstrap (necesario para algunas funcionalidades de Bootstrap) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
