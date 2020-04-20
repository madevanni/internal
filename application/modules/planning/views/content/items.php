<table id="dg" title="Items" class="easyui-datagrid" style="width:100%;height:250px" url="<?php echo $url ?>" toolbar="#toolbar" pagination="true" rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="id" width="50">ID</th>
            <th field="description" width="50">Description</th>
            <th field="item_type" width="50">Item Type</th>
            <th field="search_key" width="50">Search Key</th>
            <th field="item_group" width="50">Item Group</th>
            <th field="item_group_desc" width="50">Group Desc</th>
            <th field="unit" width="50">Unit</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newItem()">New Item</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editItem()">Edit Item</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyItem()">Remove Item</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Item Information</h3>
        <div style="margin-bottom:10px">
            <input name="ID" class="easyui-textbox" required="true" label="ID:" style="width:100%" disabled>
        </div>
        <div style="margin-bottom:10px">
            <input name="description" class="easyui-textbox" required="true" label="Description:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <input name="item_type" class="easyui-textbox" required="true" label="Item Type:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <input name="search_key" class="easyui-textbox" required="true" label="Search Key:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <input name="item_group" class="easyui-textbox" required="true" label="Item Group:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <input name="item_group_desc" class="easyui-textbox" required="true" label="Group Desc:" style="width:100%">
        </div>
        <div style="margin-bottom:10px">
            <input name="unit" class="easyui-textbox" required="true" label="Unit:" style="width:100%">
        </div>
    </form>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveItem()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>