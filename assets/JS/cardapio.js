// cardapio.js

document.addEventListener('DOMContentLoaded', function () {
    var adicionarButtons = document.querySelectorAll('.adicionar-carrinho');

    adicionarButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var quantidadeInput = this.closest('tr').querySelector('.quantidade');
            var produtoIdInput = this.closest('tr').querySelector('.produto_id');
            var quantidade = quantidadeInput.value;
            var produtoId = produtoIdInput.value;

            var formData = new FormData();
            formData.append('action', 'adicionar');
            formData.append('quantidade', quantidade);
            formData.append('produto_id', produtoId);

            fetch('cardapio.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.type === 'success') {
                            showSuccessPopup(data.message);
                        } else {
                            showErrorPopup(data.message);
                        }
                    } else {
                        showErrorPopup(data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showErrorPopup('Erro ao adicionar produto.');
                });
        });
    });
});

function showSuccessPopup(message) {
    var modalMessage = document.getElementById('modal-message');
    var modalOk = document.getElementById('modal-ok');

    modalMessage.innerText = message;

    modalOk.onclick = function () {
        $('#successModal').modal('hide');
    };

    $('#successModal').modal('show');
}

function showErrorPopup(message) {
    var modalMessage = document.getElementById('modal-message');
    var modalOk = document.getElementById('modal-ok');

    modalMessage.innerText = message;

    modalOk.onclick = function () {
        $('#successModal').modal('hide');
    };

    $('#successModal').modal('show');
}
