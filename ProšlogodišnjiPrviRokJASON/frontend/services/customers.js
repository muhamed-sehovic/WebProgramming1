var CustomersService = {
  loadCustomers: function () {
    RestClient.get("/backend/rest/customers", function (customers) {
      let select = $("#customers-list");
      select.empty();
      select.append('<option selected disabled>Please select one customer</option>');

      customers.forEach((customer) => {
        select.append(
          `<option value="${customer.id}">${customer.first_name} ${customer.last_name}</option>`
        );
      });
    });
  },

  bindCustomerSelection: function () {
    $("#customers-list").on("change", function () {
      const customerId = $(this).val();

      RestClient.get(`/backend/rest/customer/meals/${customerId}`, function (meals) {
        let tbody = $("#customer-meals tbody");
        tbody.empty();

        meals.forEach((meal) => {
          tbody.append(`
            <tr>
              <td>${meal.food_name}</td>
              <td>${meal.food_brand}</td>
              <td>${meal.meal_date}</td>
            </tr>
          `);
        });
      });
    });
  },

  bindAddCustomerForm: function () {
    $("#add-customer-modal form").on("submit", function (e) {
      e.preventDefault();

      const newCustomer = {
        first_name: $("#first_name").val(),
        last_name: $("#last_name").val(),
        birth_date: $("#birth_date").val()
      };

      RestClient.post("/backend/rest/customers/add", newCustomer, function () {
        $("#add-customer-modal").modal("hide");
        toastr.success("Customer added successfully!");

        $("#add-customer-modal form")[0].reset();

        CustomersService.loadCustomers();
      });
    });
  },

  init: function () {
    this.loadCustomers();
    this.bindCustomerSelection();
    this.bindAddCustomerForm();
  }
};

$(document).ready(function () {
  CustomersService.init();
});
