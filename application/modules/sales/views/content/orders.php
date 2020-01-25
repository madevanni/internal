<table id="sales" toolbar="#toolbarSales" class="easyui-datagrid" fit="true" 
       singleSelect="true" fitColumns="true" rowNumbers="false" pagination="true" 
       url="<?= site_url(SITE_AREA .'/content/sales/get_salesOrders') ?>" pageSize="50" 
       pageList="[25,50,75,100,125,150,200]" nowrap="false">
    <thead>
        <tr>
            <th field="orno" width="80">ID</th>
            <th field="order" width="100">Customer Order</th>
            <th field="customer" width="100">Business Partner</th>
            <th field="amount" width="100">Order Amount</th>
            <th field="status" width="50">Order Status</th>
            <th field="date" width="100">Order Date</th>
            <th field="delivery" width="100">Delivery Date</th>
            <th field="type" width="50">Order Type</th>
        </tr>
    </thead>
</table>
<div id="toolbarSales">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="newCustomer()">New</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editCustomer()">Edit</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyCustomer()">Destroy</a>
    <input  id="searchSales" class="easyui-searchbox" data-options="prompt:'Please Input Value',searcher:doSearchSales,
            inputEvents: $.extend({}, $.fn.searchbox.defaults.inputEvents, {
            keyup: function(e){
            var t = $(e.data.target);
            var opts = t.searchbox('options');
            t.searchbox('setValue', $(this).val());
            opts.searcher.call(t[0],t.searchbox('getValue'),t.searchbox('getName'));
            }
            })" style="width:50%;"></input>
</div>