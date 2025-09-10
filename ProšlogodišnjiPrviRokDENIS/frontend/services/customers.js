var CustomersService = {
    __initialize: function() {

        

        $.ajax({
            url: 'http://localhost/final-2025-fall/backend/rest/customers',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                CustomersService.renderCustomersTable(data);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching customers:', error);
            }
        });
    },

    renderCustomersTable: function(customers) {
        
        const customersList = document.getElementById('customers-list');
        customersList.innerHTML = ''; // Clear existing rows

        customers.forEach(function(customer) {
            customersList.innerHTML += `
                <option onclick="console.log(${customer.first_name})" value="${customer.id}">${customer.first_name} ${customer.last_name}</option>
            `;
        });


        customersList.addEventListener('change', function() {



            const selectedCustomerId = customersList.value;

            console.log(`Selected Customer ID: ${selectedCustomerId}`);
            

            if (selectedCustomerId) {
                $.ajax({
                    url: `http://localhost/final-2025-fall/backend/rest/customer/meals/${selectedCustomerId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        CustomersService.renderTable(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching customer meals:', error);
                    }
                });
            }
        });
    },

    renderTable: function(meals) {
        const mealsTable = document.getElementById('meals-table');
        mealsTable.innerHTML = ''; // Clear existing rows

        meals.forEach(function(meal) {
            mealsTable.innerHTML += `
                <tr>
                    <td>${meal.name}</td>
                    <td>${meal.brand}</td>
                    <td>${meal.created_at}</td>
                </tr>
            `;
        });
    },


    addCustomer : function (){
        
        console.log('Adding customer...'    );
        
        const addCustomerForm = document.getElementById('add-customer-form');

        addCustomerForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const first_name = document.getElementById('first_name').value;
            const last_name = document.getElementById('last_name').value;
            const birth_date = document.getElementById('birth_date').value;

            let data = {
                first_name: first_name,
                last_name: last_name,
                birth_date: birth_date
            }

            console.log('Form data:', data);
            

            $.ajax({
                url: 'http://localhost/final-2025-fall/backend/rest/customers/add',
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Customer added successfully:', response);
                    CustomersService.__initialize(); // Refresh the customers list
                },
                error: function(xhr, status, error) {
                    console.error('Error adding customer:', error);
                }
            });
        });
    },
}