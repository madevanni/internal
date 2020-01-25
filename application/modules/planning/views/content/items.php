<div class="container">
    <div class="row">
        <table id="dg" class="easyui-datagrid" style="width:auto;height:400px"
               url="<?php echo site_url(SITE_AREA . '/content/planning/loadItems') ?>"
               title="Item - General" iconCls="icon-search" toolbar="#tb"
               rownumbers="true" pagination="true">
            <thead>
                <tr>
                    <th field="itemid" width="10%">ID</th>
                    <th field="itemdesc" width="50%%">Description</th>
                    <th field="itemtype" width="10%">Type</th>
                    <th field="itemgroup" width="10%">Group</th>
                    <th field="itemunit" width="5%">Unit</th>
                </tr>
            </thead>
        </table>
        <div id="tb" style="padding:3px">
            <span>Item ID:</span>
            <input id="itemid" style="line-height:26px;border:1px solid #ccc">
            <span>Item Group:</span>
            <input id="itemgroup" style="line-height:26px;border:1px solid #ccc">
            <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>
        </div>
    </div>
    
    <?php print_r($items); ?>
</div>