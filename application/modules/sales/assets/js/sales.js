function doSearchCustomer() {
    $('#dgCustomers').datagrid('load', {
        search_customer: $('#searchCustomer').val()
    });
}