function showNotification() {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('error') === '1') {
        var notification = document.getElementById('notification');
        notification.style.display = 'block';

        setTimeout(function() {
            notification.style.display = 'none';
        }, 3000);
    }
}

document.addEventListener('DOMContentLoaded', showNotification);