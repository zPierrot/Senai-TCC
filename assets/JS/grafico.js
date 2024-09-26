document.addEventListener("DOMContentLoaded", function() {
    fetch('data.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); // Verificar dados recebidos
            const ctx = document.getElementById('productChart').getContext('2d');
            const productChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Salgados', 'Bebidas', 'Doces'],
                    datasets: [{
                        label: 'Salgados',
                        data: [data.estoque.comida, 0, 0],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Bebidas',
                        data: [0, data.estoque.bebida, 0],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Doces',
                        data: [0, 0, data.estoque.doce],
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Erro ao carregar os dados:', error));
});
