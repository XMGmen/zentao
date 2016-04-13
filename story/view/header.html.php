<?php //include '../../common/view/header.lite.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<script language='Javascript'>
function loadProduct(productID)
{
    //loadProductModules(productID);
    loadProductPlans(productID);
    loadPlanProjects($('#plan').val());
}
function loadPlan(planID)
{
	//alert(1);
	loadPlanProjects(planID);
}

function loadProductModules(productID)
{
    moduleLink = createLink('tree', 'ajaxGetOptionMenu', 'productID=' + productID + '&viewtype=story&rootModuleID=0&returnType=html&needManage=true');
    $('#moduleIdBox').load(moduleLink, function(){$('#moduleIdBox #module').chosen(defaultChosenOptions);});
}

function loadProductPlans(productID)
{
    planLink = createLink('product', 'ajaxGetPlans', 'productID=' + productID + '&planID=' + $('#plan').val() + '&needCreate=true');
    $('#planIdBox').load(planLink, function(){$('#planIdBox #plan').chosen(defaultChosenOptions);});
}

function loadPlanProjects(planID)
{
    projectLink = createLink('productplan', 'ajaxGetProjects', 'planID=' + planID  + '&needCreate=true');
    $('#projectIdBox').load(projectLink, function(){$('#projectIdBox #project').chosen(defaultChosenOptions);});
}
$(function() 
{
    $("#reviewedBy").chosen(defaultChosenOptions);
    $("#mailto").chosen(defaultChosenOptions);
})
</script>
