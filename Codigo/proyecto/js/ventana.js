// ventana.js


function showNotification() {
    var notification = document.getElementById('notification');

    // Oculta la notificación después de 3 segundos
    setTimeout(function() {
        notification.style.display = 'none';
    }, 3000);
}
