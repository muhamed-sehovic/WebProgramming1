let FoodsService = {
    __initialize: function() {
        $.ajax({
            url: 'http://localhost/final-2025-fall/backend/rest/foods/report',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                FoodsService.renderFoodsTable(data);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching foods:', error);
            }
        });


    },

    renderFoodsTable: function(foods) {
        
        const tableBody = document.getElementById('foods-table');
        tableBody.innerHTML = ''; 

        foods.forEach(function(food) {
            tableBody.innerHTML += `
                <tr>
                    <td>${food.name}</td>
                    <td>${food.brand}</td>
                    <td><img src="${food.image_url}"></td>
                </tr>
            `
        });
    }
}