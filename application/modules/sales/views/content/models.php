<table id="dg" title="My Models" toolbar="#toolbar" pagination="true" idField="id" rownumbers="false" data-options="url:'get_models',method:'GET',fitColumns:true,singleSelect:true">
    <thead>
        <tr>
            <th field="id" width="5">ID</th>
            <th field="name" width="50" editor="{type:'validatebox',options:{required:true}}">Model name</th>
            <th field="username" width="50">Created by</th>
            <th field="created_on" width="50">Created on</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow', 0)">New</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#dg').edatagrid('destroyRow')">Destroy</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
</div>

<!-- <table id="dg" title="My Models" class="easyui-datagrid" url="get_models" method="GET" toolbar="#toolbar" pagination="true" rownumbers="false" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th field="id" width="5">ID</th>
            <th field="name" width="50">Model name</th>
            <th field="created_by" width="50">Created by</th>
            <th field="created_on" width="50">Created on</th>
        </tr>
    </thead>
</table>
<div id="toolbar">
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newModel()">New Model</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editModel()">Edit Model</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyModel()">Remove Model</a>
</div>

<div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
    <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
        <h3>Model Information</h3>
        <div style="margin-bottom:10px">
            <input name="model" class="easyui-textbox" required="true" label="Model:" style="width:100%">
        </div>
        </div>
    </form>
</div>
<div id="dlg-buttons">
    <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveModel()" style="width:90px">Save</a>
    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div> -->