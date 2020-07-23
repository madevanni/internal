<table class="easyui-datagrid" title="Business partners information" style="height: 500px" toolbar="#toolbar" data-options="pagination:true,rownumbers:true,singleSelect:true,url:'getPartners',method:'get',fitColumns:true">
    <thead>
        <tr>
            <th align="center" data-options="field:'id'" hidden>ID</th>
            <th align="left" data-options="field:'partners'" sortable="true">Business partners</th>
            <th align="left" data-options="field:'address'">Address</th>
            <th align="center" data-options="field:'zipcode'">Zipcode</th>
            <th align="center" data-options="field:'city'">City</th>
            <th align="center" data-options="field:'telephone'">Telephone</th>
            <th align="center" data-options="field:'country'">Country</th>
            <th align="center" data-options="field:'currency'">Currency</th>
            <th align="center" data-options="field:'role'">Role</th>
            <th align="center" data-options="field:'status'">Status</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newPartner()">New Partner</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editPartner()">Edit Partner</a>
    <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyPartner()">Remove Partner</a>
</div>