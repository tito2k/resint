
/*
jQuery("#rowed1").jqGrid({
   	url:'proveedor.php',
	datatype: "json",
   	colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
   	colModel:[
   		{name:'id',index:'id', width:55},
   		{name:'invdate',index:'invdate', width:90, editable:true},
   		{name:'name',index:'name', width:100,editable:true},
   		{name:'amount',index:'amount', width:80, align:"right",editable:true},
   		{name:'tax',index:'tax', width:80, align:"right",editable:true},		
   		{name:'total',index:'total', width:80,align:"right",editable:true},		
   		{name:'note',index:'note', width:150, sortable:false,editable:true}		
   	],
   	rowNum:10,
   	rowList:[10,20,30],
   	pager: '#prowed1',
   	sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
	editurl: "server.php",
	caption: "Basic Example"
});
jQuery("#rowed1").jqGrid('navGrid',"#prowed1",{edit:false,add:false,del:false});

jQuery("#ed1").click( function() {
	jQuery("#rowed1").jqGrid('editRow',"x1");
	this.disabled = 'true';
	jQuery("#sved1,#cned1").attr("disabled",false);
});
jQuery("#sved1").click( function() {
	jQuery("#rowed1").jqGrid('saveRow',"x1");
	jQuery("#sved1,#cned1").attr("disabled",true);
	jQuery("#ed1").attr("disabled",false);
});
jQuery("#cned1").click( function() {
	jQuery("#rowed1").jqGrid('restoreRow',"x1");
	jQuery("#sved1,#cned1").attr("disabled",true);
	jQuery("#ed1").attr("disabled",false);
});
*/

jQuery("#list2").jqGrid({
   	url:'proveedor.php',
	datatype: "json",
   	colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
   	colModel:[
   		{name:'id',index:'id', width:55},
   		{name:'invdate',index:'invdate', width:90},
   		{name:'name',index:'name asc, invdate', width:100},
   		{name:'amount',index:'amount', width:80, align:"right"},
   		{name:'tax',index:'tax', width:80, align:"right"},		
   		{name:'total',index:'total', width:80,align:"right"},		
   		{name:'note',index:'note', width:150, sortable:false}		
   	],
   	rowNum:10,
   	rowList:[10,20,30],
   	pager: '#pager2',
   	sortname: 'id',
    viewrecords: true,
    sortorder: "desc",
    caption:"JSON Example"
});
jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});

