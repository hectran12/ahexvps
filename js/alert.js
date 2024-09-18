function changeMessageAlert (message, type) {
    var dom = document.getElementById('message_alert');
    dom.innerHTML = `
    <div class="alert alert-${type}" role="alert">
        ${message}
    </div>
    `;
}